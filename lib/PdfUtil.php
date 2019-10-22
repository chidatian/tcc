<?php

/**
* "setasign/fpdi": "^2.0",
*/
class PdfUtil
{
	/**
     * use setasign\Fpdi\FpdfTpl;
     */
    public function exportPDF($data)
	{
		$pdf = new \setasign\Fpdi\FpdfTpl();
        $pdf->AddPage();

        $templateId = $pdf->beginTemplate();
        $pdf->setFont('Helvetica');
        $pdf->Text(10, 10, $data['gpa']);
        $pdf->endTemplate();

        $pdf->useTemplate($templateId);

        /*for ($i = 9; $i > 0; $i--) {
            $pdf->AddPage();
            $pdf->useTemplate($templateId);
        }*/

        $pdf->Output("./PDF/test.pdf","F");
        exit;
	}

    /**
     * use setasign\Fpdi\Fpdi;
     */
	public function mergePDF()
	{
		// initiate FPDI
        $pdf = new \setasign\Fpdi\Fpdi();
        // add a page
        $pdf->AddPage();
        // set the source file
        $pdf->setSourceFile("./PDF/Class Profile.pdf");
        // import page 1
        $tplId = $pdf->importPage(1);
        // use the imported page and place it at point 10,10 with a width of 100 mm
        $pdf->useTemplate($tplId, 10, 10, 100);

        // now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetTextColor(255, 0, 0);
        $pdf->SetXY(30, 30);
        $pdf->Write(0, 'This is just a simple text');

        $pdf->Output("./PDF/merge.pdf","F");   
        exit;
	}
}