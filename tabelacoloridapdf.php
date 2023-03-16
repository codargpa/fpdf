<?php
require('fpdf.php');

class PDF extends FPDF
{

function LoadData($file)
{
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

public function Cell($w, $h=0,$txt='', $border=0, $ln=0, $align='', $fill=false, $link=''){
    $txt = utf8_decode($txt);
    parent::Cell($w, $h,$txt, $border, $ln, $align, $fill, $link);
}

function FancyTable($header, $data)
{
    $this->SetFillColor(255,69,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    $w = array(40, 20, 90, 25);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    $this->SetFillColor(210,180,140);
    $this->SetTextColor(0);
    $this->SetFont('');
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$row[2],'LR',0,'L',$fill);
        $this->Cell($w[3],6,$row[3],'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    
    $this->Cell(array_sum($w),0,'','T');
}
}

$pdf = new PDF();
$header = array('Nome', 'Curso', 'Disciplina', "Média");
$data = $pdf->LoadData('alunos.txt');
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();
?>