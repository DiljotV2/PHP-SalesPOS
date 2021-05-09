<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
</head>
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
    <header>
    <h1>SALES</h1>
    <table>
	<tr class = "table-header">
		<th class = "" width = '5%' style = "text-align: center;">SaleId</th>
		<th class = "" width = '10%' style = "text-align: center;">Date</th>
		<th class = "" width = '10%' style = "text-align: center;">ItemId</th>
		<th class = "" width = '10%' style = "text-align: center;">Name</th>
		<th class = "" width = '10%' style = "text-align: center;">Price Per Product</th>
		<th class = "" width = '10%' style = "text-align: center;">Stocks</th>
        <th class = "" width = '10%' style = "text-align: center;">Total Price</th>
	</tr>
<?php
	
	//require_once "settings.php";	// Load MySQL log in credentials
	$conn = @mysqli_connect ("localhost","root","root","login");	// Log in and use database
	if ($conn) { // check is database is avialable for use
		$query = "Select * from salesdata";		// query is assigned here
		$result = mysqli_query ($conn, $query);
		while($rows = $result->fetch_assoc()){
			echo "<tr class = 'table-row'><td class = '' width = '5%' style = 'text-align: center;'>". $rows["SaleID"] ."</td><td class = '' width = '10%' style = 'text-align: center;'>". $rows["Date"] .  "</td><td class = '' width = '10%' style = 'text-align: center;'>". $rows["ItemID"] . "</td><td class = '' width = '10%' style = 'text-align: center;'>". $rows["Name"]."</td><td class = '' width = '10%' style = 'text-align: center;'>".$rows["PricePerProduct"];
			echo "</td><td class = '' width = '10%' style = 'text-align: center;'>".$rows["Stocks"]."</td><td class = '' width = '10%' style = 'text-align: center;'>".$rows["TotalPrice"]."</tr>";
		}echo "</table>";

		mysqli_close ($conn);					// Close the database connect
	} else {
		echo "<p>Unable to connect to the database.</p>";
	}
?>	
</body>
</html>