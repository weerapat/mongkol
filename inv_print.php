<?php

session_start();
include "header_php.php";
include "tfpdf/tfpdf.php";

$inv_no = $_GET['inv_no'];

$sql = "SELECT * FROM invoice_tab WHERE inv_no = '{$inv_no}'";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);


$inv_id = getPrefix($row['inv_id'], $row['inv_company']);

$customer = getCustomer($row['inv_customer']);
$product = getProduct($row['inv_productid']);
$showmaxpage = 0;

class PDF extends tFPDF {

// Page header
  function Header() {

    global $inv_id, $customer, $product, $row, $inv_no;
    $this->SetFillColor(220, 220, 220);
    $border = 1;
    $lh = 7;
    $textsize = 13;
    $defaultsize = 13;
    $this->SetFont('Angsanab', '');
    $company = $row['inv_company'];
    include "_pdf_header.php";


    // Line break
    $this->Ln(4);

    $this->SetFontSize(18);
    $this->Cell(180, $lh + 1, "ใบแจ้งหนี้ / INVOICE", 0, 1, C); // no
    $this->Ln(4);
    $this->SetFontSize(9);
    $this->Cell(10, $lh, "", B, 0, L);
    if ($row['inv_company'] == 1) {
      $this->SetFontSize($textsize); $this->Cell(80, $lh, "(นางนิภา  ชินวัฒน์) เลขประจำตัวผู้เสียภาษี /Tax ID. 3200400057461", B, 0, L);
    } else if ($row['inv_company'] == 2) {
      $this->SetFontSize($textsize); $this->Cell(80, $lh, "(นายมงคล  คุ้มพลาย) เลขประจำตัวผู้เสียภาษี /Tax ID. 3200400126985", B, 0, L);
    } else if ($row['inv_company'] == 3) {
      $this->SetFontSize($textsize); $this->Cell(80, $lh, " เลขประจำตัวผู้เสียภาษี /Tax ID. 0205555027280", B, 0, L);
    }

    $textsize = 13;

    $this->SetFontSize($textsize);
    $this->Cell(80, $lh, "", B, 0, R);
    $this->Cell(10, $lh, "", B, 1, R);

    $this->Cell(110, $lh - 4, "", LR, 0, L);
    $this->Cell(70, $lh - 4, "", LR, 1, L);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->SetFont('Angsanab', ''); $this->Cell(25, $lh, " นามลูกค้า / Name :", L, 0, L); $this->SetFont('Angsana', '');
    $this->Cell(85, $lh, cuName($customer["cu_type"], $customer["cu_name"]), R, 0, L);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->SetFont('Angsanab', ''); $this->Cell(30, $lh, $space . "เลขที่ / No : ", L, 0, L); $this->SetFont('Angsana', '');

    $this->Cell(40, $lh, "IV " . $inv_id, R, 1, L);


    $x = $this->GetX(); $y = $this->GetY(); // Remember position

    $this->SetXY(40, $y + 2);
    $this->MultiCell(70, $lh - 3.5, $customer['cu_address'], 0,L);

    $this->SetXY($x, $y);
    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->SetFont('Angsanab', ''); $this->Cell(110, $lh, " ที่อยู่ / Address : ", LR, 0, L); $this->SetFont('Angsana', '');

    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->SetFont('Angsanab', ''); $this->Cell(30, $lh, $space . "วันที่ / Date : ", L, 0, L); $this->SetFont('Angsana', '');
    $this->Cell(40, $lh, splitdate($row['inv_date'], "avg"), R, 1, L);


    $this->Cell(110, $lh, $space . "", LR, 0, L);
    $this->SetFont('Angsanab', ''); $this->Cell(50, $lh, $space . "เงื่อนไขการชำระเงิน / Term of payment : ", L, 0, L); $this->SetFont('Angsana', '');
    $this->Cell(20, $lh, "", R, 1, L);

    $this->SetFont('Angsanab', ''); $this->Cell(22, $lh, " โทรศัพท์ / Tel : ", L, 0, L); $this->SetFont('Angsana', '');
    $this->Cell(45, $lh, $customer['cu_phone'], '', 0, L);

    $this->SetFont('Angsanab', ''); $this->Cell(25, $lh, $space . "แฟกซ์ / Fax : ", '', 0, L); $this->SetFont('Angsana', '');
    $this->Cell(18, $lh, $customer['cu_fax'], R, 0, L);

    //$this->Text($this->GetX() + 5, $this->GetY() + 2, "");
    $this->Cell(30, $lh, $space, L, 0, L);
    $this->Cell(40, $lh, $customer['cu_termpayment'], R, 1, L);

    $this->SetFont('Angsanab', ''); $this->Cell(22, $lh, " Email : ", L, 0, L); $this->SetFont('Angsana', '');
    $this->Cell(88, $lh, $customer['cu_email'], '', 0, L);
   
    $this->Cell(70, $lh, $space . "", LR, 1, L);

    $this->Cell(180, $lh - 4, "", T, 1, C); // no

    $lh = 7;
    $textsize = 13;
    $defaultsize = 9;

/// set กรอบกลาง
    $this->SetFontSize($textsize);
    $this->SetFont('Angsanab', '');
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
    $this->SetFont('Angsana', '');

    $lineHeight = 73;
    $bdtable = "LR";

    $startX = $this->GetX(); $startY = $this->GetY(); // save บรรทัดที่เริ่ม run

    $this->Cell(10, $lineHeight, "", $bdtable, 0, C);
    $this->Cell(100, $lineHeight, "", $bdtable, 0, C);
    $this->Cell(20, $lineHeight, "", $bdtable, 0, C);
    $this->Cell(20, $lineHeight, "", $bdtable, 0, C);
    $this->Cell(30, $lineHeight, "", $bdtable, 1, C);

    $bdtable = "LBR";  // บรรทัดสุดท้ายมีขอบล่าง
    $this->Cell(10, $lh + 2, "", $bdtable, 0, C);
    $this->Cell(100, $lh + 2, "", $bdtable, 0, C);
    $this->Cell(20, $lh + 2, "", $bdtable, 0, C);
    $this->Cell(20, $lh + 2, "", $bdtable, 0, C);
    $this->Cell(30, $lh + 2, "", $bdtable, 1, C);

    $endX = $this->GetX(); $endY = $this->GetY(); // save บรรทัดาสุดท้ายเพื่อนำไปขึ้นบรรในข้อมูลส่วนล่าง
    /// END set กรอบกลาง
  }

