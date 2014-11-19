<?php

$space = "       ";

$this->SetY(5);
$this->SetLeftMargin(5);
// Title
$this->Ln(5);
$this->SetFontSize(22);
if ($company == 1) {
  $this->Cell(80, 5, 'มิตรมงคล/MITMONGKOL', 0, 1, 'L');

} else if ($company == 2) {

  $this->Cell(80, 5, 'มงคลทวีทรัพย์/MONGKOLTAWEESUP', 0, 1, 'L');

} else if ($company == 3) {

  $this->Cell(80, 5, 'บริษัท มิตรมงคล อีควิปเม้นท์ เรนทัล จำกัด', 0, 1, 'L');

}

  $this->Ln(3);
$this->SetFontSize(14);
  

  $this->Cell(150, 5, '', 0, 1, 'L');

  $this->Cell(150, 5, '', 0, 1, 'L');

  $this->Cell(150, 5, '', 0, 1, 'L');


$x = $this->GetX(); $y = $this->GetY(); // Remember position

$xRightbox = 115;

$this->SetXY($xRightbox, 10);
$this->SetFontSize(22);
$this->Cell(90, 2, '', '', 1, 'C');
$this->SetX($xRightbox);
$this->Cell(90, 8, '', '', 1, 'C');

$this->SetX($xRightbox);
$this->Cell(90, 8, '', '', 1, 'C');

$this->SetX($xRightbox);
$this->Cell(90, 2, '', '', 1, 'C');


$this->SetXY($x, $y);

?>
