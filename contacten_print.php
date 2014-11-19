<?php

session_start();
include "header_php.php";
include "tfpdf/tfpdf.php";

$contacten_no = $_GET['contacten_no'];

$sql = "SELECT * FROM contacten_tab WHERE contacten_no = '{$contacten_no}'";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);

$contacten_id = getPrefix($row['contacten_id'], $row['contacten_company']);

$customer = getCustomer($row['contacten_customer']);
$product = getProduct($row['contacten_productid']);

function getnameEquipment($equipNo, $contacten_no) {

  $equipment = "contacten_equipment" . $equipNo;
  $unit = "contacten_equipment_unit" . $equipNo;

  $sql = "SELECT {$equipment},{$unit} FROM contacten_tab WHERE contacten_no = '{$contacten_no}'";
  $result = mysql_query($sql);


  $row = mysql_fetch_assoc($result);

  if ($row[$equipment]) {
    $sqlequip = "SELECT * FROM equip_list WHERE equip_id = '{$row[$equipment]}'";
    $result2 = mysql_query($sqlequip);
    $row2 = mysql_fetch_assoc($result2);
    //echo $sqlequip;
    $name = $row2['equip_name'];
    // ถ้ามีหน่วย
    if ($row2['equip_requirenum']) {
      $name.= "  " . $row[$unit] . "  " . $row2['equip_unit'];
    }
    return $name;
  } else {
    return "";
  }
}

class PDF extends tFPDF {

// Page header
  function Header() {

    global $row;


    $this->SetY(15);
    $this->SetFont('cordiab', 'B');
    // Title


    $company = $row['contacten_company'];
    include "_pdf_header_contacten.php";


    // Line break
    $this->Ln(8);
  }

