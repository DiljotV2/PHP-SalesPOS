<?php
require('fpdf.php');



class PDF extends FPDF
{

    function loadData(){
        $data = array();
    
        //require_once "settings.php";	// Load MySQL log in credentials
        $conn = @mysqli_connect ("localhost","root","root","login");	// Log in and use database
        if ($conn) { // check is database is avialable for use
            $query = "Select * from salesdata";		// query is assigned here
            $result = mysqli_query ($conn, $query);
            while($rows = $result->fetch_assoc()){
                $line = array($rows['SaleID'], $rows['Date'], $rows['ItemID'], $rows['Name'], $rows['PricePerProduct'], $rows['Stocks'], $rows['TotalPrice']);
                array_push($data, $line);
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
        $this->Cell(30,10,'SALES MONTHLY RECORDS', 0,0,'C');
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
        $this->SetFillColor(255,0,0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128,0,0);
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
$pdf->SetFont('Times','',12);
$salesHeader = array("SaleID","Date", "ItemID", "Name", "Price Per Product", "Stocks", "Total Price");
$salesData = $pdf->loadData();
$pdf->FancyTable($salesHeader, $salesData);
$pdf->Output();
?>
