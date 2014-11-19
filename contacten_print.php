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
    $border = 1;
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

    $this->Cell(110, $lh - 6, "", LTR, 0, L);
    $this->Cell(90, $lh - 6, "", LTR, 1, L);

    $this->SetFontSize($defaultsize);
    $x = $this->GetX(); $y = $this->GetY(); // Remember position

    $this->Cell(20, $lh, $space . "ลูกค้า", L, 0, L);
    $this->SetFontSize(16); $this->Cell(90, $lh, "     " . cuName($customer["cu_type"], $customer["cu_name"]), R, 0, L); $this->SetFontSize($defaultsize);
    $x = $this->GetX(); $y = $this->GetY(); // Remember position

    $this->Cell(35, $lh, $space . "เลขที่สัญญา ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(55, $lh, $contacten_id, R, 1, L); $this->SetFontSize($defaultsize);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position

    $this->SetXY(30, $y + 1);
    $this->SetFontSize($textsize); $this->MultiCell(70, $lh - 2, $customer['cu_address'], 0,L); $this->SetFontSize($defaultsize);

    $this->SetXY($x, $y);
    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->Text($x + 5, $y + 2, "");
    $this->Cell(110, $lh, $space . "", LR, 0, L);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position

    $this->Cell(35, $lh, $space . "วันที่ ", L, 0, L);

    $this->SetFontSize($textsize); $this->Cell(55, $lh, splitdate($row['contacten_date'], "avg"), R, 1, L); $this->SetFontSize($defaultsize);
    $this->Cell(110, $lh, "", LR, 0, L);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position

    $this->Cell(35, $lh, $space . "เงื่อนไขการชำระเงิน ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(55, $lh, $customer['cu_termpayment'], R, 1, L); $this->SetFontSize($defaultsize);

    $this->Cell(25, $lh, $space . "ชื่อผู้ติดต่อ ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(25, $lh, $customer['cu_contact'], '', 0, L); $this->SetFontSize($defaultsize);

    $this->Cell(20, $lh, $space . "โทรศัพท์ ", '', 0, L);
    $this->SetFontSize($textsize); $this->Cell(40, $lh, $customer['cu_phone'], R, 0, L); $this->SetFontSize($defaultsize);


    $this->Cell(35, $lh, $space . "ใบสั่งเลขที่  ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(55, $lh, $row['contacten_pono'], R, 1, L); $this->SetFontSize($defaultsize);


    $this->Cell(110, $lh - 4, "", LBR, 0, L);
    $this->Cell(90, $lh - 4, "", LBR, 1, L);


    $this->SetFont('cordia', '');

    $this->SetFontSize($defaultsize);

    $lh = $lh+2;

    $this->Ln(5);

    $this->Cell(25, $lh, $space . "ประเภท ", TLB, 0, L);
    $this->SetFontSize($textsize); $this->Cell(55, $lh, $row['contacten_productname'], TB, 0, L); $this->SetFontSize($defaultsize);

    $this->Cell(25, $lh, $space . "แบบ / ขนาด ", TB, 0, L);
    $this->SetFontSize($textsize); $this->Cell(50, $lh, $row['contacten_productsize'], TB, 0, L); $this->SetFontSize($defaultsize);

    $this->Cell(20, $lh, "หมายเลข ", BT, 0, L);
    $this->SetFontSize($textsize); $this->Cell(25, $lh, $row['contacten_productnumber'], TRB, 1, L); $this->SetFontSize($defaultsize);

    $this->Cell(45, $lh, $space . "สถานที่ใช้งาน ", LB, 0, L);
    $this->SetFontSize($textsize); $this->Cell(65, $lh, $row['contacten_workplace'], B, 0, L); $this->SetFontSize($defaultsize);

    $this->Cell(30, $lh, $space . "ลักษณะงาน ", B, 0, L);
    $this->SetFontSize($textsize); $this->Cell(60, $lh, $row['contacten_workappear'], RB, 1, L); $this->SetFontSize($defaultsize);
    
    $this->Cell(45, $lh, $space . "ชำระวันที่ทำสัญญา", LB, 0, L);
    $this->SetFontSize($textsize); $this->Cell(20, $lh, number_format($row['contacten_agreementdate'], 2), B, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(45, $lh, $space . "บาท", B, 0, L);


    $this->Cell(30, $lh, $space . "มูลค่าสินค้า ", B, 0, L);
    $this->SetFontSize($textsize); $this->Cell(15, $lh, number_format($row['contacten_productprice'], 2), B, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(45, $lh, $space . "บาท", BR, 1, L);
    $this->Cell(30, $lh, $space . "อุปกรณ์", LB, 0, L);

    $this->SetFontSize($textsize); $this->Cell(40, $lh, $space . $row['contacten_equipment1'], B, 0, L); $this->SetFontSize($defaultsize);
    $this->SetFontSize($textsize); $this->Cell(40, $lh, $space . $row['contacten_equipment2'], B, 0, L); $this->SetFontSize($defaultsize);
    $this->SetFontSize($textsize); $this->Cell(45, $lh, $space . $row['contacten_equipment3'], B, 0, L); $this->SetFontSize($defaultsize);
    $this->SetFontSize($textsize); $this->Cell(45, $lh, $space . $row['contacten_equipment4'], RB, 1, L); $this->SetFontSize($defaultsize);


    $this->SetFont('cordia', '');
    $this->SetFontSize($defaultsize);

    $this->Cell(35, $lh, $space . "เวลาทำงานปกติ", BL, 0, L);
    $this->SetFontSize($textsize); $this->Cell(80, $lh, $row['contacten_normaltime'], B, 0, L); $this->SetFontSize($defaultsize);

    // $this->Cell(10, $lh, "-", B , 0, C);
    // $this->SetFontSize($textsize); $this->Cell(60, $lh, $row['contacten_normaltimeto'] . " น.", B , 0, L); $this->SetFontSize($defaultsize);


    $this->Cell(30, $lh, "ราคาต่อหน่วย ", B, 0, L);
    $this->SetFontSize($textsize); $this->Cell(30, $lh, $row['contacten_unit'] . "  " . number_format($row['contacten_priceperunit'], 2), B, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(25, $lh, "บาท", RB, 1, L);

    $this->Cell(35, $lh, $space . "เวลาทำงานล่วงเวลา", LB, 0, L);
    $this->SetFontSize($textsize); $this->Cell(40, $lh, "", B, 0, L); $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 1, $this->GetY() + 2, "");
    $this->Cell(40, $lh, "", B, 0, L);

    $this->Cell(30, $lh, "OT ชม.ละ", B, 0, L);
    $this->SetFontSize($textsize); $this->Cell(30, $lh, number_format($row['contacten_hourprice'], 2), B, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(25, $lh, "บาท", RB, 1, L);

    $this->Cell(35, $lh, $space . "ขนส่ง จาก ", LB, 0, L);
    $this->SetFontSize($textsize); $this->Cell(80, $lh, $row['contacten_transport'], B, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(30, $lh, "ค่าขนส่งไปกลับ ", B, 0, L);
    $this->SetFontSize($textsize); $this->Cell(55, $lh, number_format($row['contacten_transportprice'], 2), RB, 1, L); $this->SetFontSize($defaultsize);


    $this->Cell(35, $lh, $space . "ทะเบียนรถ ", BL, 0, L);
    $this->SetFontSize($textsize); $this->Cell(80, $lh, $row['contacten_carlicense'], B, 0, L); $this->SetFontSize($defaultsize);


    $this->Cell(30, $lh, "ฝาน้ำมันหาย ", B, 0, L);
    $this->SetFontSize($textsize); $this->Cell(30, $lh, $row['contacten_oilloss'], B, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(25, $lh, "/ฝา", RB, 1, L);


    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->SetXY(40, $y);
     $this->SetFontSize($textsize);
    $this->MultiCell(140, $lh , $row['contacten_remark'], 0);
    $this->SetXY($x, $y);



    $this->SetFontSize($defaultsize);
    $this->Cell(115, $lh, $space . "หมายเหตุ", LB, 0, L);
    
   
    $this->Cell(30, $lh, "กุญแจหาย ", B, 0, L);
    $this->SetFontSize($textsize); $this->Cell(30, $lh, $row['contacten_keyloss'], B, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(25, $lh, "/ดอก", RB, 1, L);


    $lh = $lh-2;

    $this->Ln(2);

    $this->SetFontSize($defaultsize - 3.5);
    $this->Cell(200, $lh , "ในกรณีเกิดอุบัติเหตุหรือความเสียหายใดๆ ผู้ว่าจ้างจะต้องรับผิดชอบต่อความเสียหายของเครื่องมือที่ตกลงเช่าและทรัพย์สินอื่นๆ ที่เกี่ยวข้องอันเกิดจากอุบัติเหตุจาก", 0, 1, C);
    $this->Cell(200, $lh - 3, "การใช้งานในขณะปฎิบัติงานตามคำสั่งของผู้ว่าจ้างหรือผู้ควบคุม  และหากเกิดอุบัติเหตุหรือความเสียหายใดๆในขณะปฎิบัติงาน  ทางบริษัทจะชดใช้ค่าเสียหายให้แก่ผู้ว่าจ้างไม่เกินอัตราค่าจ้างที่ตกลงว่าจ้างเท่านั้น", 0, 1, C);
    
    $this->Ln(3);

    $this->SetFontSize($defaultsize);

    $this->SetFontSize(15);
    $this->SetFont('cordiab', 'B');
    $this->Cell(85, $lh + 1, "ผู้เช่า / ผู้ว่าจ้าง / SIGNATURE OF HIRER", $border, 0, C, 1);
    $this->Cell(115, $lh + 1, "ผู้ให้เช่า / ผู้รับจ้าง / COMPANY", $border, 1, C, 1);
    $this->SetFont('cordia', '');
    $this->SetFontSize($defaultsize);
    $this->Cell(85, $lh - 4, "", LR, 0, L);
    $this->Cell(115, $lh - 4, "", LR, 1, L);
    $this->Cell(20, $lh, "ลงชื่อ", L, 0, L);
    $this->Cell(25, $lh, "___________________", 0, 0, 0);

    $this->Cell(40, $lh, "ผู้เช่า / ผู้ว่าจ้าง / ผู้รับเครื่อง ", R, 0, L);


    $this->Cell(40, $lh, "ลงชื่อ   _________________", L, 0, L);

    $this->Cell(20, $lh, "ผู้รับงาน ", 0, 0, L);

    $this->Cell(33, $lh, "ลงชื่อ ______________", 0, 0, L);

    $this->Cell(22, $lh, "พนักงานขับรถ ", R, 1, L);

    $this->Cell(20, $lh+2, "วันที่เริ่ม", L, 0, L);
    $this->Cell(25, $lh+2, "___________________", 0, 0, 0);

    $this->Cell(40, $lh+2, "เวลา   ________________", R, 0, L);

    $this->Cell(40, $lh+2, "ผู้ส่งเครื่อง   _____________", 0, 0, L);

    $this->Cell(40, $lh+2, "เลขไมล์สะสม   ___________", 0, 0, L);

    $this->Cell(35, $lh+2, "น้ำมัน   _____________", R, 1, L);

    $this->Cell(20, $lh+2, "ลงชื่อ", L, 0, L);
    $this->Cell(25, $lh+2, "___________________", 0, 0, 0);

    $this->Cell(40, $lh+2, "ผู้ส่งกลับ/ผู้คุมงาน", R, 0, L);

    $this->Cell(40, $lh+2, "ผู้รับเครื่อง   _____________", 0, 0, L);

    $this->Cell(40, $lh+2, "เลขไมล์สะสม   ___________", 0, 0, L);

    $this->Cell(35, $lh+2, "น้ำมัน   _____________", R, 1, L);


    $this->Cell(20, $lh+2, "วันที่ส่ง", LB, 0, L);
    $this->Cell(25, $lh+2, "___________________", B, 0, 0);

    $this->Cell(40, $lh+2, "เวลา   ________________", RB, 0, L);
   
    $this->Cell(115, $lh+2, "(1วัน/8 ชั่วโมง)(1 เดือน/240 ชั่วโมง)หากเกินคิดเฉลี่ยเป็นชั่วโมง", LRB, 1, C);






    $this->Cell(200, $lh - 5, "", 0, 1, C);
    $this->SetFont('cordiab', 'BU');
    $this->SetFontSize(12);

    $this->Ln(1);

    $this->Cell(20, $lh - 3, "", 0, 0, C);
    $this->Cell(20, $lh - 3, "ศูนย์รวมบริการ", 0, 0, C);
    $this->SetFont('cordia', '');
    $this->Cell(160, $lh - 3, "เครื่องกำเนิดไฟฟ้า  เครื่องเชื่อม เครื่องปั้มลม  เครื่องตบดิน  เครื่องตัดคอนกรีต  ตู้อ๊อกพลัง  รถบดโรลเลอร์  รถแบ็คโฮ  รถเจซีบี", 0, 1, L);
    $this->Cell(20, $lh - 3, "", 0, 0, C);
    $this->Cell(160, $lh - 3, "รถดั้ม  รถเฮี๊ยบ  รถเครน  รถเทรเลอร์  เต๊นท์  ตู้สโตร์  ตู้ออฟฟิศ  ห้องสุขาเคลื่อนที่  รับขนส่ง และรับจ้างอัดสายไฮโดรลิค", 0, 1, L);

    $this->Ln(5);

    $this->SetFontSize(15);
    $this->SetFont('cordiab', 'B');
    $this->Cell(200, $lh + 1, "บันทึก/NOTE", $border, 1, C, 1);
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
    $this->Text($this->GetX() + 82, $this->GetY() + 8, "ห้ามบรรทุกเกินพิกัดจราจร");
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