  function Content() {

    global $contacten_id, $customer, $product, $row, $contacten_no;
    $this->SetFillColor(220, 220, 220);
    $border = 0;
    $lh = 7;
    $textsize = 14;
    $defaultsize = 14;

    $space = "      ";

    $this->SetLeftMargin(5);
    $this->Cell(90, 0, "", 0, 0, L);
    $this->Cell(90, 0, "", 0, 1, L);



    $this->SetFontSize(15);


    $this->SetFont('cordiab', 'B');
    
    $this->SetFont('cordia', '');

    $this->Cell(110, $lh - 6, "", '', 0, L);
    $this->Cell(90, $lh - 6, "", '', 1, L);

    $this->SetFontSize($defaultsize);
    $x = $this->GetX(); $y = $this->GetY(); // Remember position

    $this->Cell(20, $lh, $space . "", 0, 0, L);
    $this->SetFontSize(16); $this->Cell(90, $lh, "     " . cuName($customer["cu_type"], $customer["cu_name"]), 0, 0, L); $this->SetFontSize($defaultsize);
    $x = $this->GetX(); $y = $this->GetY(); // Remember position

    $this->Cell(35, $lh, $space . " ", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(55, $lh, $contacten_id, 0, 1, L); $this->SetFontSize($defaultsize);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position

    $this->SetXY(30, $y + 1);
    $this->SetFontSize($textsize); $this->MultiCell(70, $lh - 2, $customer['cu_address'], 0,L); $this->SetFontSize($defaultsize);

    $this->SetXY($x, $y);
    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->Text($x + 5, $y + 2, "");
    $this->Cell(110, $lh, $space . "", 0, 0, L);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position

    $this->Cell(35, $lh, $space . " ", 0, 0, L);

    $this->SetFontSize($textsize); $this->Cell(55, $lh, splitdate($row['contacten_date'], "avg"), 0, 1, L); $this->SetFontSize($defaultsize);
    $this->Cell(110, $lh, "", 0, 0, L);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position

    $this->Cell(35, $lh, $space . " ", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(55, $lh, $customer['cu_termpayment'], 0, 1, L); $this->SetFontSize($defaultsize);

    $this->Cell(25, $lh, $space . " ", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(25, $lh, $customer['cu_contact'], '', 0, L); $this->SetFontSize($defaultsize);

    $this->Cell(20, $lh, $space . " ", '', 0, L);
    $this->SetFontSize($textsize); $this->Cell(40, $lh, $customer['cu_phone'], 0, 0, L); $this->SetFontSize($defaultsize);


    $this->Cell(35, $lh, $space . "  ", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(55, $lh, $row['contacten_pono'], 0, 1, L); $this->SetFontSize($defaultsize);


    $this->Cell(110, $lh - 4, "", 0, 0, L);
    $this->Cell(90, $lh - 4, "", 0, 1, L);


    $this->SetFont('cordia', '');

    $this->SetFontSize($defaultsize);

    $lh = $lh+2;

    $this->Ln(5);

    $this->Cell(25, $lh, $space . " ", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(55, $lh, $row['contacten_productname'], 0, 0, L); $this->SetFontSize($defaultsize);

    $this->Cell(25, $lh, $space . " ", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(50, $lh, $row['contacten_productsize'], 0, 0, L); $this->SetFontSize($defaultsize);

    $this->Cell(20, $lh, " ", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(25, $lh, $row['contacten_productnumber'], 0, 1, L); $this->SetFontSize($defaultsize);

    $this->Cell(45, $lh, $space . " ", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(65, $lh, $row['contacten_workplace'], 0, 0, L); $this->SetFontSize($defaultsize);

    $this->Cell(30, $lh, $space . " ", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(60, $lh, $row['contacten_workappear'], 0, 1, L); $this->SetFontSize($defaultsize);
    
    $this->Cell(45, $lh, $space . "", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(20, $lh, number_format($row['contacten_agreementdate'], 2), 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(45, $lh, $space . "", 0, 0, L);


    $this->Cell(30, $lh, $space . " ", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(15, $lh, number_format($row['contacten_productprice'], 2), 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(45, $lh, $space . "", 0, 1, L);
    $this->Cell(30, $lh, $space . "", 0, 0, L);

    $this->SetFontSize($textsize); $this->Cell(40, $lh, $space . $row['contacten_equipment1'], 0, 0, L); $this->SetFontSize($defaultsize);
    $this->SetFontSize($textsize); $this->Cell(40, $lh, $space . $row['contacten_equipment2'], 0, 0, L); $this->SetFontSize($defaultsize);
    $this->SetFontSize($textsize); $this->Cell(45, $lh, $space . $row['contacten_equipment3'], 0, 0, L); $this->SetFontSize($defaultsize);
    $this->SetFontSize($textsize); $this->Cell(45, $lh, $space . $row['contacten_equipment4'], 0, 1, L); $this->SetFontSize($defaultsize);


    $this->SetFont('cordia', '');
    $this->SetFontSize($defaultsize);

    $this->Cell(35, $lh, $space . "", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(80, $lh, $row['contacten_normaltime'], 0, 0, L); $this->SetFontSize($defaultsize);

    // $this->Cell(10, $lh, "-", B , 0, C);
    // $this->SetFontSize($textsize); $this->Cell(60, $lh, $row['contacten_normaltimeto'] . " น.", B , 0, L); $this->SetFontSize($defaultsize);


    $this->Cell(30, $lh, " ", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(30, $lh, $row['contacten_unit'] . "  " . number_format($row['contacten_priceperunit'], 2), 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(25, $lh, "", 0, 1, L);

    $this->Cell(35, $lh, $space . "", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(40, $lh, "", 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 1, $this->GetY() + 2, "");
    $this->Cell(40, $lh, "", 0, 0, L);

    $this->Cell(30, $lh, "", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(30, $lh, number_format($row['contacten_hourprice'], 2), 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(25, $lh, "", 0, 1, L);

    $this->Cell(35, $lh, $space . "", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(80, $lh, $row['contacten_transport'], 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(30, $lh, "", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(55, $lh, number_format($row['contacten_transportprice'], 2), 0, 1, L); $this->SetFontSize($defaultsize);


    $this->Cell(35, $lh, $space . "", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(80, $lh, $row['contacten_carlicense'], 0, 0, L); $this->SetFontSize($defaultsize);


    $this->Cell(30, $lh, "", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(30, $lh, $row['contacten_oilloss'], 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(25, $lh, "", 0, 1, L);


    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->SetXY(40, $y);
     $this->SetFontSize($textsize);
    $this->MultiCell(140, $lh , $row['contacten_remark'], 0);
    $this->SetXY($x, $y);



    $this->SetFontSize($defaultsize);
    $this->Cell(115, $lh, $space . "", 0, 0, L);
    
   
    $this->Cell(30, $lh, " ", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(30, $lh, $row['contacten_keyloss'], 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(25, $lh, "", 0, 1, L);


    $lh = $lh-2;

    $this->Ln(2);

    $this->SetFontSize($defaultsize - 3.5);
    $this->Cell(200, $lh , "", 0, 1, C);
    $this->Cell(200, $lh - 3, " ", 0, 1, C);
    
    $this->Ln(3);

    $this->SetFontSize($defaultsize);

    $this->SetFontSize(15);
    $this->SetFont('cordiab', 'B');
    $this->Cell(85, $lh + 1, "", $border, 0, C);
    $this->Cell(115, $lh + 1, "", $border, 0, C);
    $this->SetFont('cordia', '');
    $this->SetFontSize($defaultsize);
    $this->Cell(85, $lh - 4, "", 0, 0, L);
    $this->Cell(115, $lh - 4, "", 0, 1, L);
    $this->Cell(20, $lh, "", 0, 0, L);
    $this->Cell(25, $lh, "", 0, 0, 0);

    $this->Cell(40, $lh, "", 0, 0, L);


    $this->Cell(40, $lh, "", 0, 0, L);

    $this->Cell(20, $lh, " ", 0, 0, L);

    $this->Cell(33, $lh, "", 0, 0, L);

    $this->Cell(22, $lh, " ", 0, 1, L);

    $this->Cell(20, $lh+2, "", 0, 0, L);
    $this->Cell(25, $lh+2, "", 0, 0, 0);

    $this->Cell(40, $lh+2, "", 0, 0, L);

    $this->Cell(40, $lh+2, "", 0, 0, L);

    $this->Cell(40, $lh+2, "", 0, 0, L);

    $this->Cell(35, $lh+2, "", 0, 1, L);

    $this->Cell(20, $lh+2, "", 0, 0, L);
    $this->Cell(25, $lh+2, "", 0, 0, 0);

    $this->Cell(40, $lh+2, "", 0, 0, L);

    $this->Cell(40, $lh+2, "", 0, 0, L);

    $this->Cell(40, $lh+2, "", 0, 0, L);

    $this->Cell(35, $lh+2, "", 0, 1, L);


    $this->Cell(20, $lh+2, "", 0, 0, L);
    $this->Cell(25, $lh+2, "", 0, 0, 0);

    $this->Cell(40, $lh+2, "", 0, 0, L);
   
    $this->Cell(115, $lh+2, "", 0, 1, C);






    $this->Cell(200, $lh - 5, "", 0, 1, C);
    $this->SetFont('cordiab', 'BU');
    $this->SetFontSize(12);

    $this->Ln(1);

    $this->Cell(20, $lh - 3, "", 0, 0, C);
    $this->Cell(20, $lh - 3, "", 0, 0, C);
    $this->SetFont('cordia', '');
    $this->Cell(160, $lh - 3, "", 0, 1, L);
    $this->Cell(20, $lh - 3, "", 0, 0, C);
    $this->Cell(160, $lh - 3, "", 0, 1, L);

    $this->Ln(5);

    $this->SetFontSize(15);
    $this->SetFont('cordiab', 'B');
    $this->Cell(200, $lh + 1, "", $border, 1, C);
    $this->SetFont('cordia', '');
    $this->SetFontSize($defaultsize);
    $this->Cell(100, $lh, "", $border, 0, C);
    $this->Cell(100, $lh, "", $border, 1, C);
    $this->Cell(100, $lh, "", $border, 0, C);
    $this->Cell(100, $lh, "", $border, 1, C);
    $this->Cell(100, $lh, "", $border, 0, C);
    $this->Cell(100, $lh, "", $border, 1, C);



    $this->SetFont('cordiab', 'B');
    $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 82, $this->GetY() + 8, "");
    $this->SetFont('cordia', '');
  }

// Page footer
  function Footer() {
    // Position at 1.5 cm from bottom
//    $this->SetY(-15);
//    // Arial italic 8
//    $this->SetFont('Arial', 'I', 8);
//    // Page number
//    $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
  }

}

// Instanciation of inherited class
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AddFont('cordia', '', 'AngsaUPC.ttf', true);
$pdf->AddFont('cordiab', 'B', 'AngsabUPC.ttf', true);
$pdf->SetFont('cordia', '', 9);
$pdf->AliasNbPages();
$pdf->SetLeftMargin(15);
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
//$outputFilename = $row['contacten_id'] . ".pdf";
//$pdf->Output($outputFilename, 'D');
?>