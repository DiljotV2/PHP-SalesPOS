<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>visualization</title>
</head>
<script src = "https://cdn.jsdelivr.net/npm/chart.js@3.2.1/dist/chart.min.js"></script>
<body>
    <header>
        <h2>
            <nav>
                <a href = "/Dashboard.php" id = "dashboard">Dashboard</a>
                <a href = "/Sales.php" id = "sales">Sales</a>
                <a href = "/Inventory.php" id = "inventory">Inventory</a>
                <a href = "/Visualization.php" id = "visualization">Visualization</a>
                <a href = "/Report.php" id = "reports">Reports</a>
            </nav>
        </h2>
    </header>
    <h1>VISUALIZATIONS</h1>
   

     <table>
        <tr>
            <th width = "20%"><h2>TOTAL TILL NOW IN THIS MONTH</h2></th>
            <th width = "40%"><h2>PREDICTION BY THE END OF THIS MONTH</h2></th>
        </tr>
        <tr>
            <td width = "20%" style = "text-align: center;"><h3>A$40,000.25</h3></td><!--hardcoded value for now-->
            <td width = "40%" style = "text-align: center;"><h3>A$37,900.75</h3></td><!--hardcoded value for now-->
        </tr>
    
    </table>
    <!--<form action="" method = "POST">-->
        <button id = "sales_visual_button" name = "sales_button" onClick = "onSalesVisualClick()">Sales</button>
        <button id = "inventory_visual_button" name = "inventory_visual_button" onClick = "onInventoryVisualClick()" >Inventory</button>
        <br><br><br>
        <p id = "buttons" name = "buttons"></p>

    <!--</form>-->
    <?php
        //echo "Php being used??";
        //it is used for creating a dictionary
        $conn = @mysqli_connect ("localhost","root","root","login");	// Log in and use database
	if ($conn) { // check is database is avialable for use
		$query = "Select * from salesdata";		// query is assigned here
		$result = mysqli_query ($conn, $query);
        $monthlyDataArray = array();
        $keylist = array();
		while($rows = $result->fetch_assoc()){
            foreach($monthlyDataArray as $x => $val) {
                array_push($keylist, $x);
            }

            if (in_array("".$rows['Date']."", $keylist))
            {
                $monthlyDataArray["".$rows['Date'].""] += "".$rows['TotalPrice']."";
            }
            else
            {
                $monthlyDataArray += array("".$rows['Date']."" => "".$rows['TotalPrice']."");
            }
        }
        /*echo "<script>\n";
        echo "console.log('->', ".json_encode($monthlyDataArray).");";
        echo "</script>";*/

        $sql = "Select * from inventorydata";
		$result_inventory = mysqli_query ($conn, $sql);
        $inventoryDataArray = array();
        while($inventory_rows = $result_inventory->fetch_assoc()){
            $inventoryDataArray += array("".$inventory_rows['Name']."" => array("".$inventory_rows['Stocks'].", ".$inventory_rows['PricePerProduct'].""));
        }

        echo "<script>\n";
        echo "console.log('->', ".json_encode($inventoryDataArray).");";
        echo "</script>";

		mysqli_close ($conn);					// Close the database connect
	} else {
		echo "<p>Unable to connect to the database.</p>";
	}
    ?>
    
    <p>There will be graphs</p>
    <canvas id = "chart" width = "50" height = "50"></canvas>
    <script>

    var chartInUse;
    var inventoryArray = <?php echo json_encode($inventoryDataArray); ?>;
    console.log("This is inventory array");
    console.log(inventoryArray);


    var something = <?php echo json_encode($monthlyDataArray); ?>;
    console.log(something);


    function destroyChart(chart){
        chart.destroy();
    }

    function onSalesVisualClick(){
        console.log("onSalesVisualClick is being used");
        var buttons = "        <button id = 'weekly_visual_button' name = 'weekly_visual_button' onClick = 'onWeeklyVisualClick()' >Weekly</button>";
        buttons += "     <button id = 'monthly_visual_button' name = 'monthly_visual_button' onClick = 'onMonthlyVisualClick()' >Monthly</button>";
        buttons += "     <button id = 'yearly_visual_button' name = 'yearly_visual_button' onClick = 'onYearlyVisualClick()'>Yearly</button>";
		document.getElementById("buttons").innerHTML = buttons;
    }

    function onInventoryVisualClick(){
        console.log("onInventoryVisualClick is being used");
        var buttons = "     <button id = 'stocks_visual_button' name = 'stocks_visual_button' onClick = 'onStockVisualClick()' >Stocks</button>";
        buttons += "     <button id = 'pricePerProduct_visual_button' name = 'pricePerProduct_visual_button' onClick = 'onPricePerProductVisualClick()' >Price Per Product</button>";
		document.getElementById("buttons").innerHTML = buttons;
    
    }

    function onStockVisualClick(){
        if(chartInUse){
            destroyChart(chartInUse);
        }

        console.log("onStockVisualClick is being used");


        var somehtin_else = inventoryNameStockArray(inventoryArray);
        var nameStockKeys = Object.keys(somehtin_else);
        var nameStockValues = Object.values(somehtin_else);

        chartInUse = showChart("Product's Stocks", nameStockKeys, nameStockValues,  "");//this works

    }

    function inventoryNameStockArray(inventory_array){

        var nameStockArray = [];
        for (const [key, value] of Object.entries(inventory_array)) {
            var stock = value[0].split(",");
            //console.log("This is some stuff " + stock[0] + "in the spacing");
            nameStockArray[key] = stock[0];
        }

        return nameStockArray;
    }


    function onPricePerProductVisualClick(){
        if(chartInUse){
            destroyChart(chartInUse);
        }

        var array = inventoryNamePricePerProductArray(inventoryArray);
        var namePricePerProductKeys = Object.keys(array);
        var namePricePerProductValues = Object.values(array);

        chartInUse = showChart("Price Per Product", namePricePerProductKeys, namePricePerProductValues,  "A$");//this works

    }

    function inventoryNamePricePerProductArray(inventory_array){
        var namePricePerProductArray = [];
        for (const [key, value] of Object.entries(inventory_array)) {
            var pricePerProduct = value[0].split(",");
            namePricePerProductArray[key] = pricePerProduct[1];
        }

        return namePricePerProductArray;
    }

    function onWeeklyVisualClick(){
        if(chartInUse){
            destroyChart(chartInUse);
        }
		var weeklyArrayHahaa = salesDataInArrayAccordingToKeyWeekValues(something);
        var weeklyKeys = Object.keys(weeklyArrayHahaa);
        var weeklyValues = Object.values(weeklyArrayHahaa);

        chartInUse = showChart("This Week sales Chart",weeklyKeys, weeklyValues,  "A$");//this works

    }

    function onMonthlyVisualClick(){
        if(chartInUse){
            destroyChart(chartInUse);
        }
        var monthlyArrayHahaa = salesDataInArrayAccordingToKeyMonthValues(something);
        var monthlyKeys = Object.keys(monthlyArrayHahaa);
        var monthlyValues = Object.values(monthlyArrayHahaa);

        chartInUse = showChart("This Month sales Chart",monthlyKeys, monthlyValues,  "A$");//this works

    }

    function onYearlyVisualClick(){
        if(chartInUse){
            destroyChart(chartInUse);
        }
        var yearlyArrayHahaa = salesDataInArrayAccordingToKeyYearValues(something);
        var yearlyKeys = Object.keys(yearlyArrayHahaa);
        var yearlyValues = Object.values(yearlyArrayHahaa);

        chartInUse = showChart("This Year sales Chart", yearlyKeys, yearlyValues, "A$");//this works

    }

    //returnCurrentMonthDatesArrayInString();
    

    

    //console.log(monthlyKeys);
    //console.log(monthlyValues);




    function returnCurrentMonthDatesArrayInString(){
        var date = new Date();
        var month = date.getMonth();
        date.setDate(1);
        var all_days = [];
        while (date.getMonth() == month) {
            var d = date.getFullYear() + '-' + date.getMonth().toString().padStart(2, '0') + '-' + date.getDate().toString().padStart(2, '0');
            all_days.push(d);
            date.setDate(date.getDate() + 1);
        }
        console.log(all_days);
        return all_days;

    } 

    function dummyArrayofNumbers(){
        var numbers = [];
        var i = 0;
        while (i != 31 ){
            numbers.push(i);
            i++;
        }
        return numbers;
    }

    function returnFirstAndLastDateofWeek(monthDay, weekday){
        var monthDayStart = 0;
        var monthDayEnd = 0;

        //console.log("This is monthDay");
        //console.log(monthDay);

        //console.log("This is weekday");
        //console.log(weekday);

        switch (weekday) {
            case "Sunday":
                monthDayStart = parseInt(monthDay) - 6;
                monthDayEnd = parseInt(monthDay);
                break;
            case "Monday":
                monthDayStart = parseInt(monthDay);
                monthDayEnd = parseInt(monthDay) + 6;
                break;
            case "Tuesday":
                monthDayStart = parseInt(monthDay) - 1;
                monthDayEnd = parseInt(monthDay) + 5;
                break;
            case "Wednesday":
                monthDayStart = parseInt(monthDay) - 2;
                monthDayEnd = parseInt(monthDay) + 4;
                break;
            case "Thursday":
                monthDayStart = parseInt(monthDay) - 3;
                monthDayEnd = parseInt(monthDay) + 3;
                break;
            case "Friday":
                monthDayStart = parseInt(monthDay) - 2;
                monthDayEnd = parseInt(monthDay) + 4;
                break;
            case "Saturday":
                monthDayStart = parseInt(monthDay) - 1;
                monthDayEnd = parseInt(monthDay) + 5;
                break;

            default:
                console.log("Nothing much");
            }

        return [monthDayStart, monthDayEnd];
    }

    function salesDataInArrayAccordingToKeyWeekValues(salesDateValueArray){
        var thisWeekArray =[];
        
        for (const [key, value] of Object.entries(salesDateValueArray)) {
            const date = key;
            const parts = date.split("-");
            

            var monthDay = parts[2];
            var month = parts[1];
            var year = parts[0];

            console.log("Hey its diljot");

            

            var notCurrentDate = new Date(date);
            var notCurrentWeekDay = notCurrentDate.toLocaleString("default", { weekday: "long" });
            
            var currentDate = new Date();
            var currentWeekDay = currentDate.toLocaleString("default", { weekday: "long" });
            var cur_month = currentDate.getMonth() + 1;
            var cur_year = currentDate.getFullYear();

            //im thinking of making week as monday to sunday where monday is first day and sunday is last day of week -XD Diljot

            notCurrentDateWeek = returnFirstAndLastDateofWeek(monthDay, notCurrentWeekDay);
            currentDateWeek = returnFirstAndLastDateofWeek(currentDate.getDate(), currentWeekDay);
            //console.log("hey its notcusrreent" + notCurrentDateWeek);
            //console.log("hey its current" + currentDateWeek);
            

            if ((cur_month == month && year == cur_year) && (currentDateWeek[0] == notCurrentDateWeek[0] && currentDateWeek[1] == notCurrentDateWeek[1])) {
                thisWeekArray[key] = value;
            }
            /*else{
                console.log("what its still not same y?");
            }*/
        }

        console.log(thisWeekArray);
        return thisWeekArray;
        
    }

    function salesDataInArrayAccordingToKeyMonthValues(salesDateValueArray){
        var thisMonthArray = [];
        
        for (const [key, value] of Object.entries(salesDateValueArray)) {
            const date = key;
            const parts = date.split("-");

            var month = parts[1];
            var year = parts[0];

            var currentdate = new Date();
            var cur_month = currentdate.getMonth() + 1;
            var cur_year = currentdate.getFullYear();

            if (cur_month == month && year == cur_year) {
                thisMonthArray[key] = value;
            } 
        }

        
        //console.log("thisMonthArray");
        //console.log(thisMonthArray);
        return thisMonthArray;
        
    }

    function salesDataInArrayAccordingToKeyYearValues(salesDateValueArray){
        var thisYearArray = [];
        
        for (const [key, value] of Object.entries(salesDateValueArray)) {
            const date = key;
            const parts = date.split("-");

            var year = parts[0];

            var currentdate = new Date();
            var cur_year = currentdate.getFullYear();

            if (year == cur_year) {
                thisYearArray[key] = value;
            } 
        }

        
        //console.log("thisYearArray");
        //console.log(thisYearArray);
        return thisYearArray;
    }

    function showChart(legend, labels_for_chart, values_for_data, tick){
        var ctx = document.getElementById('chart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels:  labels_for_chart,//parenthesis this too
                datasets: [{
                    label: legend,
                    data: values_for_data,//parenthesis as wwell
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks:{
                            callback: function(value, index, values){
                                return tick + value;
                            }
                        }
                        
                    }
                }
            }
        });

        return myChart;
    }
        
    </script>
    
    
</body>
</html>