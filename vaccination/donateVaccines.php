<?php
require_once '.auth.php';
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $user = $_SESSION['user'];
        if (isset($_POST['type']) && isset($_POST['place']) && isset($_POST['amount']) && isset($_POST['dose']) && $_POST['type'] && $_POST['place'] && is_numeric($_POST['amount']) && is_numeric($_POST['dose'])) {
            require_once('../.utils/dbcon.php');
            $type = $_POST['type'];
            $dose = intval($_POST['dose']);
            $amount = intval($_POST['amount']);
            $success = false;
            $email_sent = false;
            if ($dose > 0 && $amount > 0 && ($con = DatabaseConn::get_conn())) {
                $success = $con->update_stocks($user->getDistrict(), $user->getPlace(), (new DateTime())->format('Y-m-d'), $type, 'not_reserved', -$amount, $dose);
                if ($success) {
                    $district = $user->getDistrict();
                    $place = $_POST['place'];
                    $donor_place = $user->getPlace();
                    $email = $con->getEmailByPlace($district, $place, 'vaccination');
                    if ($email) {
                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $msg = "<html><body><h3>We can donate $amount vaccines from $donor_place to $place </h3><p>type : $type <br>dose : $dose <br>amount : $amount </p><p>You can collect the vaccines from $donor_place</p></body></html>";
                        $email_sent =  mail($email, "Donate vaccines", $msg, $headers);
                    }
                }
            }
            echo json_encode(['success' => $success, 'email' => $email_sent]);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'email' => false]);
    }
    die();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['type']) || !isset($_GET['place']) || !isset($_GET['amount']) || !$_GET['type'] || !$_GET['place'] || !is_numeric($_GET['amount'])) {
        header('Location: /vaccination/');
        die();
    }
    include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccination/donateVaccines.php');
}
