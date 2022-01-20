<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && isset($_POST['token']) && $_POST['id'] && $_POST['token']) {
        $data = null;
        $id = $_POST['id'];
        if (strlen($id) < 4 || strlen($id) > 12) {
            echo json_encode($data);
            die();
        }
        $token = $_POST['token'];
        if (strlen($token) != 6) {
            echo json_encode($data);
            die();
        }
        require_once('utils/dbcon.php');
        if ($con = DatabaseConn::get_conn()) {
            $data = $con->get_vaccination_records($id, $token);
        }
        if (!is_array($data)) {
            echo json_encode(['success' => false]);
            die();
        }
        if (!$data || !isset($data['doses'])) {
            $data = ['doses' => []];
        }
        if (isset($data['doses']) && $data['doses'] && isset($data['name']) && $data['name'] && isset($data['id']) && $data['id']) {
            error_reporting(0);
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
            //$pdf->SetMargins(0, 0, 0);
            //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            // if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            //     require_once(dirname(__FILE__) . '/lang/eng.php');
            //     $pdf->setLanguageArray($l);
            // }

            // ---------------------------------------------------------

            // set default font subsetting mode
            $pdf->setFontSubsetting(true);

            // Set font
            // dejavusans is a UTF-8 Unicode font, if you only need to
            // print standard ASCII chars, you can use core fonts like
            // helvetica or times to reduce file size.
            $pdf->SetFont('dejavusans', '', 14, '', true);

            // Add a page
            $pdf->AddPage();

            //$pdf->SetFillColor(255, 255, 220);
            //$pdf->Rect(0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), 'F', "");

            // Set some content to print
            $html = "<style>
                div{
                    color: black;
                    display: table;
                    font-family: Georgia, serif;
                    font-size: 24px;
                    text-align: center;
                }
                .container {
                    border: 20px solid blue;
                    width: 800px;
                    height: 563px;
                    display: table-cell;
                    vertical-align: middle;
                }
                .logo {
                    color: tan;
                }

                .marquee {
                    color: brown;
                    font-size: 48px;
                    margin: 20px;
                }
                .assignment {
                    margin: 20px;
                }
                .id,.person {
                    border-bottom: 2px solid black;
                    font-size: 32px;
                    font-style: italic;
                    margin: 20px auto;
                    width: 400px;
                }
                .reason {
                    margin: 20px;
                }
                table, th, td {
                    border:1px solid black;
                    margin-right: 5px;
                    padding: 15px 7px;
                    text-align: center;
                }
                .certificate{
                    border: 5px solid black;
                }
                </style>
                <div class=\"marquee\">
                    Certificate of Vaccination
                </div>

                <div class=\"assignment\">
                    This certificate is presented to
                </div>
                <div class=\"person\">
                    $data[name]
                </div>
                <div class=\"assignment\">
                  id number
                </div>
                <div class=\"id\">
                    $data[id]
                </div>
                <div class=\"reason\">
                    For showing vaccination details<br/>
                </div>
                <div class=\"table\">
                    <table style=\"width:100%\">
                      <tr>
                        <th>Vaccination type</th>
                        <th>Date</th>
                        <th>District</th>
                        <th>Place</th>
                      </tr>";
            $doses = $data['doses'];
            $table = '';
            foreach ($doses as $dose) {
                $table .= '<tr><td>' . $dose['type'] . '</td><td>' . $dose['date'] . '</td><td>' . $dose['district'] . '</td><td>' . $dose['place'] . '</td></tr>';
            }
            $html = $html . $table . '</table></div></div>';
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
            echo json_encode(['success' => false, 'doses' => []]);
        }
    } else {
        echo json_encode(['success' => false, 'reason' => 'insufficent data']);
    }
    die();
}
@include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccineCertificate.php');
