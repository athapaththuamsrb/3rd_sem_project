<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && isset($_POST['token']) && $_POST['id'] && $_POST['token']) {
        $id = $_POST['id'];
        $token = $_POST['token'];
        require_once('.utils/dbcon.php');
        $data = null;
        if ($con = DatabaseConn::get_conn()) {
            $data = $con->get_vaccination_records($id, $token);
        }
        if (!$data || !is_array($data)) {
            $data = ['id' => $id, 'doses' => []];
        }
        if (isset($data['doses']) && $data['doses']) {
            require_once('vendor/autoload.php');
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // set document information
            $pdf->SetCreator('Online Vaccination and Testing Service');
            $pdf->SetAuthor('GRST');
            $pdf->SetTitle('Vaccination Certificate');
            $pdf->SetSubject('Vaccination Certificate');
            //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // set default header data
            //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
            //$pdf->SetHeaderData('', 0, 'Vaccination Certificate', 'Online Vaccination and Testing Service', array(0, 64, 255), array(0, 64, 128));
            //$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

            // set header and footer fonts
            //$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            //$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
                require_once(dirname(__FILE__) . '/lang/eng.php');
                $pdf->setLanguageArray($l);
            }

            // ---------------------------------------------------------

            // set default font subsetting mode
            $pdf->setFontSubsetting(true);

            // Set font
            // dejavusans is a UTF-8 Unicode font, if you only need to
            // print standard ASCII chars, you can use core fonts like
            // helvetica or times to reduce file size.
            $pdf->SetFont('dejavusans', '', 14, '', true);

            // Add a page
            // This method has several options, check the source code documentation for more information.
            $pdf->AddPage();

            // set text shadow effect
            //$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

            // Set some content to print
            $doses = $data['doses'];
            $html = "<style> table {border-collapse: collapse; width: 100%;} td,th {border: 1px solid #dddddd; text-align: left; padding: 8px;}</style><h1>Vaccination Certificate</h1><h2>ID : $data[id]</h2><h3>Name : $data[name]</h3><table><tr><th>Type</th><th>Date</th></tr>";
            foreach ($doses as $dose) {
                $html .= '<tr><td>' . $dose['type'] . '</td><td>' . $dose['date'] . '</td></tr>';
            }
            $html .= '</table>';
            /*<<<EOD
<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
<i>This is the first example of TCPDF library.</i>
<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
<p>Please check the source code documentation and other examples for further information.</p>
<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
EOD;*/

            // Print text using writeHTMLCell()
            $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

            $pdfFileName = "vaccine_$id.pdf";
            $pdfFilePath = $_SERVER['DOCUMENT_ROOT'] . "/certificates/$pdfFileName";
            $pdf->Output($pdfFilePath, 'F');
            header('Content-Type: application/pdf');
            header("Content-Disposition: attachment; filename=$pdfFileName;");
            header('Content-Length: ' . filesize($pdfFilePath));
            ob_clean();
            flush();
            readfile($pdfFilePath);
        } else {
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }
    die();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccineCertificate.php');