  function Content() {

    global $inv_id, $customer, $product, $row, $inv_no, $showmaxpage;

    $this->SetFillColor(220, 220, 220);

    $lh = 7;
    $textsize = 13;
    $defaultsize = 9;
    $startX = 15;
    $startY = 106;

    $this->SetFontSize($textsize);


    $sql_d = "SELECT * FROM invoice_d WHERE inv_id='$inv_id' ORDER BY invd_id ";
    //echo $sql_d;
    $result_d = mysql_query($sql_d);

    // ตั้งค่าการขึ้นหน้าใหม่โดยกำหนดพิกัดท้ายสุด ที่บรรทัดจะเอื้อมถึงได้
    // กำหนดพิกัดเริ่มต้นของต้นแถว ในส่วนของข้อมูลรายการสินค้า
    $this->SetXY($startX, $startY);
    $bdtable = 0;
    $i = 1;
    //จำนวนแถวที่จะแสดงทั้งหมด
    while ($row_d = mysql_fetch_assoc($result_d)) { // เซตจำนวนบรรทัด
      // ถ้าถึงพิกัดที่กำหนดให้ขึ้นหน้าใหม่ พร้อม set พิกัดเริม่ต้นใหม่
      if ($this->GetY() > 180) {
        $newline = 0;
        $this->AddPage(); //ขึ้นหน้าใหม่
        $this->SetXY($startX, $startY);
      }

      if ($newline == 1) {
        $this->Ln(-2);
      }

      $this->Cell(10, $lh + 2, $i, $bdtable, 0, C);
      $this->Cell(5, $lh + 2, "", 0, 0, L);
      $x = $this->GetX(); $y = $this->GetY(); // จำตำแหน่งบรรเดียวกับ ต้นแถวไว้
      $this->SetXY($x, $this->GetY() + 2.3);
      $this->MultiCell(95, $lh - 2.5, $row_d['description']);
      $this->SetX($x + 5);
      $this->MultiCell(90, $lh - 2.5, $row_d['text_enclose']);
      $lastY = $this->GetY(); // จำตำแหน่งบรรเดียวกับ ท้ายแถวไว้

      $this->SetXY(125, $y); // set ตำแหน่งของ column จำนวน
      $this->Cell(20, $lh + 2, $row_d['amount'] . " " . $row_d['unit'], $bdtable, 0, C);
      $this->Cell(20, $lh + 2, number_format($row_d['perunit'], 2), $bdtable, 0, R);
      $this->Cell(30, $lh + 2, number_format($row_d['total'], 2), $bdtable, 1, R);

      $this->SetY($lastY);

      //$this->Cell(30, $lh + 2, $this->GetY(), $bdtable, 1, R);
      $newline = 1;
      $i++;
    }
    $showmaxpage = 1;

    $this->SetFontSize($defaultsize);
  }

// Page footer
  function Footer() {

    global $row, $showmaxpage;
    $lh = 7;

    $this->SetXY(15, 187);

    $this->SetFontSize(13);


    // show only last page
    if ($showmaxpage != 1) {
      $inv_after_discount = "";
      $inv_vat = "";
      $inv_deposit = "";
      $inv_total = "";
      $inv_subtotal = "";
      $inv_discount = "";
      $bath = "";
    } else {
      $inv_after_discount = number_format($row['inv_after_discount'], 2);
      $inv_vat = number_format($row['inv_vat'], 2);
      $inv_deposit = number_format($row['inv_deposit'], 2);
      $inv_total = number_format($row['inv_total'], 2);
      $inv_subtotal = number_format($row['inv_subtotal'], 2);
      $inv_discount = number_format($row['inv_discount'], 2);
      $bath = " = " . bathformat(number_format($row['inv_total'], 2)) . " = ";
    }


    $this->Cell(110, $lh, "", LR, 0, C);
    $this->Cell(40, $lh, "รวม/ Total", 1, 0, L);
    $this->Cell(30, $lh, $inv_subtotal, 1, 1, R);

    $this->SetFont('Angsanab', '');
    if ($row['inv_company'] == 1) {
      $this->Cell(110, $lh, "กรณีชำระด้วยเช็คกรุณาขีดคร่อม โดย สั่งจ่ายในนามมิตรมงคล", LR, 0, C);
    } else if ($row['inv_company'] == 2) {
      $this->Cell(110, $lh, "กรณีชำระด้วยเช็คกรุณาขีดคร่อม โดย สั่งจ่ายในนามมงคลทวีทรัพย์", LR, 0, C);
    } else if ($row['inv_company'] == 3) {
      $this->Cell(110, $lh, "กรณีชำระด้วยเช็คกรุณาขีดคร่อม โดย ", LR, 0, C);
    }
    $this->SetFont('Angsana', '');
    $this->Cell(40, $lh, "หัก ส่วนลด/ Discount", 1, 0, L);
    $this->Cell(30, $lh, $inv_discount, 1, 1, R);

    $this->SetFont('Angsanab', '');
    if ($row['inv_company'] == 1) {
      $this->Cell(110, $lh, "หรือสั่งจ่ายในนาม  นางนิภา  ชินวัฒน์", LR, 0, C);
    } else if ($row['inv_company'] == 2) {
      $this->Cell(110, $lh, "หรือสั่งจ่ายในนาม  นายมงคล  คุ้มพลาย", LR, 0, C);
    } else if ($row['inv_company'] == 3) {
      $this->Cell(110, $lh, "สั่งจ่ายในนามบริษัท มิตรมงคล อีควิปเม้นท์ เรนทัล จำกัด", LR, 0, C);
    }
    $this->SetFont('Angsana', '');
    $this->Cell(40, $lh, "รวมราคาสินค้า/ Total Amount", 1, 0, L);



    $this->Cell(30, $lh, $inv_after_discount, 1, 1, R);

    $this->Cell(110, $lh, "", LR, 0, C);
    $this->Cell(40, $lh, "ภาษีมูลค่าเพิ่ม 7%/ Vat 7%", 1, 0, L);
    $this->Cell(30, $lh, $inv_vat, 1, 1, R);

    $this->Cell(110, $lh, "", LRB, 0, C);
    $this->Cell(40, $lh, "หัก เงินมัดจำ/ Deposit", 1, 0, L);
    $this->Cell(30, $lh, $inv_deposit, 1, 1, R);

    $this->SetFont('Angsanab', '');
    $this->Cell(110, $lh, $bath, 1, 0, C);
    $this->SetFont('Angsana', '');
    $this->Cell(40, $lh, "รวมเป็นเงินทั้งสิ้น/ Grand total", 1, 0, L);
    $this->Cell(30, $lh, $inv_total, 1, 1, R);


    $this->Cell(55, $lh - 4, "", LR, 0, C);
    $this->Cell(55, $lh - 4, "", LR, 0, C);
    $this->Cell(70, $lh - 4, "", LR, 0, C);
    $this->Cell(55, $lh - 4, "", LR, 1, C);

    $this->Cell(12, $lh, "", L, 0, C);
    $this->Cell(30, $lh - 1, "", B, 0, C);
    $this->Cell(13, $lh, "", R, 0, C);
    $this->Cell(12, $lh, "", L, 0, C);
    $this->Cell(30, $lh - 1, "", B, 0, C);
    $this->Cell(13, $lh, "", R, 0, C);
    $this->Cell(30, $lh, "กำหนดชำระเงินวันที่", L, 0, C);
    $this->Cell(30, $lh - 1, "", B, 0, C);
    $this->Cell(10, $lh, "", R, 1, C);
    $this->Cell(55, $lh, "ผู้รับวางบิล / Bill Reciever ", LR, 0, C);
    $this->Cell(55, $lh, "ผู้วางบิล / Bill Presenter ", LR, 0, C);
    $this->Cell(70, $lh, "กรณีไม่ชำระเงินตามกำหนด  ท่านจะต้องเสียดอกเบี้ย", LR, 1, C);
    $this->Cell(20, $lh, "วันที่ / DATE :", L, 0, L);
    $this->Cell(30, $lh - 1, "", B, 0, C);
    $this->Cell(5, $lh, "", R, 0, C);
    $this->Cell(20, $lh, "วันที่ / DATE :", L, 0, L);
    $this->Cell(30, $lh - 1, "", B, 0, C);
    $this->Cell(5, $lh, "", R, 0, C);
    $this->Cell(70, $lh, "ในอัตราร้อยละ 1.5 ต่อเดือน", LR, 1, C);


    $this->Cell(55, $lh - 4, "", LRB, 0, C);
    $this->Cell(55, $lh - 4, "", LRB, 0, C);
    $this->Cell(70, $lh - 4, "", LRB, 0, C);


    $this->ln(4);
    $this->SetFont('Angsanab', '');
    $this->Cell(180, $lh, "หมายเหตุ : กรุณาลงชื่อผู้รับวางบิลและวันที่รับวางบิล  แล้วส่งเอกสารกลับมาให้มิตรมงคลทางแฟ็กซ์ 038-240150", 0, 1, L);
    $this->Cell(14, $lh, "", 0, 0, L);
    $this->Cell(166, $lh, "หรือทาง E-mail mitmongkol@gmail.com", 0, 1, L);
    $this->SetFont('Angsana', '');
    $this->SetY($this->GetY() - 10);
    $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' / {nb}', 0, 0, 'R');
  }

}

// Instanciation of inherited class
$pdf = new PDF('P', 'mm', array(210, 281));
$pdf->AliasNbPages();
$pdf->AddFont('Angsana', '', 'AngsaUPC.ttf', true);
$pdf->AddFont('Angsanab', '', 'AngsabUPC.ttf', true);
$pdf->SetFont('Angsana', '', 9);

$pdf->SetLeftMargin(15);
//$pdf->SetTopMargin(20);

$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>