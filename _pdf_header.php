<?php

$space = "       ";
// Logo
if ($company == 1) {
  $this->Image('images/mitmongkol.jpg', 15, 5, 20, 25, 'jpg');
} if ($company == 3) {
  $this->Image('images/mitmongkol_equip.jpg', 15, 5, 24, 20.5, 'jpg');
}

$this->SetY(5);

// Title
$this->SetFontSize(22);
if ($company == 1) {
  $this->Cell(25);
  $this->Cell(30, 5, 'มิตรมงคล/MITMONGKOL', 0, 1, 'L');
  $this->Ln();
} else if ($company == 2) {
  $this->Cell(80);
  $this->Cell(30, 5, 'มงคลทวีทรัพย์/MONGKOLTAWEESUP', 0, 1, 'C');
  $this->Ln();
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
?>
