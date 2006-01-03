<?php
require('../../../src/fpdf/fpdf.php');

class PDF extends FPDF
{
//Page header
function Header()
{
    if($this->PageNo() == 1) {
    //Logo
    $this->Image('/senokian/Websites/unstable/themes/default/company1.jpg',166,8,33);
    //Helvetica bold 15
    $this->SetTextColor(0,0,0);
    //Move to the right
    //Title
    $this->SetFont('Helvetica','',10);
    $this->Ln(20);
    $this->Cell(166,0,'7th March 2005',0,1,'L');
    $this->SetFont('Helvetica','B',10);
    $this->Cell(166,0,'Studios 20 - 21 Coventry Canal Warehouse',0,1,'R');
    $this->Ln(4);
    $this->SetFont('Helvetica','',10);
    $this->Cell(166,0,'Ref No: ',0,1,'L');
    $this->SetFont('Helvetica','B',10);
    $this->Cell(166,0,'Leicester Row, Coventry CV1 4LH',0,1,'R');
    $this->Ln(8);
    $this->SetTextColor(0,0,0);
    $this->SetFont('Helvetica','',10);
    $this->Cell(100,0,'Hospice in the Weald',0,0,'L');
    $this->SetFont('Helvetica','B',10);
    $this->Cell(66,0,'0870 744 2030',0,0,'R');
    $this->SetTextColor(102,102,102);
    $this->Cell(33,0,'Tel',0,1,'L');
    $this->Ln(4);
    $this->SetFont('Helvetica','',10);
    $this->SetTextColor(0,0,0);
    $this->Cell(100,0,'Maidstone Road',0,0,'L');
    $this->Cell(66,0,'0870 460 2623',0,0,'R');
    $this->SetTextColor(102,102,102);
    $this->Cell(33,0,'Fax',0,1,'L');
    $this->Ln(4);
    $this->SetTextColor(0,0,0);
    $this->Cell(100,0,'Pembury',0,0,'L');
    $this->SetFont('Helvetica','I',10);
    $this->Cell(66,0,'info@senokian.com',0,0,'R');
    $this->SetFont('Helvetica','',10);
    $this->SetTextColor(102,102,102);
    $this->Cell(33,0,'E-mail',0,1,'L');
    $this->Ln(4);
    $this->SetTextColor(0,0,0);
    $this->Cell(100,0,'Tunbridge Wells',0,0,'L');
    $this->SetFont('Helvetica','I',10);
    $this->Cell(66,0,'www.senokian.com',0,0,'R');
    $this->SetFont('Helvetica','',10);
    $this->SetTextColor(102,102,102);
    $this->Cell(33,0,'URL',0,1,'L');
    $this->Ln(4);
    $this->SetFont('Helvetica','',10);
    $this->SetTextColor(0,0,0);
    $this->Cell(166,0,'Kent TN2 4TA',0,0,'L');
    $this->Ln(4);
    //Line break
    }
}

//Page footer
function Footer()
{
    //Position at 1.5 cm from bottom
    $this->SetY(-15);
    //Helvetica italic 8
    $this->SetFont('Helvetica','',7);
    $this->SetTextColor(0,0,0);
    //Page number
    $this->Cell(166,0,'Senokian Solutions Ltd',0,0,'R');
    $this->SetTextColor(102,102,102);
    $this->Cell(35,0,'Registered in England',0,1,'L');
    $this->Ln(3);
    $this->SetTextColor(0,0,0);
    $this->Cell(166,0,'04415783',0,0,'R');
    $this->SetTextColor(102,102,102);
    $this->Cell(35,0,'Company No.',0,1,'L');
    $this->Ln(3);
    $this->SetTextColor(0,0,0);
    $this->Cell(166,0,'GB 793 8163 86',0,0,'R');
    $this->SetTextColor(102,102,102);
    $this->Cell(35,0,'VAT No.',0,1,'L');
    $this->Ln(3);
    $this->SetTextColor(0,0,0);
    $this->Cell(166,0,'The TechnoCentre, Coventry University Technology Park, Puma Way, Coventry CV1 2TT',0,0,'R');
    $this->SetTextColor(102,102,102);
    $this->Cell(35,0,'Registered Office',0,1,'L');
    $this->Ln(3);
}
}

//Instanciation of inherited class
$pdf=new PDF('P', 'mm', 'a4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Helvetica','',11);

$pdf->Cell(0,10,'Dear Sir/Madam,',0,1);
$pdf->Write(5,'In January 2004, my father - David Stride - was lucky enough to be given a bed at your hospice for which our family is eternally grateful. It made his last few days so much more bearable for all of us, and knowing that there were people looking after him made this difficult time slightly easier.');
$pdf->Ln(10);
$pdf->Write(5, 'We were recently lucky enough to be able to ask The Southern Sporting Clubs to undertake some fund raising at one of their sporting dinners for The Hospice in the Weald, and as a result I have included a cheque for £800 which they raised at their dinner - I hope that you can put the money to good use.');
$pdf->Ln(10);
$pdf->Write(5, 'Yours Sincerely');
$pdf->Ln(30);
$pdf->Write(5, 'Jake Stride');

$pdf->Output();
?>
