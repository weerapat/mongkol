<?php

session_start();
include "header_php.php";
include "tfpdf/tfpdf.php";

$quo_no = $_GET['quo_no'];

$sql = "SELECT * FROM quotation_tab WHERE quo_no = '{$quo_no}' ";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);

$quo_id = getPrefix($row['quo_id'], $row['quo_company']);

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
    $defaultsize = 12;
    $this->SetFont('Angsanab', '');
    $company = $row['quo_company'];


    $space = "       ";
// Logo
    if ($company == 1) {
      $this->Image('images/mitmongkol.jpg', 15, 15, 20, 25, 'jpg');
    } if ($company == 3) {
      $this->Image('images/mitmongkol_equip.jpg', 15, 15, 24, 20.5, 'jpg');
    }

    $this->SetY(15);
// แต่เดิม $this->SetY(15);
// Title
    $this->SetFontSize(22);
    if ($company == 1) {
      $this->Cell(25);
      $this->Cell(30, 5, 'มิตรมงคล/MITMONGKOL (นางนิภา  ชินวัฒน์)', 0, 1, 'L');
      $this->Ln();
    } else if ($company == 2) {
      $this->Cell(80);
      $this->Cell(30, 5, 'มงคลทวีทรัพย์/MONGKOLTAWEESUP', 0, 1, 'C');
      $this->Ln(2);
      $this->SetFontSize(18);
      $this->Cell(180, 5, '(นายมงคล  คุ้มพลาย)', 0, 1, 'C');
//      $this->Ln();
    } else if ($company == 3) {
      $this->SetFontSize(18);
      $this->Cell(25);
      $this->Cell(30, 5, 'บริษัท มิตรมงคล อีควิปเม้นท์ เรนทัล จำกัด', 0, 1, 'L');
      $this->Cell(25);
      $this->Cell(30, 5, 'Mitmongkol Equipment Rental Co.,Ltd', 0, 1, 'L');
      $this->Ln(1);
    }

    $this->SetFontSize(13);



    if ($company == 1) {
      $this->Cell(25);
      $this->Cell(30, 5, '32/15 ม.4 ถ.สุขุมวิท ต.บางละมุง อ.บางละมุง จ.ชลบุรี 20150 โทร. (038) 241428,081-7816233  แฟกซ์ (038)240150', 0, 1, 'L');
      $this->Cell(25);
      $this->Cell(30, 5, '32/15 Moo 4 Sukhumvit Rd., Banglamung,Banglamung Chonburi 20150 Tel.(038) 241428,081-7816233  Fax (038)240150', 0, 1, 'L');
      $this->Cell(25);
      $this->Cell(30, 5, 'E-mail: mitmongkol@gmail.com  Website: www.mitmongkols.com', 0, 1, 'L');
    } else if ($company == 2) {
      $this->Cell(180, 5, '32/15 ม.4 ถ.สุขุมวิท ต.บางละมุง อ.บางละมุง จ.ชลบุรี 20150 โทร. (038) 241428,081-7816233  แฟกซ์ (038)240150', 0, 1, 'C');

      $this->Cell(180, 5, '32/15 Moo 4 Sukhumvit Rd., Banglamung,Banglamung Chonburi 20150 Tel.(038) 241428,081-7816233  Fax (038)240150', 0, 1, 'C');

      $this->Cell(180, 5, 'E-mail: mitmongkol@gmail.com  Website: www.mitmongkols.com', 0, 1, 'C');
    } else if ($company == 3) {
      $this->Cell(25);
      $this->Cell(30, 5, '32/15 ม.4 ถ.สุขุมวิท ต.บางละมุง อ.บางละมุง จ.ชลบุรี 20150 Tel. (038) 241428,081-7816233  Fax. (038)240150', 0, 1, 'L');
      $this->Cell(25);
      $this->Cell(30, 5, 'E-mail: mitmongkol@gmail.com  Website: www.mitmongkols.com', 0, 1, 'L');
      $this->Ln(4);
    }


    // Line break
    if ($company == 2) {
      $this->Ln(1);
    } else {
      $this->Ln(3);
    }


    $this->SetFontSize(18);
    $this->Cell(180, $lh + 1, "ใบเสนอราคา / Quotation", 0, 1, C); // no
    $this->SetFontSize(9);
    $this->Cell(10, $lh, "", B, 0, L);


    if ($row['quo_company'] == 1) {
      $this->SetFontSize($textsize); $this->Cell(170, $lh, "เลขประจำตัวผู้เสียภาษี / TAX ID   3200400057461", B, 1, R);
    } else if ($row['quo_company'] == 2) {
      $this->SetFontSize($textsize); $this->Cell(170, $lh, "เลขประจำตัวผู้เสียภาษี / TAX ID   3200400126985", B, 1, R);
    } else if ($row['quo_company'] == 3) {
      $this->SetFontSize($textsize); $this->Cell(170, $lh, "เลขประจำตัวผู้เสียภาษี / TAX ID   0205555027280", B, 1, R);
    }

    $this->Cell(110, $lh - 4, "", LR, 0, L);
    $this->Cell(70, $lh - 4, "", LR, 1, L);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    //$this->Text($x + 5, $y + 2, "บริษัทผู้เช่า/ผู้ว่าจ้าง :");

    $this->Cell(30, $lh, $space . "เรียน / To :", L, 0, L);
    $this->SetFont('Angsana', '');
    $this->SetFontSize($textsize); $this->Cell(80, $lh, $row['quo_nameto'], R, 0, L); $this->SetFontSize($defaultsize);
    $this->SetFont('Angsanab', '');
    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->Text($x + 5, $y + 2, "");
    $this->Cell(30, $lh, $space . "เลขที่ / No. : ", L, 0, L);
    $this->SetFont('Angsana', '');
    $this->SetFontSize($textsize); $this->Cell(40, $lh, "QT " . $quo_id, R, 1, L); $this->SetFontSize($defaultsize);
    $this->SetFont('Angsanab', '');



    $this->Cell(30, $lh, $space . "นามลูกค้า / Name :", L, 0, L);
    $this->SetFont('Angsana', '');
    $this->SetFontSize($textsize); $this->Cell(80, $lh, cuName($customer["cu_type"], $customer["cu_name"]), R, 0, L); $this->SetFontSize($defaultsize);
    $this->SetFont('Angsanab', '');
    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->Text($x + 5, $y + 2, "");
    $this->Cell(30, $lh, $space . "วันที่ / Date : ", L, 0, L);

    $this->SetFont('Angsana', '');
    $this->SetFontSize($textsize); $this->Cell(40, $lh, splitdate($row['quo_date'], "avg"), R, 1, L); $this->SetFontSize($defaultsize);
    $this->SetFont('Angsanab', '');


    $x = $this->GetX(); $y = $this->GetY(); // Remember position

    $this->SetXY(45, $y + 1);
    $this->SetFont('Angsana', '');
    $this->SetFontSize($textsize); $this->MultiCell(70, $lh - 2, $customer['cu_address'], 0, L); $this->SetFontSize($defaultsize);
    $this->SetFont('Angsanab', '');

    $this->SetXY($x, $y);
    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    //$this->Text($x + 5, $y + 2, "ที่อยู่ :");
    $this->Cell(110, $lh, $space . "ที่อยู่ / Address : ", LR, 0, L);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->Text($x + 5, $y + 2, "");
    $this->Cell(70, $lh, $space . "เงื่อนไขการชำระเงิน / Term of Payment : ", LR, 1, L);



    $this->Text($this->GetX() + 5, $this->GetY() + 2, "");
    $this->Cell(30, $lh - 2, $space . "", L, 0, L);
    $this->Cell(80, $lh - 2, "", R, 0, L);


    $this->SetFont('Angsana', '');
    $this->SetFontSize($textsize); $this->Cell(70, $lh - 2, $customer['cu_termpayment'], LR, 1, C); $this->SetFontSize($defaultsize);
    $this->SetFont('Angsanab', '');
    $this->Cell(30, $lh, $space . "โทรศัพท์ / Tel :", L, 0, L);

    $this->SetFont('Angsana', '');
    $this->SetFontSize($textsize); $this->Cell(38, $lh, $customer['cu_phone'], 0, 0, L); $this->SetFontSize($defaultsize);
    $this->SetFont('Angsanab', '');

    $this->Cell(22, $lh, $space . "แฟกซ์ / Fax :", 0, 0, L);
    $this->SetFont('Angsana', '');
    $this->SetFontSize($textsize); $this->Cell(20, $lh, $customer['cu_fax'], R, 0, L); $this->SetFontSize($defaultsize);
    $this->SetFont('Angsanab', '');


    $this->Cell(30, $lh, $space . "Email :", L, 0, L);


    $this->SetFont('Angsana', '');
    $this->SetFontSize($textsize); $this->Cell(40, $lh, $customer['cu_email'], R, 1, L); $this->SetFontSize($defaultsize);
    $this->SetFont('Angsanab', '');


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
    $this->Cell(25, $lh - 1, "หน่วยละ (บาท)", LTR, 0, C);
    $this->Cell(25, $lh - 1, "จำนวนเงิน (บาท)", LTR, 1, C);
    $this->Cell(10, $lh - 2, "Item", LBR, 0, C);
    $this->Cell(100, $lh - 2, "Description", LBR, 0, C);
    $this->Cell(20, $lh - 2, "Qty.", LBR, 0, C);
    $this->Cell(25, $lh - 2, "Unit Price", LBR, 0, C);
    $this->Cell(25, $lh - 2, "Amount", LBR, 1, C);
    $this->SetFont('Angsana', '');
    $lineHeight = 50.0;
    $bdtable = "LR";

    $startX = $this->GetX(); $startY = $this->GetY(); // save บรรทัดที่เริ่ม run

    $this->Cell(10, $lineHeight, "", $bdtable, 0, C);
    $this->Cell(100, $lineHeight, "", $bdtable, 0, C);
    $this->Cell(20, $lineHeight, "", $bdtable, 0, C);
    $this->Cell(25, $lineHeight, "", $bdtable, 0, C);
    $this->Cell(25, $lineHeight, "", $bdtable, 1, C);

    $bdtable = "LBR";  // บรรทัดสุดท้ายมีขอบล่าง
    $this->Cell(10, $lh + 2, "", $bdtable, 0, C);
    $this->Cell(100, $lh + 2, "", $bdtable, 0, C);
    $this->Cell(20, $lh + 2, "", $bdtable, 0, C);
    $this->Cell(25, $lh + 2, "", $bdtable, 0, C);
    $this->Cell(25, $lh + 2, "", $bdtable, 1, C);

    $endX = $this->GetX(); $endY = $this->GetY(); // save บรรทัดาสุดท้ายเพื่อนำไปขึ้นบรรในข้อมูลส่วนล่าง
    /// END set กรอบกลาง
  }

  function Content() {

    global $quo_id, $customer, $product, $row, $quo_no, $showmaxpage;


    $this->SetFillColor(220, 220, 220);

    $lh = 7;
    $textsize = 13;
    $defaultsize = 9;
    $startX = 15;
    $startY = 111;

    $this->SetFontSize($textsize);

    $this->SetFont('Angsana', '');
    $sql_d = "SELECT * FROM quotation_d WHERE quo_id='$quo_id' ORDER BY quod_id ";
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
      if ($this->GetY() > 150) {
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
      $this->Cell(25, $lh + 2, number_format($row_d['perunit'], 2), $bdtable, 0, R);
      $this->Cell(25, $lh + 2, number_format($row_d['total'], 2), $bdtable, 1, R);

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

    global $row, $customer, $showmaxpage;
    $lh = 7;

    $this->SetXY(15, 167);
    $this->SetFontSize(13);

    // show only last page
    if ($showmaxpage != 1) {
      $after_discount = "";
      $vat = "";
      $total = "";
      $subtotal = "";
      $discount = "";
      $bath = "";
    } else {
      $after_discount = number_format($row['quo_after_discount'], 2);
      $vat = number_format($row['quo_vat'], 2);
      $total = number_format($row['quo_total'], 2);
      $subtotal = number_format($row['quo_subtotal'], 2);
      $discount = number_format($row['quo_discount'], 2);
      $bath = " = " . bathformat(number_format($row['quo_total'], 2)) . " = ";
    }


    $this->SetFont('Angsana', '');
    $this->Cell(110, $lh, "", LTR, 0, C);
    $this->Cell(45, $lh, "รวมราคาสินค้า / Total", 1, 0, L);
    $this->Cell(25, $lh, $subtotal, 1, 1, R);

    $this->Cell(110, $lh, "", LR, 0, L);
    $this->Cell(45, $lh, "หัก ส่วนลด / Discount", 1, 0, L);
    $this->Cell(25, $lh, $discount, 1, 1, R);
    $this->SetFont('Angsanab', '');
    $this->Cell(110, $lh, $bath, LR, 0, C);
    $this->SetFont('Angsana', '');
    $this->Cell(45, $lh, "รวมเป็นเงิน / Total after discount", 1, 0, L);
    $this->Cell(25, $lh, $after_discount, 1, 1, R);

    $this->Cell(110, $lh, "", LR, 0, L);
    $this->Cell(45, $lh, "ภาษีมูลค่าเพิ่ม 7 % / Vat 7%", 1, 0, L);
    $this->Cell(25, $lh, $vat, 1, 1, R);
    $this->Cell(110, $lh, "", LRB, 0, L);
    $this->Cell(45, $lh, "รวมทั้งสิ้น/GrandTotal", 1, 0, L);
    $this->Cell(25, $lh, $total, 1, 1, R);



    $this->Cell(180, $lh - 4, "", 0, 1, C); // no

    $x = $this->GetX(); $y = $this->GetY();



    $this->SetFont('Angsanab', '');
    $this->Cell(180, $lh, "หมายเหตุ / Remark : ", 0, 1, L);
    $this->SetFont('Angsana', '');

    $this->SetX(30);
    $this->Multicell(0, 5, $row['quo_remark']);

    $this->SetY(240);
    $this->ln(10);
    $this->Cell(100, $lh, "", 0, 0, L);
    $this->Cell(20, $lh, "ผู้เสนอราคา :", 0, 0, L);
    $this->Cell(35, $lh - 1, "", B, 0, L);
    $this->Cell(25, $lh, "", 0, 1, L);
    $this->Cell(120, $lh, "", 0, 0, L);

    $x = $this->GetX(); $y = $this->GetY();
    $this->Text($x + 5, $y + 5, $row['quo_dealer']);
    $this->Cell(80, $lh, "(                                         )", 0, 1, L);

    $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' / {nb}', 0, 0, 'R');
  }

}

// Instanciation of inherited class
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddFont('Angsana', '', 'AngsaUPC.ttf', true);
$pdf->AddFont('Angsanab', '', 'AngsabUPC.ttf', true);
$pdf->SetFont('Angsanab', '', 9);

$pdf->SetLeftMargin(15);
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
//$outputFilename = $row['quo_id'] . ".pdf";
//$pdf->Output($outputFilename, 'D');
?>