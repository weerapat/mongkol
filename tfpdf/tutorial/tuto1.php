<?php
require('../fpdf.php');

$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16,true);
$pdf->AddFont('AngsanaNew','','angsa.php');
$pdf->AddFont('AngsanaNew','B','angsab.php');
$pdf->AddFont('AngsanaNew','I','angsai.php');
//��˹�Ẻ�ѡ��
$pdf->SetFont('AngsanaNew','',18);
$pdf->Cell(0,10,'������ҧ Font ������');
$pdf->Ln(8);
$pdf->SetFont('AngsanaNew','B',20);
$pdf->Cell(0,10,'Font ������ AngsanaNew 20 ���˹�');
$pdf->Ln(8);
$pdf->SetFont('AngsanaNew','I',25);
$pdf->Cell(0,10,'Font ������ AngsanaNew 25 ������§');
$pdf->Output();

?>
