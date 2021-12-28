<?php
require_once '.auth.php';
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_SESSION['user'];
    if (isset($_POST['type']) && isset($_POST['dose']) && isset($_POST['amount']) && $_POST['type'] && $_POST['dose'] && $_POST['amount'] && is_numeric($_POST['dose']) && is_numeric($_POST['amount'])) {
        $user = $_SESSION['user'];
        $district = $user->getDistrict();
        $place = $user->getPlace();
        $type = $_POST['type'];
        $dose = intval($_POST['dose']);
        $amount = intval($_POST['amount']);
        $online = intval($_POST['onlineAmount']);
        require_once('../.utils/dbcon.php');
        $con = DatabaseConn::get_conn();
        $success = false;
        if ($dose > 0 && $amount > 0 && $online >= 0 && $amount >= $online) {
            if ($emails = $con->getVaccineCentreEmailsInDistrict($district, $type, $dose)) {
                //send emails for vaccine centres
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                // the message
                $msg = '<html>
                        <body>
                        <h3>We need more vaccines</h3>
                        <p>
                        click <a href="http://oldcomputer.home/vaccination/login.php">this link</a> to donate vaccines.
                        </p>
                        </body>
                        </html>';
                foreach ($emails as $key => $email) {
                    mail($email, "REquest more vaccines", $msg);
                }
            }
        }
        echo json_encode(['success' => $success]);
    }
    die();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccination/requestVaccines.php');
