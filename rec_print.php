<?php

session_start();
include "header_php.php";
include "tfpdf/tfpdf.php";

$rec_no = $_GET['rec_no'];

$sql = "SELECT * FROM receipt_tab WHERE rec_no = '{$rec_no}'";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);

$rec_id = getPrefix($row['rec_id'], $row['rec_company']);
$customer = getCustomer($row['rec_customer']);
$product = getProduct($row['rec_productid']);

class PDF extends tFPDF {

// Page header
  function Header() {

    global $rec_id, $customer, $product, $row, $rec_no;
    $this->SetFillColor(220, 220, 220);
    $border = 1;
    $lh = 7;
    $textsize = 13;
    $defaultsize = 12;

    $space = "        ";
    // Logo
    if ($row['rec_company'] == 1) {
      //$this->Image('images/mitmongkol.jpg', 15, 15, 20, 25, 'jpg');
    }

    $this->SetY(15);
    // Title
    $this->SetFontSize(18);

    $this->SetFontSize(22);
    $company = $row['rec_company'];
    include "_pdf_header.php";

    // Line break
    $this->Ln(6);

    $this->SetFontSize(16);
    $this->Cell(180, $lh -6, "ใบเสร็จรับเงิน / ใบกำกับภาษี", 0, 1, C); // no
    $this->Cell(180, $lh + 2, "RECEIPT / TAX INVOICE", 0, 1, C); // no
    $this->SetFontSize(9);
    $this->Cell(10, $lh, "", B, 0, L);

    if ($row['rec_company'] == 1) {
      $this->SetFontSize($textsize); $this->Cell(170, $lh, "เลขประจำตัวผู้เสียภาษี / TAX ID   3200400057461", B, 1, R);
    } else if ($row['rec_company'] == 2) {
      $this->SetFontSize($textsize); $this->Cell(170, $lh, "เลขประจำตัวผู้เสียภาษี / TAX ID   3200400126985", B, 1, R);
    } else if ($row['rec_company'] == 3) {
      $this->SetFontSize($textsize); $this->Cell(170, $lh, "เลขประจำตัวผู้เสียภาษี / TAX ID   0205555027280", B, 1, R);
    }


    $this->Cell(110, $lh - 4, "", LR, 0, L);
    $this->Cell(70, $lh - 4, "", LR, 1, L);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    //$this->Text($x + 5, $y + 2, "บริษัทผู้เช่า/ผู้ว่าจ้าง :");
    $this->Cell(30, $lh + 4, $space . "นามลูกค้า / Name :", L, 0, L);


    if (strpos($customer["cu_name"],'สาขา') == true) {
        $extend = "";
    }else{
        $extend = "  (สำนักงานใหญ่)";
    }

    $this->SetFontSize($textsize); $this->Cell(80, $lh + 4, $space . cuName($customer["cu_type"], $customer["cu_name"]) . $extend, R, 0, L); $this->SetFontSize($defaultsize);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->Text($x + 5, $y + 2, "");
    $this->Cell(30, $lh + 4, $space . "เลขที่ / No. : ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(40, $lh + 4, "TAX IV " . $rec_id, R, 1, L); $this->SetFontSize($defaultsize);


    $x = $this->GetX(); $y = $this->GetY(); // Remember position

    $this->SetXY(45, $y + 1);
    $this->SetFontSize($textsize); $this->MultiCell(70, $lh - 2, $customer['cu_address'], 0,L); $this->SetFontSize($defaultsize);

    $this->SetXY(20, $y + 12);
    $this->SetFontSize($textsize); $this->MultiCell(70, $lh - 2, "เลขที่ผู้เสียภาษี :        " . $customer['cu_taxid'], 0,L); $this->SetFontSize($defaultsize);

    $this->SetXY($x, $y);
    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    //$this->Text($x + 5, $y + 2, "ที่อยู่ :");
    $this->Cell(110, $lh, $space . "ที่อยู่ / Address : ", LR, 0, L);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->Text($x + 5, $y + 2, "");
    $this->Cell(30, $lh, $space . "วันที่ / Date : ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(40, $lh, splitdate($row['rec_date'], "avg"), R, 1, L); $this->SetFontSize($defaultsize);




    $this->Text($this->GetX() + 5, $this->GetY() + 2, "");
    $this->Cell(30, $lh+5, $space . "", L, 0, L);
    $this->Cell(80, $lh, "", R, 0, L);


    $this->Cell(70, $lh+5, "", LR, 1, L);



    $this->Cell(180, $lh -3, "", T, 1, C); // no
  }

  function Content() {

    global $rec_id, $customer, $product, $row, $rec_no;

    $this->SetFillColor(220, 220, 220);
    $border = 1;
    $lh = 7;
    $textsize = 13;
    $defaultsize = 9;

    $space = "        ";

    $i = 1;
    $sql_d = "SELECT * FROM receipt_d WHERE rec_id='$rec_id' ORDER BY recd_id ";
    //echo $sql_d;
    $result_d = mysql_query($sql_d);
    $rownum = mysql_num_rows($result_d); // จำนวนแถวข้อมูล

    $rowmax = ceil($rownum / 12) * 12;
    $this->SetFontSize($textsize);
    $this->Cell(10, $lh - 1, "ลำดับ", LTR, 0, C);
    $this->Cell(100, $lh - 1, "รายการ", LTR, 0, C);
    $this->Cell(20, $lh - 1, "จำนวน", LTR, 0, C);
    $this->Cell(20, $lh - 1, "หน่วยละ (บาท)", LTR, 0, C);
    $this->Cell(30, $lh - 1, "จำนวนเงิน (บาท)", LTR, 1, C);
    $this->Cell(10, $lh - 2, "Item", LBR, 0, C);
    $this->Cell(100, $lh - 2, "Description", LBR, 0, C);
    $this->Cell(20, $lh - 2, "Qty.", LBR, 0, C);
    $this->Cell(20, $lh - 2, "Unit Price", LBR, 0, C);
    $this->Cell(30, $lh - 2, "Amount", LBR, 1, C);


    //จำนวนแถวที่จะแสดงทั้งหมด
    while ($i <= $rowmax) {
      $row_d = mysql_fetch_assoc($result_d);
      $bdtable = "LR";
      if ($i % 12 == 0)
        $bdtable = "LBR";
      if ($i % 13 == 0) {
        $this->AddPage();
        $this->Cell(10, $lh - 1, "ลำดับ", 1, 0, C);
        $this->Cell(100, $lh - 1, "รายการ", 1, 0, C);
        $this->Cell(20, $lh - 1, "จำนวน", 1, 0, C);
        $this->Cell(20, $lh - 1, "หน่วยละ (บาท)", 1, 0, C);
        $this->Cell(30, $lh - 1, "จำนวนเงิน (บาท)", 1, 1, C);
        $this->Cell(10, $lh - 2, "Item", 1, 0, C);
        $this->Cell(100, $lh - 2, "Description", 1, 0, C);
        $this->Cell(20, $lh - 2, "Qty.", 1, 0, C);
        $this->Cell(20, $lh - 2, "Unit Price", 1, 0, C);
        $this->Cell(30, $lh - 2, "Amount", 1, 1, C);
      }

      if ($row_d['description'] == '') {
        $this->Cell(10, $lh + 2, "", $bdtable, 0, C);
        $this->Cell(100, $lh + 2, "", $bdtable, 0, C);
        $this->Cell(20, $lh + 2, "", $bdtable, 0, C);
        $this->Cell(20, $lh + 2, "", $bdtable, 0, C);
        $this->Cell(30, $lh + 2, "", $bdtable, 1, C);
      } else {

        $this->Cell(10, $lh + 2, $i, $bdtable, 0, C);
        $this->Cell(5, $lh + 2, "", 0, 0, L);
        $this->Cell(95, $lh + 2, $row_d['description'], R, 0, L);
        $this->Cell(20, $lh + 2, $row_d['amount'] . " " . $row_d['unit'], $bdtable, 0, C);
        $this->Cell(20, $lh + 2, number_format($row_d['perunit'], 2), $bdtable, 0, R);
        $this->Cell(30, $lh + 2, number_format($row_d['total'], 2), $bdtable, 1, R);
      }
      $i++;
    }
    $this->SetFontSize($defaultsize);
  }

// Page footer
  function Footer() {

    global $row;
    $lh = 7;

    $this->SetFontSize(13);


    $this->Cell(110, $lh, bathformat(number_format($row['rec_total'], 2)), 1, 0, C);
    $this->Cell(40, $lh, "รวมราคาสินค้า / Total", 1, 0, L);
    $this->Cell(30, $lh, number_format($row['rec_after_discount'], 2), 1, 1, R);

    $this->Cell(110, $lh, "*ในกรณีที่ชำระด้วยเช็คธนาคาร / ใบเสร็จรับเงินจะเสร็จสมบูรณ์ต่อเมื่อ", LR, 0, C);
    $this->Cell(40, $lh, "ภาษีมูลค่าเพิ่ม % / Vat 7%", 1, 0, L);
    $this->Cell(30, $lh, number_format($row['rec_vat'], 2), 1, 1, R);
    $this->Cell(110, $lh, "ได้เรียกเก็บเงินจากธนาคารเรียบร้อยแล้ว", LRB, 0, C);
    $this->Cell(40, $lh, "รวมเป็นเงินทั้งสิ้น/GrandTotal", 1, 0, L);
    $this->Cell(30, $lh, number_format($row['rec_total'], 2), 1, 1, R);

    $this->Cell(180, $lh - 4, "", TB, 1, C); // no

    $x = $this->GetX(); $y = $this->GetY();

    $this->Rect($x + 8, $y + 1, 5, 5);

    if ($row['cash_payment'] == 'Y') {
      $this->Text($x + 9.8, $y + 4.2, "x");
      $this->Text($x + 70, $y + 4.2, number_format($row['cash_amount'], 2));
    }
    $this->Cell(15, $lh, "", L, 0, L);
    $this->Cell(165, $lh, "เงินสด           จำนวนเงิน ___________________________________  บาท", R, 1, L);


    $x = $this->GetX(); $y = $this->GetY();
    $this->Rect($x + 8, $y + 1, 5, 5);

    if ($row['cheque'] == 'Y') {
      $this->Text($x + 9.8, $y + 4.2, "x");
      $this->Text($x + 40, $y + 4.2, $row['cheque_bank'] . " จำนวนเงิน " . number_format($row['cheque_amount'], 2));
      $this->Text($x + 110, $y + 4.2, $row['cheque_branch']);
    }
    $this->Cell(15, $lh, "", L, 0, L);
    $this->Cell(165, $lh, "เช็คธนาคาร   ____________________________________________  สาขา _________________________", R, 1, L);
    $this->Cell(15, $lh, "", LB, 0, L);

    $x = $this->GetX(); $y = $this->GetY();

    if ($row['cheque'] == 'Y') {
      $this->Text($x + 20, $y + 4.2, $row['cheque_no']);
      $this->Text($x + 60, $y + 4.2, splitdate($row['cheque_date'], "avg"));
    }
    $this->Cell(165, $lh, "เลขที่เช็ค   _____________________  ลงวันที่ __________________  ผู้รับเงิน _____________________________", RB, 1, L);
    $this->Text($x + 100, $y + 4.2, $row['rec_receiver']);

    $this->ln(4);
    $this->Cell(180, $lh, "หมายเหตุ : กรุณาตรวจสอบชื่อและที่อยู่ของท่านในใบกำกับภาษีให้ถูกต้อง หากมีการแก้ไขใบกำกับภาษีใหม่", 0, 1, L);
    $this->Cell(14, $lh, "", 0, 0, L);
    $this->Cell(166, $lh, "ทางร้านจะดำเนินการเฉพาะเอกสารที่ส่งมาแก้ไข ภายใน 7 วัน นับจากวันที่ออกใบกำกับภาษีเท่านั้น", 0, 1, L);
    $this->Cell(0,10,'Page '.$this->PageNo().' / {nb}',0,0,'R');
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
$pdf->AliasNbPages();
$pdf->AddFont('Angsana', '', 'AngsabUPC.ttf', true);
$pdf->SetFont('Angsana', '', 9);

$pdf->SetLeftMargin(15);
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
//$outputFilename = $row['rec_id'] . ".pdf";
//$pdf->Output($outputFilename, 'D');
?>