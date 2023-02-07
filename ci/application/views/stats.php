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
    <link rel="stylesheet" href="<?php echo base_url("assets/nav_style.css") ?>">
    <!-- Import the sidebar Script-->
    <script src="<?php echo base_url("assets/nav.js") ?>"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<style>
    .graphs {
        display: grid;
        grid-template-columns: auto auto;
        grid-template-rows: 3vw 30vw;
        padding: 0.5vw;
        width: 100%;
        max-width: 30vw;
        
    }

    .filler, .icons {
        background-color: white;
        border: 0.4vw solid #9C8C8C;
    }

    .graphs > .icons > #next{
        float: right;
        padding-right: 0.7vw;
    }

    #rowButtons{
        display: grid;
        grid-template-columns: auto;
    }

    canvas{
        background-color: white;
        border: 0.5vw solid grey;
        border-spacing: 1vw,2vw;
        border-color: grey;
    }

    .stockTable {
        padding: 0.5vw;
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

    #RecoveryTable th, #RecoveryTable td {
        background-color: white;
        color: black
    }

    table {
        width: 100%;
    }

    th {
        padding-top: 2vw;
        padding-bottom: 2vw;
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
    
    .editing {
        display:none;
        text-align: center;
    }
</style>
<script>

    expenseChart;
    incomeChart;
    function drawPieChart(xValues, yValues, id) {

        if (xValues.length == yValues.length) {
            var barColours = ["#003f5c", "#2f4b7c", "#665191", "#a05195", "#d45087", "#f95d6a", "#ff7c43", "#ffa600"];
            createCanvasElement(id);

            expenseChart = new Chart(id, {
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
                            text: id + " for " + expenseYear
                        }
                    }
                }
            });

            return expenseChart;
        }
        return;


    }
    function drawLineGraph(xValues, yValues, id) {
        if (xValues.length == yValues.length) {
            var barColours = ["#003f5c", "#2f4b7c", "#665191", "#a05195", "#d45087", "#f95d6a", "#ff7c43", "#ffa600"];

            incomeChart = new Chart(id, {
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
                            text: id + " for " + incomeYear
                        }
                    }
                }
            });

            return incomeChart;
        }
        return;

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
        } else if(button_id == "Recover Button") {
            document.getElementById("RecoveryPopup").style.setProperty('display','block');
        }
    }

    
    var editing = false;
    var rowEditingID;
    var originalName;
    var originalQuant;
    var originalNeeded;
    var originalCostPerUnit;

    function editRow(id) {

        if(editing) {
            cancelRow(rowEditingID);
        }
        editing = true;
        rowEditingID = id;

        document.getElementById("editButton"+id).style.display="none";
        document.getElementById("saveButton"+id).style.display="block";
        document.getElementById("deleteButton"+id).style.display="none";
        document.getElementById("cancelButton"+id).style.display="block";

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

        originalName = currentName;
        originalQuant = currentQuantity;
        originalNeeded = currentNeeded;
        originalCostPerUnit = currentItemCost;

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

    function cancelRow(id) {

        var row = document.getElementById("row"+id);
        var children = row.getElementsByTagName("td");

        children[0].innerHTML = originalName;
        children[1].innerHTML = originalQuant;
        children[2].innerHTML = originalNeeded;
        children[3].innerHTML = originalCostPerUnit;

        editing = false;
        rowEditingID = null;
        originalName = "";
        originalQuant = "";
        originalNeeded = "";
        originalCostPerUnit = "";

        document.getElementById("editButton"+id).style.display="block";
        document.getElementById("saveButton"+id).style.display="none";
        document.getElementById("deleteButton"+id).style.display="block";
        document.getElementById("cancelButton"+id).style.display="none";
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
                var newRow = table.insertRow((table.rows.length)-1).outerHTML="<tr id='row"+response+"'><td>"+newItemName+"</td><td>"+newQuantity+"</td><td>"+newNeeded+"</td><td>"+newItemCost+"</td><td> <button type = 'button' onclick='editRow("+response+")'> Edit </button> <button type = 'button' onclick = 'deleteRow("+response+")'> Delete </button>  </td> </tr>";

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
        document.getElementById("deleteButton"+id).style.display="block";
        document.getElementById("cancelButton"+id).style.display="none";
    }

    function reRenderChart(chart,labels,data,title) {
        
        
        chart.data.datasets.pop();
        

        var displayYear;

        if(title === "Income") {
            chart.data.datasets.push({
                labels:labels,
                label: "Monthly income in £",
                data:data
            })
            displayYear = incomeYear;
        } else {
            chart.data.labels = labels;
            chart.data.datasets.push({
                data:data
            })
            displayYear = expenseYear;
        }
        chart.options.plugins.title.text = title + " for " + displayYear;
        chart.update();
    }

    function recoverItem(id) {
        $.ajax({
            url: '<?php echo base_url("index.php/Stats/restoreStock")?>',
            method: 'post',
            data: {id: id},
            success:function(){
                alert("recovery successful");
            }
        })
    }

    function deleteRecoveryItem(id) {
        $.ajax({
            url:'<?php echo base_url("index.php/Stats/deleteHiddenStock")?>',
            method: 'post',
            data: {id: id},
            success:function(){
                alert("Deleted");
            }
        })
    }

</script>

<body>

<?php include("assets/nav.html");?>

    <div id="main" class="main">
        <div id="graphs" class="graphs">
            <div id="expense-icons" class = "icons">
            <span id="prev" class="material-symbols-rounded">chevron_left</span>
                <span id="next" class="material-symbols-rounded">chevron_right</span>
            </div>
            <div id="income-icons" class = "icons">
                <span id="prev" class="material-symbols-rounded">chevron_left</span>
                <span id="next" class="material-symbols-rounded">chevron_right</span>
            </div>
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
                
                var incomeYear = new Date().getFullYear();
                var expenseYear = new Date().getFullYear();

                //We can echo in values and loop using php to dynamically generate this list
                drawPieChart(expenseNames, expenses, "Expenses")
                
                createCanvasElement("Income");

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
                    <th><button type = "button" id = "Recover Button" onclick="openForm(this.id)" > Recover Deleted </button></th>
                </tr>
                <?php foreach($stockData as $row) { ?>
                <tr id = "row<?php echo $row['ItemID']?>">
                    <td><?php echo $row['ItemName'] ?></td>
                    <td><?php echo $row['Quantity'] ?></td>
                    <td><?php echo $row['Needed'] ?></td>
                    <td><?php echo $row['ItemCost']?></td>
                    <td> 
                        <div id = "rowButtons">
                        <button type ="button" id="editButton<?php echo $row['ItemID']?>" onclick = "editRow(<?php echo $row['ItemID']?>)">Edit</button>
                        <button type = "button" id="saveButton<?php echo $row['ItemID']?>" onclick="saveRow(<?php echo $row['ItemID']?>)" class="editing"> Save </button>
                        <button type = "button" id="deleteButton<?php echo $row['ItemID']?>" onclick = "deleteRow(<?php echo $row['ItemID']?>)"> Delete </button> 
                        <button type = "button" id="cancelButton<?php echo $row['ItemID']?>" onclick="cancelRow(<?php echo $row['ItemID']?>)" class="editing"> Cancel </button>
                        </div>
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

    <div id="RecoveryPopup" class="popup">
        <div id="Recover_Content" class="Content">
        <span class="closeTab" id="closeRecoveryTab">&times;</span>
            <h1>Deleted Items</h1>
        
            <div id="RecoveryItems">
                <table id="RecoveryTable">
                    <tr>
                        <th>Item Name</th>
                        <th>Restore</th>
                        <th>Delete</th>
                    </tr>
                    <tr>
                        <?php foreach($recoveryItems as $recoveryItem) { ?>
                            <tr> 
                            <td><?php echo $recoveryItem['ItemName'] ?></td>
                            <td><span class="material-symbols-outlined" onclick = "recoverItem(<?php echo $recoveryItem['ItemID']?>)">restore_from_trash</span></td>
                            <td><span class="material-symbols-outlined" onclick = "deleteRecoveryItem(<?php echo $recoveryItem['ItemID']?>)">delete_forever</span></td>
                            </tr>
                        <?php } ?>
                    </tr>
                </table>
            </div>
        
        </div>

    </div>

    


</body>
<script>

    var closeExpenses = document.getElementById("closeExpenseTab");
    var closeIncome = document.getElementById("closeIncomeTab");
    var closeRecovery = document.getElementById("closeRecoveryTab");

    closeExpenses.onclick = function() {
        document.getElementById("ExpensePopup").style.setProperty('display','none');
    }

    closeIncome.onclick = function() {
        document.getElementById("IncomePopup").style.setProperty('display','none');
    }

    closeRecovery.onclick = function() {
        document.getElementById("RecoveryPopup").style.setProperty('display','none');
    }

    swapYearIcons = document.querySelectorAll("#income-icons span");

    //add event listeners to chevrons for graph update functionality
    swapYearIcons.forEach(icon => {
        icon.addEventListener("click", () => {
            if(icon.id === "prev") {
                incomeYear = incomeYear - 1;
            } else if(icon.id === "next") {
                incomeYear = incomeYear + 1;
            }
            
            //retrieve new income data
            $.ajax({
                url: '<?php echo base_url("index.php/Stats/getYearlyIncome")?>',
                method: 'get',
                data: {year: incomeYear},
                dataType: 'json',
                success: function(data) {
                    reRenderChart(incomeChart,Object.keys(data),[data.January,data.February,data.March,data.April,data.May,data.June,data.July,data.August,data.September,data.October,data.November,data.December],"Income");
                }
            })
        })
    });

    swapYearIcons = document.querySelectorAll("#expense-icons span");

    swapYearIcons.forEach(icon => {
        icon.addEventListener("click", () => {
            if(icon.id === "prev") {
                expenseYear = expenseYear - 1;
            } else if(icon.id === "next") {
                expenseYear = expenseYear + 1;
            }

            $.ajax({
                url: '<?php echo base_url("index.php/Stats/getYearlyExpense")?>',
                method: 'get',
                data: {year:expenseYear},
                dataType: 'json',
                success:function(data) {
                    var values = [];
                    var names = [];
                    for(let i =0; i<data.length;i++) {
                        values[i] = data[i].Amount;
                        names[i] = data[i].Name;
                    }
                    
                    reRenderChart(expenseChart,names,values, "Expenses");
                }
            })
        })
    })
</script>
</html>