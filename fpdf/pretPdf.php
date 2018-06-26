<?php
require('fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('picto_clefs.png',15,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    
    $this->SetY(15);    
    // Move to the right
    $this->Cell(65);
    // Title
    $this->Cell(70,20,'PRET DE TROUSSEAU','BT',0,'C');
    // Line break
    $this->Ln(50);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    $this->Image('logo_enssat.png',170,280,30);
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$name = utf8_decode($_POST['user_choice']);
$datedeb = $_POST['date_debut_pret'];
$datefin = $_POST['date_fin_pret'];
$portes = $_POST['portes'];
$pdf->Cell(0,10,'Nom de l\'emprunteur : '.$name,0,1);
$pdf->Cell(0,10,'Date d\'emprunt : '.$datedeb,0,1);
$pdf->Cell(0,10,'Date de retour : '.$datefin,0,1);
$pdf->Cell(0,10,utf8_decode('Trousseau de clé(s) ouvrant la/les porte(s) : '),0,1);
for($i=0;$i<count($portes);$i++){
    $pdf->SetX(15);
    $pdf->Cell(0,10,$portes[$i],0,1);
}
$pdf->SetY(200);
$pdf->SetX(120);
$pdf->Cell(0,10,'Signature de l\'emprunteur :',0,1);
$pdf->Output();
?>