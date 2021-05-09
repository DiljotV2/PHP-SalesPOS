<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
    <h1>DASHBOARD</h1>
    <table>
        <tr>
            <th width = "20%"><h2>HIGHEST SALES TODAY</h2></th>
            <th width = "40%"><h2>TOTAL SALES TODAY</h2></th>
        </tr>
        <tr>
            <td width = "20%" style = "text-align: center;"><h3>A$250.25</h3></td><!--hardcoded value for now-->
            <td width = "40%" style = "text-align: center;"><h3>A$1875.75</h3></td><!--hardcoded value for now-->
        </tr>
    
    </table>
    <h1>NEWSLETTER</h1>
    <?php

        $mysqli = new mysqli("localhost","root","root","login");

        // Check connection
        if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
        }
        
        // check is database is avialable for use
		$query = "Select * from newsletter Group by SNo Desc limit 1";		// query is assigned here
		$result = mysqli_query ($mysqli, $query);
        if ($result->num_rows > 0){
            $rows = $result->fetch_assoc();
            echo "<h2>".$rows["Heading"]."</h2>";
            echo "<p>".$rows["News"]."</p>";
        }
        else{
            echo "Failedddddd";
            echo "<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi iste fugiat nulla tempore nostrum saepe asperiores placeat cum nemo, minus ipsam facilis pariatur corrupti porro vel perspiciatis voluptate quae doloremque!</p>";
        }
    ?>
    </body>
</html>