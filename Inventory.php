<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
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
    <h1>INVENTORY</h1>
    <table>
	<tr class = "table-header">
		<th class = "" width = '5%' style = "text-align: center;">ItemId</th>
		<th class = "" width = '10%' style = "text-align: center;">Name</th>
		<th class = "" width = '10%' style = "text-align: center;">Stocks</th>
		<th class = "" width = '10%' style = "text-align: center;">Price Per Product</th>
	</tr>
	<?php
		
		require "Credentials.php";
        $conn = new mysqli($host, $user, $password, $db);	// Log in and use database
		if ($conn) { // check is database is avialable for use
			$query = "Select * from inventorydata";		// query is assigned here
			$result = mysqli_query ($conn, $query);
			while($rows = $result->fetch_assoc()){
				echo "<tr class = 'table-row'><td class = '' width = '5%' style = 'text-align: center;'>". $rows["ItemID"] . "</td><td class = '' width = '10%' style = 'text-align: center;'>". $rows["Name"] . "</td><td class = '' width = '10%' style = 'text-align: center;'>". $rows["Stocks"]."</td><td class = '' width = '10%' style = 'text-align: center;'>".$rows["PricePerProduct"];
				//echo "</td><td class = '' width = '10%' style = 'text-align: center;'>".$rows["Stocks"]."</td><td class = '' width = '10%' style = 'text-align: center;'>".$rows["TotalPrice"]."</tr>";
			}echo "</table>";

			mysqli_close ($conn);					// Close the database connect
		} else {
			echo "<p>Unable to connect to the database.</p>";
		}
?>	

<button name = 'Insert' id = 'insert' onclick = 'insertFunction()'>Insert</button>
<button name = 'Delete' id = 'delete' onclick = 'deleteFunction()'>Delete</button>
<button name = 'Update' id = 'update' onclick = 'updateFunction()'>Update</button>
<p id="demo"></p>
	
<script>

	function refreshPage()
	{
		document.getElementById("submit_message").value = "Yes";
			
	}
	function insertFunction() {
		var table = "<form action='' method = 'POST'>";
			table += "<label name = 'insert'><h2>INSERT SALES</h2></label>";
			table += "<table>";
			table += "	<tr>";
			table += "		<th class = '' width = '10%' style = 'text-align: center;'>ItemID</th>";
			table += "		<th class = '' width = '10%' style = 'text-align: center;'>Name</th>";
			table += "		<th class = '' width = '10%' style = 'text-align: center;'>Stocks</th>";
			table += "		<th class = '' width = '10%' style = 'text-align: center;'>Price Per Product</th>";
			table += "	</tr>";
			table += "	<tr>";
			table += "		<td><input type='text' width = '10%' name = 'itemid'></td>";
			table += "		<td><input type='text' width = '10%' name = 'name'></td>";
			table += "		<td><input type='number' width = '10%' name = 'stocks'></td>";
			table += "		<td><input type='number' step='0.01' width = '10%' name = 'price_per_product'></td>";
			table += "	</tr>";
			table += "</table>";
			table += "<button name = 'submit_insert' id = 'submit' onClick = 'refreshPage()'>Submit</button>";
			table += "<input type='hidden' name = 'submit_message' id = 'submit_message' value = 'No'>";
			table += "<input type='hidden' name = 'message' id = 'message' value = 'Insert'>";
			table += "</form>";

			document.getElementById("demo").innerHTML = table;
		}

		function updateFunction() {
			var table = "<form action='' method = 'POST'>";
				table += "<label name = 'insert'><h2>UPDATE SALES</h2></label>";
				table += "<table>";
				table += "	<tr>";
				table += "		<th class = '' width = '10%' style = 'text-align: center;'>ItemID</th>";
				table += "		<th class = '' width = '10%' style = 'text-align: center;'>Name</th>";
				table += "		<th class = '' width = '10%' style = 'text-align: center;'>Stocks</th>";
				table += "		<th class = '' width = '10%' style = 'text-align: center;'>Price Per Product</th>";
				table += "	</tr>";
				table += "	<tr>";
				table += "		<td><input type='text' width = '10%' name = 'itemid'></td>";
				table += "		<td><input type='text' width = '10%' name = 'name'></td>";
				table += "		<td><input type='number' width = '10%' name = 'stocks'></td>";
				table += "		<td><input type='number' step='0.01' width = '10%' name = 'price_per_product'></td>";
				table += "	</tr>";
				table += "</table>";
				table += "<button name = 'submit_insert' id = 'submit' onClick = 'refreshPage()'>Submit</button>";
				table += "<input type='hidden' name = 'submit_message' id = 'submit_message' value = 'No'>";
				table += "<input type='hidden' name = 'message' id = 'message' value = 'Update'>";
				table += "</form>";

			document.getElementById("demo").innerHTML = table;
		}

		function deleteFunction() {
			var table = "<form action='' method = 'POST'>";
				table += "<label name = 'delete' value = 'delete hahaha'><h2>DELETE SALES</h2></label>";
				table += "<table>";
				table += "	<tr>";
				table += "		<th class = '' width = '10%' style = 'text-align: left;'>ItemId</th>";
				table += "	</tr>";
				table += "	<tr>";
				table += "		<td><input type='text' width = '10%' name = 'itemid'></td>";
				table += "	</tr>";
				table += "</table>";
				table += "<button name = 'submit_delete' id = 'submit' onClick = 'refreshPage()' >Submit</button>";
				table += "<input type='hidden' name = 'message' id = 'message' value = 'Delete'>";
				table += "<input type='hidden' name = 'submit_message' id = 'submit_message' value = 'No'>";
				table += "</form>";

			document.getElementById("demo").innerHTML = table;
		}

		
			
	</script>

	<?php
		$message = $_POST['message'];
		$submit_message = $_POST['submit_message'];
		
		$itemId = $_POST['itemid'];
		$name = $_POST['name'];
		$pricePerProduct = $_POST['price_per_product'];
		$stocks = $_POST['stocks'];

		require "Credentials.php";
        $conn = new mysqli($host, $user, $password, $db);	// Log in and use database
		if ($conn) { // check is database is avialable for use
			
			if($message == "Insert"){
				echo "insert activated";
				$query = "INSERT INTO `inventorydata` (`ItemID`, `Name`, `Stocks`, `PricePerProduct`) VALUES ('".$itemId."', '".$name."', '".$stocks."', '".$pricePerProduct."');";
			}
				
			if ($message == "Delete") {
				echo "delete activated ==".$itemId."";

				$query = "DELETE FROM `inventorydata` WHERE `inventorydata`.`ItemID` = '".$itemId."'";
			}

			if ($message == "Update") {
				echo "update activated";

				$query = "UPDATE `inventorydata` SET `Name` = '".$name."', `Stocks` = '".$stocks."', `PricePerProduct` = '".$pricePerProduct."' WHERE `inventorydata`.`ItemID` = '".$itemId."';";
				
			}
			$result = mysqli_query ($conn, $query);

			if($submit_message == "Yes")
			{
				header("refresh:0.5; url=Inventory.php");		
			}
			
			mysqli_close ($conn);					// Close the database connect
		} else {
			echo "<p>Unable to connect to the database.</p>";
		}
	
	?>
</body>
</html>