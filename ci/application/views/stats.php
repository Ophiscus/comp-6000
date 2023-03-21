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
        width: 50%;
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
    padding-top: 100px; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0,0,0,0.4); 
    }


    .Content {
    background-color: #FFFDD0;
    margin: auto;
    border: 3px solid;
    width: 60%;
    text-align: center;
    padding-top: 1vw;
    padding-bottom: 1vw;
    }

    .closeTab {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    padding-right: 1%;
    }
    
    .editing {
        display:none;
        text-align: center;
    }
</style>
<script>

    //storing our charts for access in functions
    expenseChart;
    incomeChart;

    //draw a piechart using chart js
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

    //draw a line graph using chart js
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


    //create a canvas element to put a graph in
    function createCanvasElement(id) {
        var canvas = document.createElement("canvas")
        canvas.id = id;
        canvas.width = 300;
        canvas.height = 300;
        document.getElementById("graphs").appendChild(canvas);
    } 

    //open one of the three forms on the page, depending on the button id
    function openForm(button_id){
        if(button_id == "Expense Button") {
            document.getElementById("ExpensePopup").style.setProperty('display','inline-block');
        } else if(button_id == "Income Button") {
            document.getElementById("IncomePopup").style.setProperty('display','inline-block');
        } else if(button_id == "Recover Button") {
            //the recover button will make a call to the database to get recoverable items, present them in a table with options to delete or restore them
            $.ajax({
                url: '<?php echo base_url("index.php/Stats/getHidden")?>',
                method: 'get',
                dataType: 'json',
                success: function(items) {
                    var recoveryPopup = document.getElementById("RecoveryPopup");
                    var recoveryTable = $("#RecoveryTable");
                    recoveryPopup.style.setProperty('display','block');
                    recoveryTable.find("tr:gt(0)").remove();
                    for(var i=0; i<items.length; i++) {
                        var newRow = document.createElement("tr");
                        var newCell1 = document.createElement("td");
                        var newCell2 = document.createElement("td");
                        var newCell3 = document.createElement("td");
                        newCell1.innerHTML = items[i]["ItemName"];
                        newCell2.innerHTML = '<span class="material-symbols-outlined" onclick = "recoverItem('+ items[i]["ItemID"] +')">restore_from_trash</span>';
                        newCell3.innerHTML = '<span class="material-symbols-outlined" onclick = "deleteRecoveryItem(' + items[i]["ItemID"] + ')">delete_forever</span>';
                        newRow.append(newCell1);
                        newRow.append(newCell2);
                        newRow.append(newCell3);
                        recoveryTable[0].appendChild(newRow);
                    }
                }
            })
        }
    }

    
    //controlls for editing table values, so they can be reverted on a cancel.
    var editing = false;
    var rowEditingID;
    var originalName;
    var originalQuant;
    var originalNeeded;
    var originalCostPerUnit;

    //function to turn row into an editable 
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

    //makes a call to the database to delete the table row with matching id
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

    //cancels editing and restores original values
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

    //checks if new values are all inserted and valid at the field row, then if they are, requests to add them to the database
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

    //saves changes to the row corresponding to the id and restoresit to a non-editing state
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

    //refreshes and updates a chart, used for rendering charts for different months
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

    //sends a request to restore an item with the given id and the repopulates the stock table accordingly
    function recoverItem(id) {
        $.ajax({
            url: '<?php echo base_url("index.php/Stats/restoreStock")?>',
            method: 'post',
            data: {id: id},
            success:function(){
                alert("recovery successful");
            }
        })

        //repopulate the existing stock table
        $.ajax({
            url: '<?php echo base_url("index.php/Stats/getStock")?>',
            method: 'get',
            dataType: 'json',
            success:function(items){
                var stockTable = $("#table");
                stockTable.find("tr:gt(0)").remove();
                for(let i=0; i<items.length; i++) {
                    let newRow = document.createElement("tr");
                    newRow.id = "row"+items[i]["ItemID"];
                    let newCell1 = document.createElement("td");
                    let newCell2 = document.createElement("td");
                    let newCell3 = document.createElement("td");
                    let newCell4 = document.createElement("td");
                    let newCell5 = document.createElement("td");
                    newCell1.innerHTML = items[i]["ItemName"];
                    newCell2.innerHTML = items[i]["Quantity"];
                    newCell3.innerHTML = items[i]["Needed"];
                    newCell4.innerHTML = items[i]["ItemCost"];
                    
                    let buttonDiv = document.createElement("div");
                    buttonDiv.id = "rowButtons"
                    newCell5.append(buttonDiv);

                    let itemID = items[i]["ItemID"];
                    let editButton = document.createElement('input');
                    editButton.type = "button";
                    editButton.id = "editButton"+itemID;
                    editButton.addEventListener("click",function(){editRow(itemID);});
                    editButton.value = "Edit";
                    buttonDiv.append(editButton);

                    let saveButton = document.createElement('input');
                    saveButton.type = "button";
                    saveButton.id = "saveButton"+itemID;
                    saveButton.addEventListener("click",function(){saveRow(itemID);});
                    saveButton.value = "Save";
                    saveButton.className = "editing";
                    buttonDiv.append(saveButton);

                    let deleteButton = document.createElement('input');
                    deleteButton.type = "button";
                    deleteButton.id = "deleteButton"+itemID;
                    deleteButton.addEventListener("click",function(){deleteRow(itemID);});
                    deleteButton.value = "Delete";
                    buttonDiv.append(deleteButton);

                    let cancelButton = document.createElement('input');
                    cancelButton.type = "button";
                    cancelButton.id = "cancelButton"+itemID;
                    cancelButton.addEventListener("click",function(){cancelRow(itemID);});
                    cancelButton.value = "Cancel";
                    cancelButton.className = "editing";
                    buttonDiv.append(cancelButton);

                    newRow.append(newCell1);
                    newRow.append(newCell2);
                    newRow.append(newCell3);
                    newRow.append(newCell4);
                    newRow.append(newCell5);
                    stockTable[0].appendChild(newRow);
                }

                let newRow = document.createElement("tr");

                let newCell1 = document.createElement("td");
                let newCell2 = document.createElement("td");
                let newCell3 = document.createElement("td");
                let newCell4 = document.createElement("td");
                let newCell5 = document.createElement("td");
                
                let newIn1 = document.createElement('input');
                newIn1.type = "text";
                let newIn2 = document.createElement('input');
                newIn2.type = "text";
                let newIn3 = document.createElement('input');
                newIn3.type = "text";
                let newIn4 = document.createElement('input');
                newIn4.type = "text";
                newIn1.id = "newItemName";
                newIn2.id = "newQuantity";
                newIn3.id = "newNeeded";
                newIn4.id = "newItemCost";

                let newIn5 = document.createElement("input");
                newIn5.type = "button";
                newIn5.className = "add";
                newIn5.value = "Add Row";
                newIn5.addEventListener("click",addRow);

                newCell1.append(newIn1);
                newRow.append(newCell1);
                newCell2.append(newIn2);
                newRow.append(newCell2);
                newCell3.append(newIn3);
                newRow.append(newCell3);
                newCell4.append(newIn4);
                newRow.append(newCell4);
                newCell5.append(newIn5);
                newRow.append(newCell5);
            
                stockTable[0].appendChild(newRow);
                
            }
        })
    }

    //sends a request for the given item to be permanently deleted
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
                //get our data from the controller for our graphs
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
                
                //get our current year
                var incomeYear = new Date().getFullYear();
                var expenseYear = new Date().getFullYear();

               //draw our graphs
                drawPieChart(expenseNames, expenses, "Expenses")
                
                createCanvasElement("Income");

                drawLineGraph(["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"], income, "Income")
            
              
            </script>
            <!-- add our buttons -->
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
                <!--populate the stock table with items from the database -->
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

    <!--popup forms for expenses and income, submits to the controller methods to add to the db -->
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
                </table>
            </div>
        
        </div>

    </div>

    


</body>
<script>

    //add onclick functions to close the popup forms
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

    //make the arrows swap the year for each graph.
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