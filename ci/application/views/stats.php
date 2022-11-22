<!DOCTYPE html>
<html>

<head>
    <title>Statistics</title>
    <!-- Import the Chart.js library for our graphs.-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Import JQuery for ajax interaction between the view and the controller -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Import the styleSheet-->
    <link rel="stylesheet" href="<?php echo base_url("assets/style.css") ?>">
    <!-- Import the sidebar Script-->
    <script src="<?php echo base_url("assets/script.js") ?>"></script>
</head>

<style>
    .graphs {
        display: grid;
        grid-template-columns: auto auto;
        padding: 10px;
        width: 100%;
        max-width: 500px;
        
    }

    canvas{
        background-color: white;
        border: 10px solid grey;
        border-spacing: 10px,20px;
        border-color: grey;
    }

    .stockTable {
        padding: 10px;
        text-align: center;
    }

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
        background-color: #ffff66
    }

    table {
        width: 100%;
    }

    th {
        padding-top: 10px;
        padding-bottom: 10px;
        background-color: #228B22;
        color: white;
        text-transform: capitalize;
    }

    caption {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
        color: white;
        background-color: #333;
        font-size: xx-large;
    }

    .popup {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 100px; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4); 
    }


    .Content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    }

    .closeTab {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    }
    
    .save {
        display:none;
        text-align: center;
    }
