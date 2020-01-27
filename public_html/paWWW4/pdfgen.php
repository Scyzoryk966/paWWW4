<?php


require('plugin/fpdf.php');


class PDF extends FPDF
{

// Simple table
    function BasicTable($header, $data)
    {
        // Header
        foreach ($header as $col)
            $this->Cell(60, 7, $col, 0);
        $this->Ln();
        // Data
        foreach ($data as $row) {
            foreach ($row as $col)
                $this->Cell(60, 6, $col, 1);
            $this->Ln();
        }
    }
}
$pdf = new PDF();
// Column headings
$header = array('Nazwa', 'Ilosc', 'Cena');
// Data loading
$data = unserialize($_POST['pdf']);
$pdf->SetFont('Arial','b',14);
$pdf->AddPage();
$pdf->Cell(40,10,'Lista zakupow:',0,1,'C');
$pdf->SetFont('Arial','',14);
$pdf->BasicTable($header,$data);
$pdf->Output();
?>
