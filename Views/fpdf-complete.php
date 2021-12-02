<?php
// include class
ob_start();
require('vendor/fpdf/fpdf.php');
// create document
$pdf = new FPDF();
$pdf->AddPage();

// add text
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30,10,"NOMBRE",1);
$pdf->Cell(30,10,"APELLIDO",1);
$pdf->Cell(70,10,"EMAIL",1);
$pdf->Cell(30,10,"FileNber",1);
$pdf->Ln();
foreach($userList as $value)
{
    $pdf->Cell(30,10,$value->getName(),1);
    $pdf->Cell(30,10,$value->getSurname(),1);
    $pdf->Cell(70,10,$value->getEmail(),1);
    $pdf->Cell(30,10,$value->getFileNumber(),1);
    $pdf->Ln();
}

// output file
//$pdf->Output("pdf/nombre_del_archivo.pdf","F");
//ob_end_flush();
//require_once("pdf.php");
$pdf->Output();
ob_end_flush();

?>