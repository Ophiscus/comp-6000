<!DOCTYPE html>
<html>

<head>
    <title>Statistics</title>
    <!-- Import the Chart.js library for our graphs.-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    function close(button_id){
        console.log("invoked")
        if(button_id == "closeExpenseTab") {
            document.getElementById("ExpensePopup").style.setProperty('display','none');
            console.log("yep");
        } else if (button_id == "closeIncomeTab") {
            document.getElementById("IncomePopup").style.setProperty('display','none');
        }
    }
</script>

<body>

    <!-- Sidebar setup-->
    <div id="main">
        <div id="mySidebar" class="sidebar">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">X</a>
            <a href="#">Maneger</a>
            <a href="#">Statistic</a>
            <a href="#">Calendar</a>
            <a href="#">Contact Us</a>
        </div>
        <div class="topnav">
            <button class="openbtn" onclick="openNav()">☰</button>
            <a class="active" href="#home">Home</a>
            <a href="#Announcements">Announcements</a>
            <a href="#contact">Contact Us</a>
            <a href="#about">About</a>
            <a href="#login">Login</a>
        </div>

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
            <table>
                <caption>Stock</caption>
                <tr> 
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Needed</th>
                    <th>cost per unit</th>
                </tr>
                <?php foreach($stockData as $row) { ?>
                <tr>
                    <td><?php echo $row['ItemName'] ?></td>
                    <td><?php echo $row['Quantity'] ?></td>
                    <td><?php echo $row['Needed'] ?></td>
                    <td><?php echo $row['ItemCost']?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <div id="ExpensePopup" class="popup">
        <div id="Expense_Content" class = "Content">
        <span class="closeTab" id="closeExpenseTab">&times;</span>
            <h1>Report Expense</h1>
        </div>
    </div>
   
    <div id="IncomePopup" class ="popup">
        <div id="Income_Content" class = "Content">
        <span class="closeTab" id="closeIncomeTab">&times;</span>
            <h1>Report Income</h1>
        </div>
    </div>



</body>
<script>

    var closeExpenses = document.getElementById("closeExpenseTab");
    var closeIncome = document.getElementById("closeIncomeTab");

    closeExpenses.onclick = function() {
        document.getElementById("ExpensePopup").style.setProperty('display','none');
    }

    closeIncome.onClick = function(){
        document.getElementById("IncomePopup").style.setProperty('display','none');
    }

</script>
</html>