</style>
<script>

    function drawPieChart(xValues, yValues, id) {

        if (xValues.length == yValues.length) {
            var barColours = ["#003f5c", "#2f4b7c", "#665191", "#a05195", "#d45087", "#f95d6a", "#ff7c43", "#ffa600"];
            createCanvasElement(id);

            return new Chart(id, {
                type: "pie",
                data: {
                    labels: xValues,
                    datasets: [{
                        data: yValues,
                        backgroundColor: barColours
                    }]
                },
                options: {
                    plugins: {
                        title: {    
                            display: true,
                            text: id
                        }
                    }
                }
            });
        }
        return;


    }
    function drawLineGraph(xValues, yValues, id) {
        if (xValues.length == yValues.length) {
            var barColours = ["#003f5c", "#2f4b7c", "#665191", "#a05195", "#d45087", "#f95d6a", "#ff7c43", "#ffa600"];
            createCanvasElement(id);

            return new Chart(id, {
                type: "line",
                data: {
                    labels: xValues,
                    datasets: [{
                        data: yValues,
                        label: 'Monthly income in £',
                        borderColor: 'rgb(75, 192, 192)',
                        fill: true
                    }]
                },
                options: {
                    plugins: {
                        title: {    
                            display: true,
                            text: id
                        }
                    }
                }
            });
        }
        return;

        function drawStackedBarChart(xValues, yValues, id) {

        }
    }

    //TODO: currently using random colours if more than 8 is needed, definitely need to find a better solution (look at Canvas patterns or maybe a library that works)
    /*function generateRandomGraphColours(qty) {
        var colours = []
        for (let i = 0; i < qty; i++) {
            //divide 16777215 (the largest possible hex code, for pure white) by 2 to (hopefully) get darker colours (more fitting on graph)
            colours[i] = "#" + Math.floor(Math.random() * (16777215 / 2)).toString(16);
        }
        return colours;
    }
    */

    function createCanvasElement(id) {
        var canvas = document.createElement("canvas")
        canvas.id = id;
        canvas.width = 300;
        canvas.height = 300;
        document.getElementById("graphs").appendChild(canvas);
    } 

    function openForm(button_id){
        if(button_id == "Expense Button") {
        document.getElementById("ExpensePopup").style.setProperty('display','block');
        } else if(button_id == "Income Button") {
        document.getElementById("IncomePopup").style.setProperty('display','block');
        }
    }

    function editRow(id) {
        document.getElementById("editButton"+id).style.display="none";
        document.getElementById("saveButton"+id).style.display="block";

        var row = document.getElementById("row"+id);
        var children = row.getElementsByTagName("td");

        
        var name = children[0];
        var quantity = children[1];
        var needed = children[2];
        var itemCost = children[3];

        var currentName = children[0].innerHTML;
        var currentQuantity = children[1].innerHTML;
        var currentNeeded = children[2].innerHTML;
        var currentItemCost = children[3].innerHTML;

        name.innerHTML="<input type='text' value='"+currentName+"'>";
        quantity.innerHTML="<input type='text' value='"+currentQuantity+"'>";
        needed.innerHTML="<input type='text' value='"+currentNeeded+"'>";
        itemCost.innerHTML="<input type='text' value='"+currentItemCost+"'>";
        
    }

    function deleteRow(id) {
        document.getElementById("row"+id).outerHTML="";

        $.ajax({
            url: '<?php echo base_url("index.php/Stats/hideStockItem") ?>',
            method: 'post',
            data: {id: id},
            success:function(){
                alert("delete successful");
            }
        });
    }

    function addRow() {

        var newItemName = document.getElementById("newItemName").value;
        var newQuantity = document.getElementById("newQuantity").value;
        var newNeeded = document.getElementById("newNeeded").value;
        var newItemCost = document.getElementById("newItemCost").value;

        if(newItemName == "") {
            alert("Please enter the name of the item");
            return false;
        } else if (newQuantity == "") {
            alert("Please enter the quantity of the item");
            return false;
        } else if (isNaN(newQuantity)){
            alert("Please enter a number for the quantity");
            return false;
        } else if (newNeeded == "") {
            alert("Please enter the amount of this item that is needed");
            return false;
        } else if (isNaN(newNeeded)){
            alert("Please enter a number for the needed");
            return false;
        }else if (newItemCost == "") {
            alert("Please enter the cost per unit of the item");
            return false;
        }else if (isNaN(newItemCost)){
            alert("Please enter a number for the cost");
            return false;
        }

        $.ajax({
            url: '<?php echo base_url("index.php/Stats/postStock")?>',
            method: 'post',
            data: {ItemName: newItemName, 
                Needed: newNeeded,
                ItemCost: newItemCost,    
                Quantity: newQuantity,
            },
            success:function(response) {
                var table =document.getElementById("table");
                var newRow = table.insertRow((table.rows.length)-1).outerHTML="<tr id='row"+response+"'><td>"+newItemName+"</td><td>"+newQuantity+"</td><td>"+newNeeded+"</td><td>"+newItemCost+"</td><td> <button type = 'button' onclick='editRow("+response+")'> Edit </button> <br> <button type = 'button' onclick = 'deleteRow("+response+")'> Delete </button> </td> </tr>";

                document.getElementById("newItemName").value="";
                document.getElementById("newQuantity").value="";
                document.getElementById("newNeeded").value="";
                document.getElementById("newItemCost").value="";
            },
        })                
    }

    function saveRow(id) {
        document.getElementById("editButton"+id).style.display="none";
        document.getElementById("saveButton"+id).style.display="block";

        var row = document.getElementById("row"+id);
        var children = row.getElementsByTagName("td");

        
        var newName =  children[0].firstChild.value;
        var newQuantity= children[1].firstChild.value;
        var newNeeded = children[2].firstChild.value;
        var newItemCost = children[3].firstChild.value;

        children[0].innerHTML = newName;
        children[1].innerHTML = newQuantity;
        children[2].innerHTML = newNeeded;
        children[3].innerHTML = newItemCost;

        $.ajax({
            url: '<?php echo base_url("index.php/Stats/saveStock")?>',
            method: 'post',
            data: {ItemName: newName, 
                Needed: newNeeded,
                ItemCost: newItemCost,    
                Quantity: newQuantity,
                ItemID: id,
            },
            success:function(){
                alert("update successful");
            }

        })
        
        document.getElementById("editButton"+id).style.display="block";
        document.getElementById("saveButton"+id).style.display="none";
    }

</script>

<body>

