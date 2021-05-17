<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
	<link href="SaleDesign.css" rel="stylesheet" />
</head>
<body>
     <header>
        <h2>
            <nav>
				<div class = "links">
					<a href = "/Dashboard.php" id = "dashboard" class = "navLinks">Dashboard</a>
					<a href = "/Sales.php" id = "sales" class = "navLinks">Sales</a>
					<a href = "/Inventory.php" id = "inventory" class = "navLinks">Inventory</a>
					<a href = "/Visualization.php" id = "visualization" class = "navLinks">Visualization</a>
					<a href = "/Report.php" id = "reports" class = "navLinks">Reports</a>
				</div>
	        </nav>
        </h2>
    <header>
    <h1>SALES</h1>
	<div class = "board">
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
	
	require "Credentials.php";
    $conn = new mysqli($host, $user, $password, $db);	// Log in and use database
	if ($conn) { // check is database is avialable for use
		$query = "Select * from salesdata Order by SaleID DESC";		// query is assigned here
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
	</div>
    
	<button name = 'Insert' id = 'insert' onclick = 'insertFunction()'>INSERT</button>
	<button name = 'Delete' id = 'delete' onclick = 'deleteFunction()'>DELETE</button>
	<button name = 'Update' id = 'update' onclick = 'updateFunction()'>UPDATE</button>
	<p id="demo"></p>
	
	<script>

		function refreshPage()
		{
			document.getElementById("submit_message").value = "Yes";
			
		}
		function insertFunction() {
			revertButtonColors();
			document.getElementById("insert").style.backgroundColor = 'rgb(17, 11, 104)';
			var table = "<form action='' method = 'POST'>";
				table += "<table>";
				table += "	<tr class = 'insertFields'>";
				table += "		<td><input type='date' width = '10%' name = 'date' placeholder = 'Date'></td>";
				table += "		<td><input type='text' width = '10%' name = 'itemid' placeholder = 'ItemId'></td>";
				table += "		<td><input type='text' width = '10%' name = 'name'placeholder = 'Name'></td>";
				table += "		<td><input type='number' step='0.01' width = '10%' name = 'price_per_product' placeholder = 'Price Per Product'></td>";
				table += "		<td><input type='number' width = '10%' name = 'stocks' placeholder = 'Stocks'></td>";
				table += "		<td><input type='number' step='0.01' width = '10%' name = 'total_price' placeholder = 'Total Price'></td>";
				table += "		<td><button name = 'submit_insert' id = 'submit' onClick = 'refreshPage()'>Submit</button></td>";
				table += "	</tr>";
				table += "</table>";
				table += "<input type='hidden' name = 'submit_message' id = 'submit_message' value = 'No'>";
				table += "<input type='hidden' name = 'message' id = 'message' value = 'Insert'>";
				table += "</form>";

			document.getElementById("demo").innerHTML = table;
		}

		function updateFunction() {
			revertButtonColors();
			document.getElementById("update").style.backgroundColor = 'rgb(17, 11, 104)';
			var table = "<form action='#' method = 'POST'>";
				table += "<table>";
				table += "	<tr>";
				table += "		<td><input type='number' width = '10%' name = 'salesid' placeholder = 'Sale Id'></td>";
				table += "		<td><input type='date' width = '10%' name = 'date' placeholder = 'Date'></td>";
				table += "		<td><input type='text' width = '10%' name = 'itemid' placeholder = 'Item Id'></td>";
				table += "		<td><input type='text' width = '10%' name = 'name'placeholder = 'Name'></td>";
				table += "		<td><input type='number' step='0.01' width = '10%' name = 'price_per_product' placeholder = 'Price Per Product'></td>";
				table += "		<td><input type='number' width = '10%' name = 'stocks' placeholder = 'Stocks'></td>";
				table += "		<td><input type='number' step='0.01' width = '10%' name = 'total_price' placeholder = 'Total Price'></td>";
				table += "		<td><button name = 'submit_insert' id = 'submit' onClick = 'refreshPage()'>Submit</button></td>";
				table += "	</tr>";
				table += "</table>";
				table += "<input type='hidden' name = 'submit_message' id = 'submit_message' value = 'No'>";
				table += "<input type='hidden' name = 'message' id = 'message' value = 'Update'>";
				table += "</form>";

			document.getElementById("demo").innerHTML = table;
		}

		function revertButtonColors(){
			document.getElementById("insert").style.backgroundColor = 'rgb(70, 64, 160)';
			document.getElementById("update").style.backgroundColor = 'rgb(70, 64, 160)';
			document.getElementById("delete").style.backgroundColor = 'rgb(70, 64, 160)';
		}

		function deleteFunction() {
			revertButtonColors();
			document.getElementById("delete").style.backgroundColor = 'rgb(17, 11, 104)';
			var table = "<form action='' method = 'POST'>";
				table += "<table>";
				table += "	<tr>";
				table += "		<td><input type='text' width = '10%' name = 'salesid' placeholder = 'Sale Id'></td>";
				table += "		<td><button name = 'submit_delete' id = 'submit' onClick = 'refreshPage()'>Submit</button></td>";
				table += "	</tr>";
				table += "</table>";
				table += "<input type='hidden' name = 'message' id = 'message' value = 'Delete'>";
				table += "<input type='hidden' name = 'submit_message' id = 'submit_message' value = 'No'>";
				table += "</form>";

			document.getElementById("demo").innerHTML = table;
		}

		
			
	</script>

	<?php
		$message = $_POST['message'];
		$submit_message = $_POST['submit_message'];
		
		$salesId = $_POST['salesid'];
		$date = $_POST['date'];
		$itemId = $_POST['itemid'];
		$name = $_POST['name'];
		$pricePerProduct = $_POST['price_per_product'];
		$stocks = $_POST['stocks'];
		$totalPrice = $_POST['total_price'];
		$insert = $_POST['insert'];
		$delete = $_POST['delete'];

		require "Credentials.php";
    	$conn = new mysqli($host, $user, $password, $db);	// Log in and use database
		if ($conn) { // check is database is avialable for use
			
			if($message == "Insert"){
				echo "insert activated";
				$query = "INSERT INTO `salesdata` (`SaleID`, `Date`, `ItemID`, `Name`, `PricePerProduct`, `Stocks`, `TotalPrice`) VALUES (NULL, '".$date."', '".$itemId."', '".$name."', '".$pricePerProduct."', '".$stocks."', '".$totalPrice."');";		// query is assigned here
			}
				
			if ($message == "Delete") {
				echo "delete activated ==".$salesId;

				$query = "DELETE FROM `salesdata` WHERE `salesdata`.`SaleID` = '".$salesId."'";
			}

			if ($message == "Update") {
				echo "update activated ==".$salesId;

				$query = "UPDATE `salesdata` SET `Date` = '".$date."', `ItemID` = '".$itemId."', `Name` = '".$name."', `PricePerProduct` = '".$pricePerProduct."', `Stocks` = '".$stocks."', `TotalPrice` = '".$totalPrice."' WHERE `salesdata`.`SaleID` = ".$salesId.";";
			}
			$result = mysqli_query ($conn, $query);

			if($submit_message == "Yes")
			{
				echo "<meta http-equiv='refresh' content='0.5'>";

			}
			
			mysqli_close ($conn);					// Close the database connect
		} else {
			echo "<p>Unable to connect to the database.</p>";
		}
	
	?>
	<script type="text/javascript">
document.write(Math.random());
</script>

</body>
</html>