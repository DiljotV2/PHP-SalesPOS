<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
	<link href="ReportDesign.css" rel="stylesheet" />

</head>
<body>
     <header>
        <h2>
        
            <nav>
                <div class = "links">
                    <a href = "/Dashboard.php" id = "dashboard" class = "navLinks">Dashboard</a>
                    <a href = "/Sales.php" id = "sales"  class = "navLinks">Sales</a>
                    <a href = "/Inventory.php" id = "inventory"  class = "navLinks">Inventory</a>
                    <a href = "/Visualization.php" id = "visualization"  class = "navLinks">Visualization</a>
                    <a href = "/Report.php" id = "reports"  class = "navLinks">Reports</a>
                
                </div>
            </nav>
        </h2>
    <header>
    <h1>REPORTS</h1>

    <?php
require('fpdf.php');



class PDF extends FPDF
{

    function loadData(){
        $data = array();
    
        require "Credentials.php";
        $conn = new mysqli($host, $user, $password, $db);	// Log in and use database
        if ($conn) { // check is database is avialable for use
            $query = "Select * from salesdata";		// query is assigned here
            $result = mysqli_query ($conn, $query);
            while($rows = $result->fetch_assoc()){  
                $thisDate =  $rows['Date'];
                //$checkItisThisMonth = 
                //this_month($thisDate);
                $dateParts = explode("-", $thisDate);
                $currentDateParts = explode("-", date("Y-m-d"));

                if($dateParts[0] == $currentDateParts[0] && $dateParts[1] == $currentDateParts[1]){
                    $line = array($rows['SaleID'], $rows['Date'], $rows['ItemID'], $rows['Name'], $rows['PricePerProduct'], $rows['Stocks'], $rows['TotalPrice']);
                    array_push($data, $line);
                }
                
                
            }
            /*echo "<script>\n";
            echo "console.log('->', ".json_encode($data).");";
            echo "</script>";*/
            mysqli_close ($conn);					// Close the database connect
        } else {
            echo "<p>Unable to connect to the database.</p>";
        }
        return $data;
    }

    // Page header
    function Header()
    {
        // Logo
        //$this->Image('logo.png',10,6,30);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,10, ''.strtoupper(date('F')).' SALES RECORD', 0,0,'C');
        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function FancyTable($header, $data)
    {
        $this->SetX(10);

        // Colors, line width and bold font
        $this->SetFillColor(17, 11, 104);
        $this->SetTextColor(255);
        $this->SetDrawColor(17, 11, 104);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
        // Header
        $w = array(15, 25, 35, 40, 35, 20, 25);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        foreach($data as $row)
        {
            $this->Cell($w[0],6,number_format($row[0]),'LR',0,'L',$fill);
            $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
            $this->Cell($w[2],6,$row[2],'LR',0,'R',$fill);
            $this->Cell($w[3],6,$row[3],'LR',0,'R',$fill);
            $this->Cell($w[4],6,"A$".number_format($row[4]),'LR',0,'L',$fill);
            $this->Cell($w[5],6,number_format($row[5]),'LR',0,'R',$fill);
            $this->Cell($w[6],6,number_format($row[6]),'LR',0,'R',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Closing line
        $this->Cell(array_sum($w),0,'','T');
    }
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$salesHeader = array("SaleID","Date", "ItemID", "Name", "Price Per Product", "Stocks", "Total Price");
$salesData = $pdf->loadData();
$pdf->FancyTable($salesHeader, $salesData);
/*for($i=1;$i<=40;$i++)
	$pdf->Cell(0,10,'Printing line number '.$i,0,1);
*/
$output = $pdf->Output('', 'S');
$output = base64_encode($output);
?>
<select name="year" id="year" class = "category">
        <option value="2021">2021</option>
    </select>

    <select name="month" id="month" class = "category">
        <!--<option value="January">January</option>
        <option value="February">February</option>
        <option value="March">March</option>
        <option value="April">April</option>-->
        <option value="May">May</option>
        <!--<option value="June">June</option>
        <option value="July">July</option>
        <option value="August">August</option>
        <option value="September">September</option>
        <option value="October">October</option>
        <option value="November">November</option>
        <option value="December">December</option>-->
    </select>

    <button id = "button" onClick = "downloadReport()" class = "category"> Download</button>
   
    
    <script>
        function downloadReport(){
            
                var downloadFile = '<embed src="https://php-sale.s3.amazonaws.com/2021/May.pdf" >';
			    document.getElementById("demo").innerHTML = downloadFile;
            
        }
    </script>
    <div class = "container"  >
        <embed src="data:application/pdf;base64,<?php echo $output ?>" type='application/pdf' style = 'margin: auto;' width = "70%" height = "600px">
    </div>
     <p id = "demo"></p>
</body>
</html>