<?php include("assets/nav.html");?>

        <div id="graphs" class="graphs">
            <script>
                var index = 0;
                const income = [];
                <?php foreach($incomeData as $month => $income) { ?>
                    income[index]= <?php echo $income?>;
                    index++;
                <?php } ?>
                index = 0;
                const expenseNames = [];
                const expenses = [];
                <?php foreach($expensesData as $expenseData) { ?>
                    expenseNames[index]= "<?php echo $expenseData['Name']?>";
                    expenses[index]= <?php echo $expenseData['Amount']?>;
                    index++;
                <?php } ?>
                //We can echo in values and loop using php to dynamically generate this list
                drawPieChart(expenseNames, expenses, "Expenses")
                
                drawLineGraph(["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"], income, "Income")
                
            </script>
            <button type="button" id="Expense Button" onclick="openForm(this.id)">Report Expenses</button>
            <button type="button" id="Income Button" onclick="openForm(this.id)">Report Income</button>
        </div>

        <div id="stockTable">
            <!--This table can be populated with php echo statements and loops. for now a few examples-->
            <table id="table">
                <caption>Stock</caption>
                <tr> 
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Needed</th>
                    <th>cost per unit</th>
                    <th></th>
                </tr>
                <?php foreach($stockData as $row) { ?>
                <tr id = "row<?php echo $row['ItemID']?>">
                    <td><?php echo $row['ItemName'] ?></td>
                    <td><?php echo $row['Quantity'] ?></td>
                    <td><?php echo $row['Needed'] ?></td>
                    <td><?php echo $row['ItemCost']?></td>
                    <td> <button type ="button" id="editButton<?php echo $row['ItemID']?>" onclick = "editRow(<?php echo $row['ItemID']?>)">Edit</button> <br>
                        <button type = "button" id="saveButton<?php echo $row['ItemID']?>" onclick="saveRow(<?php echo $row['ItemID']?>)" class="save"> Save </button>
                        <button type = "button" onclick = "deleteRow(<?php echo $row['ItemID']?>)"> Delete </button> 
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <td><input type="text" id="newItemName"></td>
                    <td><input type="text" id="newQuantity"></td>
                    <td><input type="text" id="newNeeded"></td>
                    <td><input type="text" id="newItemCost"></td>
                    <td><input type="button" class="add" onclick="addRow();" value="Add Row"></td>
                </tr>
            </table>
        </div>
    </div>

    <div id="ExpensePopup" class="popup">
        <div id="Expense_Content" class = "Content">
        <span class="closeTab" id="closeExpenseTab">&times;</span>
            <h1>Report Expense</h1>

            <form action="postExpense" method="POST">
                <label for="expense name">Expense Name: </label> <br>
                <input type = "text" name="expenseName" required> <br>
                <label for="expense amount">Amount: </label> <br>
                <input type ="number" name="expenseAmount" step="0.01" required> <br>
                <label for="expense date">Date: </label> <br>
                <input type = "date" name="expenseDate" required> <br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
   
    <div id="IncomePopup" class ="popup">
        <div id="Income_Content" class = "Content">
        <span class="closeTab" id="closeIncomeTab">&times;</span>
            <h1>Report Income</h1>

            <form action="postIncome" method="POST">
                <label for="incomeSource">Income Source: </label> <br>
                <input type = "text" name="incomeSource" required> <br>
                <label for="incomeAmount">Amount: </label> <br>
                <input type ="number" name="incomeAmount" step="0.01" required> <br>
                <label for="incomeDate">Date: </label> <br>
                <input type = "date" name="incomeDate" required> <br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>

    


</body>
<script>

    var closeExpenses = document.getElementById("closeExpenseTab");
    var closeIncome = document.getElementById("closeIncomeTab");

    closeExpenses.onclick = function() {
        document.getElementById("ExpensePopup").style.setProperty('display','none');
    }

    closeIncome.onclick = function() {
        document.getElementById("IncomePopup").style.setProperty('display','none');
    }

</script>
</html>