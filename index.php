<?php
require('fpdf.php');

class PDF extends FPDF
{

	var $y0;


	function Header()
	{
		//Page header
		global $title;
	
		$this->SetFont('Arial','B',15);
		$w=$this->GetStringWidth($title)+6;
		$this->SetX((210-$w)/2);
		$this->SetDrawColor(0,80,180);
		$this->SetFillColor(230,230,0);
		$this->SetTextColor(220,50,50);
		$this->SetLineWidth(1);
		$this->Cell($w,9,$title,1,1,'C',true);
		$this->Ln(10);
		//Save ordinate
		$this->y0=$this->GetY();
	}
	
	function Footer()
	{
		//Page footer
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->SetTextColor(128);
		$this->Cell(0,10,'Sayfa '.$this->PageNo(),0,0,'C');
	}
	
	
	
	function ChapterTitle($label)
	{
		//Title
		$this->SetFont('Arial','',12);
		$this->SetFillColor(200,220,255);
		$this->Cell(0,6,"$label",0,1,'L',true);
		$this->Ln(4);
		//Save ordinate
		$this->y0=$this->GetY();
	}
	
	function ChapterBody($file)
	{
		//Read text file
		$f=fopen($file,'r');
		$txt=fread($f,filesize($file));
		fclose($f);
		//Font
		$this->SetFont('Arial','',12);
		//Output text in a 6 cm width column
		$this->MultiCell(180,5,$txt);
		$this->Ln();
		//Mention
		$this->SetFont('','I');
		$this->Cell(0,5,'(sayfa sonu)');
		//Go back to first column
	}
	
	function PrintChapter($title,$file)
	{
		//Add chapter
		$this->AddPage();
		$this->ChapterTitle($title);
		$this->ChapterBody($file);
	}



}

$pdf=new PDF();
$title='Serpito.com deneme pdf generator';
$pdf->SetTitle($title);
$pdf->SetAuthor('Atilla Akoðlu');
$pdf->PrintChapter('lorem demosu','demo.txt');
$pdf->Output();
?>
