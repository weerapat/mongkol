<?php

session_start();
include "header_php.php";
include "tfpdf/tfpdf.php";

$quo_no = $_GET['quo_no'];

$sql = "SELECT * FROM quotation_tab WHERE quo_no = '{$quo_no}'";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);

$quo_id = $row['quo_id'];

$customer = getCustomer($row['quo_customer']);
$product = getProduct($row['quo_productid']);

class PDF extends tFPDF {

// Page header
  function Header() {

    global $quo_id, $customer, $product, $row, $quo_no;
    $this->SetFillColor(220, 220, 220);
    $border = 1;
    $lh = 7;
    $textsize = 13;
    $defaultsize = 9;

    $space = "        ";
    // Logo
    if ($row['quo_company'] == 1) {
      $this->Image('images/mitmongkol.jpg', 30, 15, 20, 25, 'jpg');
    }

    $this->SetY(15);
    $this->Cell(80);
    // Title
    $this->SetFontSize(15);
    if ($row['quo_company'] == 1) {
      $this->Cell(30, 5, 'มิตรมงคล/MITMONGKOL', 0, 1, 'C');
    } else if ($row['quo_company'] == 2) {
      $this->Cell(30, 5, 'มงคลทวีทรัพย์/MONGKOLTAWEESUP', 0, 1, 'C');
    }
    $this->SetFontSize(12);
    $this->Cell(80);
    $this->Cell(30, 5, '(นิภา  ชินวัฒน์)', 0, 1, 'C');
    $this->Cell(80);
    $this->Cell(30, 5, '32/15 ม.4 ถ.สุขุมวิท ต.บางละมุง จ.ชลบุรี 20150', 0, 1, 'C');
    $this->Cell(80);
    $this->Cell(30, 5, 'โทร. (038) 241428  แฟกซ์ (038)240150', 0, 1, 'C');
    $this->Cell(80);
    $this->Cell(30, 5, 'E-mail: mitmongkol@gmail.com  Website: www.mitmongkols.com', 0, 1, 'C');


    // Line break
    $this->Ln(8);

    $this->SetFontSize(14);
    $this->Cell(180, $lh + 1, "ใบเสร็จรับเงิน / ใบกำกับภาษี", TLR, 1, C); // no
    $this->SetFontSize(9);
    $this->Cell(10, $lh, "", LB, 0, L);
    $this->SetFontSize($textsize); $this->Cell(80, $lh, "เลขประจำตัวผู้เสียภาษี 1 23488020 8", B, 0, L); $this->SetFontSize($defaultsize);
    $this->SetFontSize($textsize); $this->Cell(80, $lh, $quo_id, B, 0, R); $this->SetFontSize($defaultsize);
    $this->Cell(10, $lh, "", RB, 1, R);

    $this->Cell(90, $lh - 4, "", LR, 0, L);
    $this->Cell(90, $lh - 4, "", LR, 1, L);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    //$this->Text($x + 5, $y + 2, "บริษัทผู้เช่า/ผู้ว่าจ้าง :");
    $this->Cell(20, $lh, $space . "นาม :", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(70, $lh, $space . cuName($customer["cu_type"], $customer["cu_name"]), R, 0, L); $this->SetFontSize($defaultsize);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->Text($x + 5, $y + 2, "วันที่ :");
    $this->Cell(30, $lh, $space . "Date : ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(60, $lh, splitdate($row['quo_date'], "avg"), R, 1, L); $this->SetFontSize($defaultsize);


    $x = $this->GetX(); $y = $this->GetY(); // Remember position

    $this->SetXY(35, $y + 1);
    $this->SetFontSize($textsize); $this->MultiCell(70, $lh - 2, $customer['cu_address'], 0); $this->SetFontSize($defaultsize);

    $this->SetXY($x, $y);
    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->Text($x + 5, $y + 2, "ที่อยู่ :");
    $this->Cell(90, $lh, $space . "Address : ", LR, 0, L);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->Text($x + 5, $y + 2, "");
    $this->Cell(30, $lh, $space . "", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(60, $lh, "", R, 1, L); $this->SetFontSize($defaultsize);


    $this->Text($this->GetX() + 5, $this->GetY() + 2, "");
    $this->Cell(30, $lh, $space . "", L, 0, L);
    $this->Cell(60, $lh, "", R, 0, L);


    $this->Cell(90, $lh, "", LR, 1, L);



    $this->Cell(180, $lh - 4, "", T, 1, C); // no
  }

  function Content() {

    global $quo_id, $customer, $product, $row, $quo_no;

    $this->SetFillColor(220, 220, 220);
    $border = 1;
    $lh = 7;
    $textsize = 13;
    $defaultsize = 9;

    $space = "        ";

    $i = 1;
    $sql_d = "SELECT * FROM quotation_d WHERE quo_id='$quo_id' ";
    //echo $sql_d;
    $result_d = mysql_query($sql_d);
    $rownum = mysql_num_rows($result_d); // จำนวนแถวข้อมูล

    $rowmax = ceil($rownum / 12) * 12;
    $this->SetFontSize($textsize);
    $this->Cell(10, $lh + 2, "ลำดับ", 1, 0, C);
    $this->Cell(100, $lh + 2, "รายการ", 1, 0, C);
    $this->Cell(20, $lh + 2, "จำนวน", 1, 0, C);
    $this->Cell(20, $lh + 2, "หน่วยละ (บาท)", 1, 0, C);
    $this->Cell(30, $lh + 2, "จำนวนเงิน (บาท)", 1, 1, C);


    //จำนวนแถวที่จะแสดงทั้งหมด
    while ($i <= $rowmax) {
      $row_d = mysql_fetch_assoc($result_d);
      $bdtable = "LR";
      if ($i % 12 == 0)
        $bdtable = "LBR";
      if ($i % 13 == 0) {
        $this->AddPage();
        $this->Cell(10, $lh + 2, "ลำดับ", 1, 0, C);
        $this->Cell(100, $lh + 2, "รายการ", 1, 0, C);
        $this->Cell(20, $lh + 2, "จำนวน", 1, 0, C);
        $this->Cell(20, $lh + 2, "หน่วยละ (บาท)", 1, 0, C);
        $this->Cell(30, $lh + 2, "จำนวนเงิน (บาท)", 1, 1, C);
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
        $this->Cell(20, $lh + 2, number_format($row_d['perunit'], 2), $bdtable, 0, C);
        $this->Cell(30, $lh + 2, number_format($row_d['total'], 2), $bdtable, 1, C);
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
//    $this->Cell(110, $lh, "", LR, 0, C);
//    $this->Cell(40, $lh, "รวม", 1, 0, L);
//    $this->Cell(30, $lh, number_format($row['quo_subtotal'], 2), 1, 1, C);
//
//    $this->Cell(110, $lh, "กรุณาชำระด้วยเช็คขีดคร่อม โดย สั่งจ่ายในนามมงคลทวีทรัพย์", LR, 0, C);
//    $this->Cell(40, $lh, "หัก ส่วนลด", 1, 0, L);
//    $this->Cell(30, $lh, number_format($row['quo_discount'], 2), 1, 1, C);

    $this->Cell(110, $lh, bathformat(number_format($row['quo_total'], 2)), 1, 0, C);
    $this->Cell(40, $lh, "รวมราคาสินค้า", 1, 0, L);
    $this->Cell(30, $lh, number_format($row['quo_after_discount'], 2), 1, 1, C);

    $this->Cell(110, $lh, "*ในกรณีที่ชำระด้วยเช็คธนาคาร  ใบเสร็จรับเงินจะเสร็จสมบูรณ์ต่อเมื่อ", LR, 0, L);
    $this->Cell(40, $lh, "ภาษีมูลค่าเพิ่ม %", 1, 0, L);
    $this->Cell(30, $lh, number_format($row['quo_vat'], 2), 1, 1, C);
    $this->Cell(110, $lh, "ได้เรียกเก็บเงินจากธนาคารเรียบร้อยแล้ว", LRB, 0, L);
    $this->Cell(40, $lh, "รวมเป็นเงินทั้งสิ้น", 1, 0, L);
    $this->Cell(30, $lh, number_format($row['quo_total'], 2), 1, 1, C);

    $this->Cell(180, $lh - 4, "", TB, 1, C); // no

    $x = $this->GetX(); $y = $this->GetY();
    $this->quot($x + 8, $y + 1, 5, 5);
    $this->Cell(15, $lh, "", L, 0, L);
    $this->Cell(165, $lh, "เงินสด           จำนวนเงิน ___________________________________  บาท", R, 1, L);
    $x = $this->GetX(); $y = $this->GetY();
    $this->quot($x + 8, $y + 1, 5, 5);
    $this->Cell(15, $lh, "", L, 0, L);
    $this->Cell(165, $lh, "เช็คธนาคาร   ____________________________________________  สาขา _________________________", R, 1, L);
    $this->Cell(15, $lh, "", LB, 0, L);
    $this->Cell(165, $lh, "เลขที่เช็ค   _____________________  ลงวันที่ __________________  ผู้รับเงินแล้ว________________", RB, 1, L);


    $this->ln(4);
    $this->Cell(180, $lh, "หมายเหตุ : กรุณาตรวจสอบชื่อและที่อยู่ของท่านในใบกำกับภาษีให้ถูกต้อง หากมีการแก้ไขใบกำกับภาษีใหม่", 0, 1, L);
    $this->Cell(14, $lh, "", 0, 0, L);
    $this->Cell(166, $lh, "ทางร้านจะดำเนินการเฉพาะเอกสารที่ส่งมาแก้ไข ภายใน 7 วัน นับจากวันที่ออกใบกำกับภาษีเท่านั้น", 0, 1, L);
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
$pdf->AddFont('Angsana', '', 'AngsabUPC.ttf', true);
$pdf->SetFont('Angsana', '', 9);
$pdf->AliasNbPages();
$pdf->SetLeftMargin(15);
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
//$outputFilename = $row['quo_id'] . ".pdf";
//$pdf->Output($outputFilename, 'D');
?>