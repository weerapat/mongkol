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
    // Logo
    if ($row['contacten_company'] == 1) {
      $this->Image('images/mitmongkol.jpg', 15, 15, 20, 25, 'jpg');
    }

    $this->SetY(15);
    $this->SetFont('cordiab', 'B');
    // Title
    $this->SetFontSize(22);
    if ($row['contacten_company'] == 1) {
      $this->Cell(25);
      $this->Cell(30, 5, 'มิตรมงคล/MITMONGKOL', 0, 1, 'L');
    } else if ($row['contacten_company'] == 2) {
      $this->Cell(80);
      $this->Cell(30, 5, 'มงคลทวีทรัพย์/MONGKOLTAWEESUP', 0, 1, 'C');
    }
    $this->Ln();
    $this->SetFontSize(13);


    if ($row['contacten_company'] == 1) {
      $this->Cell(25);
      $this->Cell(30, 5, '32/15 ม.4 ถ.สุขุมวิท ต.บางละมุง อ.บางละมุง จ.ชลบุรี 20150 โทร. (038) 241428,081-7816233  แฟกซ์ (038)240150', 0, 1, 'L');
      $this->Cell(25);
      $this->Cell(30, 5, '32/15 Moo 4 Sukhumvit Rd., Banglamung,Banglamung Chonburi 20150 Tel.(038) 241428,081-7816233  Fax (038)240150', 0, 1, 'L');
      $this->Cell(25);
      $this->Cell(30, 5, 'E-mail: mitmongkol@gmail.com  Website: www.mitmongkols.com', 0, 1, 'L');
    } else if ($row['inv_company'] == 2) {
      $this->Cell(180, 5, '32/15 ม.4 ถ.สุขุมวิท ต.บางละมุง อ.บางละมุง จ.ชลบุรี 20150 โทร. (038) 241428,081-7816233  แฟกซ์ (038)240150', 0, 1, 'C');

      $this->Cell(180, 5, '32/15 Moo 4 Sukhumvit Rd., Banglamung,Banglamung Chonburi 20150 Tel.(038) 241428,081-7816233  Fax (038)240150', 0, 1, 'C');

      $this->Cell(180, 5, 'E-mail: mitmongkol@gmail.com  Website: www.mitmongkols.com', 0, 1, 'C');
    }


    // Line break
    $this->Ln(8);
  }

  function Content() {

    global $contacten_id, $customer, $product, $row, $contacten_no;
    $this->SetFillColor(220, 220, 220);
    $border = 1;
    $lh = 7;
    $textsize = 12;
    $defaultsize = 11;

    $space = "      ";

    $this->SetLeftMargin(5);
    $this->Cell(90, 0, "", 0, 0, L);
    $this->Cell(90, 0, "", 0, 1, L);



    //$this->AddFont('Angsana', '', 'AngsabUPC.ttf', true);
    $this->SetFontSize(15);


    $this->SetFont('cordiab', 'B');
    $this->Cell(200, $lh + 1, "สัญญาว่าจ้าง / เช่าและรับรองเวลาทำงาน / RENTAL AGREEMENT", $border, 1, C, 1); // no
    $this->SetFont('cordia', '');

    $this->Cell(110, $lh - 4, "", LR, 0, L);
    $this->Cell(90, $lh - 4, "", LR, 1, L);

    $this->SetFontSize($defaultsize);
    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->Text($x + 5, $y + 2, "บริษัทผู้เช่า/ผู้ว่าจ้าง :");
    $this->Cell(20, $lh, $space . "Rent Company :", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(90, $lh, "                      " . cuName($customer["cu_type"], $customer["cu_name"]), R, 0, L); $this->SetFontSize($defaultsize);
    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->Text($x + 5, $y + 2, "เลขที่สัญญา :");
    $this->Cell(30, $lh, $space . "Agreement No : ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(60, $lh, $contacten_id, R, 1, L); $this->SetFontSize($defaultsize);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position

    $this->SetXY(35, $y + 1);
    $this->SetFontSize($textsize); $this->MultiCell(70, $lh - 2, $customer['cu_address'], 0); $this->SetFontSize($defaultsize);

    $this->SetXY($x, $y);
    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->Text($x + 5, $y + 2, "ที่อยู่ :");
    $this->Cell(110, $lh, $space . "Address : ", LR, 0, L);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->Text($x + 5, $y + 2, "วันที่ :");
    $this->Cell(30, $lh, $space . "Date : ", L, 0, L);

    $this->SetFontSize($textsize); $this->Cell(60, $lh, splitdate($row['contacten_date'], "avg"), R, 1, L); $this->SetFontSize($defaultsize);
    $this->Cell(110, $lh, "", LR, 0, L);

    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->Text($x + 5, $y + 2, "เงื่อนไขการชำระเงิน :");
    $this->Cell(30, $lh, $space . "Term of payment : ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(60, $lh, $customer['cu_termpayment'], R, 1, L); $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 5, $this->GetY() + 2, "โทรศัพท์ :");
    $this->Cell(30, $lh, $space . "Tel : ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(20, $lh, $customer['cu_phone'], '', 0, L); $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 5, $this->GetY() + 2, "แฟกซ์ :");
    $this->Cell(30, $lh, $space . "Fax : ", '', 0, L);
    $this->SetFontSize($textsize); $this->Cell(30, $lh, $customer['cu_fax'], R, 0, L); $this->SetFontSize($defaultsize);


    $this->Text($this->GetX() + 5, $this->GetY() + 2, "ใบสั่งเลขที่ :");
    $this->Cell(30, $lh, $space . "PO.No :  ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(60, $lh, $row['contacten_pono'], R, 1, L); $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 5, $this->GetY() + 2, "ชื่อผู้ติดต่อ :");
    $this->Cell(20, $lh, $space . "Contact by : ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(90, $lh, "             " . $customer['cu_contact'], R, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(90, $lh, "", R, 1, L);

    $this->SetFontSize(15);
    $this->SetFont('cordiab', 'B');
    $this->Cell(200, $lh + 1, "รายการ / Description", $border, 1, C, 1); // no
    $this->SetFont('cordia', '');

    $this->SetFontSize($defaultsize);
    $this->Cell(110, $lh - 4, "", LR, 0, L);
    $this->Cell(90, $lh - 4, "", LR, 1, L);
    $this->Text($this->GetX() + 5, $this->GetY() + 2, "ประเภท :");
    $this->Cell(20, $lh, $space . "Kind : ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(90, $lh, productType($product["product_type"], $product["product_no"]), R, 0, L); $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 5, $this->GetY() + 2, "สถานที่ใช้งาน :");
    $this->Cell(30, $lh, $space . "Deliver to : ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(60, $lh, $row['contacten_workplace'], R, 1, L); $this->SetFontSize($defaultsize);

    $this->Text($this->GetX() + 5, $this->GetY() + 2, "แบบ / ขนาด :");
    $this->Cell(20, $lh, $space . "Form / Size : ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(25, $lh, $product['product_size'], '', 0, L); $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 1, $this->GetY() + 2, "หมายเลข :");
    $this->Cell(15, $lh, "No : ", '', 0, L);
    $this->SetFontSize($textsize); $this->Cell(50, $lh, $product['product_number'], R, 0, L); $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 5, $this->GetY() + 2, "ลักษณะงาน :");
    $this->Cell(40, $lh, $space . "Quality of Work : ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(50, $lh, $row['contacten_workappear'], R, 1, L); $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 5, $this->GetY() + 2, "อุปกรณ์ :");
    $this->Cell(20, $lh, $space . "Accessories : ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(40, $lh, $space . getnameEquipment(1, $contacten_no), 0, 0, L); $this->SetFontSize($defaultsize);
    $this->SetFontSize($textsize); $this->Cell(50, $lh, $space . getnameEquipment(2, $contacten_no), R, 0, L); $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 5, $this->GetY() + 2, "มูลค่าสินค้า :");
    $this->Cell(30, $lh, $space . "Full Replace Value : ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(15, $lh, number_format($row['contacten_productprice'], 2), 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(45, $lh, $space . "บาท", R, 1, L);
    $this->Cell(20, $lh, $space . "", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(40, $lh, $space . getnameEquipment(3, $contacten_no), 0, 0, L); $this->SetFontSize($defaultsize);
    $this->SetFontSize($textsize); $this->Cell(50, $lh, $space . getnameEquipment(4, $contacten_no), R, 0, L); $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 5, $this->GetY() + 2, "ชำระวันที่ทำสัญญา :");
    $this->Cell(30, $lh, $space . "Down Payment : ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(15, $lh, number_format($row['contacten_agreementdate'], 2), 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(45, $lh, $space . "บาท", R, 1, L);

    $this->SetFontSize(15);
    $this->SetFont('cordiab', 'B');
    $this->Cell(200, $lh + 1, "อัตราค่าเช่า / บริการ / Rate of Charge", $border, 1, C, 1); // no
    $this->SetFont('cordia', '');
    $this->SetFontSize($defaultsize);
    $this->Cell(100, $lh - 4, "", L, 0, L);
    $this->Cell(100, $lh - 4, "", R, 1, L);
    $this->Text($this->GetX() + 5, $this->GetY() + 2, "เวลาทำงานปกติ :");
    $this->Cell(35, $lh, $space . "Work Time :", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(10, $lh, $row['contacten_normaltime'], 0, 0, L); $this->SetFontSize($defaultsize);

    $this->Cell(10, $lh, "-", 0, 0, C);
    $this->SetFontSize($textsize); $this->Cell(65, $lh, $row['contacten_normaltimeto'] . " น.", 0, 0, L); $this->SetFontSize($defaultsize);

    $this->Text($this->GetX() + 1, $this->GetY() + 2, "ราคาต่อหน่วย :");
    $this->Cell(30, $lh, "Rage of Charge : ", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(15, $lh, $row['contacten_unit'] . "  " . number_format($row['contacten_priceperunit'], 2), 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(35, $lh, "บาท", R, 1, L);
    $this->Text($this->GetX() + 5, $this->GetY() + 2, "เวลาทำงานล่วงเวลา :");
    $this->Cell(35, $lh, $space . "Over Time :", L, 0, L);
//    $this->SetFontSize($textsize); $this->Cell(10, $lh, $row['Over Time'], 0, 0, L); $this->SetFontSize($defaultsize);
//    //$this->Text($this->GetX() + 3, $this->GetY() + 2, "ถึง :");
//    $this->Cell(10, $lh, "-", 0, 0, C);
    $this->SetFontSize($textsize); $this->Cell(40, $lh, "_________________________", 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 1, $this->GetY() + 2, "ชม. ละ :");
    $this->Cell(25, $lh, "Rage of Overtime :", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(10, $lh, number_format($row['contacten_hourprice'], 2), 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(10, $lh, "X", 0, 0, C);
    $this->Text($this->GetX() + 1, $this->GetY() + 2, "จำนวน ชม.:");
    $this->Cell(25, $lh, "Amount of Overtime :", 0, 0, L);
    //$this->SetFontSize($textsize); $this->Cell(15, $lh, $row['contacten_hourcount'], 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(10, $lh, "=", 0, 0, C);
    $this->SetFontSize($textsize); $this->Cell(30, $lh, "___________________", 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Cell(15, $lh, "บาท", R, 1, L);
    $this->Text($this->GetX() + 5, $this->GetY() + 2, "ขนส่ง จาก:");
    $this->Cell(20, $lh, $space . "Delivery From : ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(100, $lh, $row['contacten_transport'], 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 1, $this->GetY() + 2, "ค่าขนส่งไปกลับ :");
    $this->Cell(35, $lh, "Transportation Charge : ", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(45, $lh, number_format($row['contacten_transportprice'], 2), R, 1, L); $this->SetFontSize($defaultsize);


    $this->Text($this->GetX() + 5, $this->GetY() + 2, "ทะเบียนรถ :");
    $this->Cell(20, $lh, $space . "Register Car : ", L, 0, L);
    $this->SetFontSize($textsize); $this->Cell(40, $lh, $row['contacten_carlicense'], 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 1, $this->GetY() + 2, "กุญแจหาย :");
    $this->Cell(20, $lh, "Key Loss : ", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(10, $lh, $row['contacten_keyloss'], 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 1, $this->GetY() + 2, "/ดอก");
    $this->Cell(30, $lh, "/Pcs.", 0, 0, L);

    $this->Text($this->GetX() + 1, $this->GetY() + 2, "ฝาน้ำมันหาย :");

    $this->Cell(30, $lh, "Lid Of Oil Tank Loss : ", 0, 0, L);
    $this->SetFontSize($textsize); $this->Cell(10, $lh, $row['contacten_oilloss'], 0, 0, L); $this->SetFontSize($defaultsize);
    $this->Text($this->GetX() + 1, $this->GetY() + 2, "/ฝา");
    $this->Cell(40, $lh, "/Pcs.", R, 1, L);


    $x = $this->GetX(); $y = $this->GetY(); // Remember position
    $this->SetXY(35, $y + 1);
    $this->MultiCell(140, $lh - 2, $row['contacten_remark'], 0);
    $this->SetXY($x, $y);

    $this->Text($this->GetX() + 5, $this->GetY() + 2, "หมายเหตุ :");

     $this->SetFontSize($defaultsize);
    $this->Cell(200, $lh, $space . "Remark :", LR, 1, L);
    $this->Cell(200, $lh - 3, "", LR, 1, L);
    $this->Cell(200, $lh - 3, "ในกรณีเกิดอุบัติเหตุหรือความเสียหายใดๆ ผู้ว่าจ้างจะต้องรับผิดชอบต่อความเสียหายของเครื่องมือที่ตกลงเช่าและทรัพย์สินอื่นๆ ที่เกี่ยวข้องอันเกิดจากอุบัติเหตุจาก", LR, 1, C);
    $this->Cell(200, $lh - 3, "การใช้งานในขณะปฎิบัติงานตามคำสั่งของผู้ว่าจ้างหรือผู้ควบคุม  และหากเกิดอุบัติเหตุหรือความเสียหายใดๆในขณะปฎิบัติงาน  ทางบริษัทจะชดใช้ค่าเสียหายให้แก่", LR, 1, C);
    $this->Cell(200, $lh - 3, "ผู้ว่าจ้างไม่เกินอัตราค่าจ้างที่ตกลงว่าจ้างเท่านั้น", LR, 1, C);
    $this->Cell(200, $lh - 5, "", LR, 1, C);
    $this->SetFontSize($defaultsize);

    $this->SetFontSize(15);
    $this->SetFont('cordiab', 'B');
    $this->Cell(85, $lh + 1, "ผู้เช่า / ผู้ว่าจ้าง / SIGNATURE OF HIRER", $border, 0, C, 1);
    $this->Cell(115, $lh + 1, "ผู้ให้เช่า / ผู้รับจ้าง / COMPANY", $border, 1, C, 1);
    $this->SetFont('cordia', '');
    $this->SetFontSize($defaultsize);
    $this->Cell(85, $lh - 4, "", LR, 0, L);
    $this->Cell(115, $lh - 4, "", LR, 1, L);
    $this->Text($this->GetX() + 1, $this->GetY() + 2, "ลงชื่อ :");
    $this->Cell(50, $lh, "Signature :   _________________________", L, 0, L);

    $this->Text($this->GetX() + 1, $this->GetY() + 2, "ผู้เช่า / ผู้ว่าจ้าง / ผู้รับเครื่อง ");
    $this->Cell(35, $lh, "Hirer / Received By ", R, 0, L);


    $this->Text($this->GetX() + 1, $this->GetY() + 2, "ลงชื่อ :");
    $this->Cell(35, $lh, "Signature :   __________________", L, 0, L);

    $this->Text($this->GetX() + 5.5, $this->GetY() + 2, "ผู้รับงาน ");
    $this->Cell(25, $lh, "Representative ", 0, 0, R);

    $this->Text($this->GetX() + 1, $this->GetY() + 2, "ลงชื่อ :");
    $this->Cell(38, $lh, "Signature : ________________", 0, 0, L);

    $this->Text($this->GetX() + 0.5, $this->GetY() + 2, "พนักงานขับรถ ");
    $this->Cell(17, $lh, "Driver ", R, 1, L);

    $this->Text($this->GetX() + 1, $this->GetY() + 2, "วันที่เริ่ม :");
    $this->Cell(50, $lh, "Date :   _____________________________", L, 0, L);
    $this->Text($this->GetX() + 1, $this->GetY() + 2, "เวลา :");
    $this->Cell(35, $lh, "Time :   _________________", R, 0, L);
        $this->Text($this->GetX() + 1, $this->GetY() + 2, "ผู้ส่งเครื่อง :");
    $this->Cell(40, $lh, "Sender :   __________________", 0, 0, L);
    $this->Text($this->GetX() + 1, $this->GetY() + 2, "เลขไมล์สะสม :");
    $this->Cell(40, $lh, "Mile Meter :   __________________", 0, 0, L);
    $this->Text($this->GetX() + 1, $this->GetY() + 2, "น้ำมัน :");
    $this->Cell(35, $lh, "Oil Unit   ________________", R, 1, L);

    $this->Text($this->GetX() + 1, $this->GetY() + 2, "ลงชื่อ :");
    $this->Cell(50, $lh, "Signature :   _________________________", L, 0, L);
    $this->Text($this->GetX() + 1, $this->GetY() + 2, "ผู้ส่งกลับ/ผู้คุมงาน :");
    $this->Cell(35, $lh, "Project Head/Sender", R, 0, L);

    $this->Text($this->GetX() + 1, $this->GetY() + 2, "ผู้รับเครื่อง :");
    $this->Cell(40, $lh, "Take Back By :   ______________", 0, 0, L);
        $this->Text($this->GetX() + 1, $this->GetY() + 2, "เลขไมล์สะสม :");
    $this->Cell(40, $lh, "Mile Meter :   __________________", 0, 0, L);
    $this->Text($this->GetX() + 1, $this->GetY() + 2, "น้ำมัน :");
    $this->Cell(35, $lh, "Oil Unit   ________________", R, 1, L);

    $this->Text($this->GetX() + 1, $this->GetY() + 2, "วันที่ส่ง :");
    $this->Cell(50, $lh, "Date :   _____________________________", L, 0, L);

    $this->Text($this->GetX() + 1, $this->GetY() + 2, "เวลา :");
    $this->Cell(35, $lh, "Time :   _________________", R, 0, L);
    $this->Text($this->GetX() + 25, $this->GetY() + 2, "(1วัน/8 ชั่วโมง)(1 เดือน/240 ชั่วโมง)หากเกินคิดเฉลี่ยเป็นชั่วโมง");
    $this->Cell(115, $lh, "(1Day/8 Hour)(1 Month/240 Hour) Overtime Hour)", LR, 1, C);



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


    $this->Cell(200, $lh - 5, "", 0, 1, C);
    $this->SetFont('cordiab', 'BU');
    $this->SetFontSize(12); $this->Cell(20, $lh - 3, "ศูนย์รวมบริการ", 0, 0, C);
    $this->SetFont('cordia', '');
    $this->Cell(160, $lh - 3, "เครื่องกำเนิดไฟฟ้า  เครื่องเชื่อม เครื่องปั้มลม  เครื่องตบดิน  เครื่องตัดคอนกรีต  ตู้อ๊อกหลัง  รถบดโรลเลอร์  รถแบ็คโฮ  รถเจซีบี", 0, 1, L);
    $this->Cell(20, $lh - 3, "", 0, 0, C);
    $this->Cell(160, $lh - 3, "รถดั้ม  รถเฮี๊ยบ  รถเครน  รถเทรเลอร์  เต๊นท์  ตู้สโตร์  ตู้ออฟฟิศ  ห้องสุขาเคลื่อนที่  รับขนส่ง และรับจ้างอัดสายไฮโดรลิค", 0, 1, L);
    

    $this->SetFont('cordiab', 'B');
    $this->SetFontSize(15);
    $this->Text($this->GetX() + 85, $this->GetY() + 15, "ห้ามบรรทุกเกินพิกัดจราจร");
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
$pdf->AddFont('cordia', '', 'cordiaUPC.ttf', true);
$pdf->AddFont('cordiab', 'B', 'cordiaUPC.ttf', true);
$pdf->SetFont('cordia', '', 9);
$pdf->AliasNbPages();
$pdf->SetLeftMargin(15);
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
//$outputFilename = $row['contacten_id'] . ".pdf";
//$pdf->Output($outputFilename, 'D');
?>