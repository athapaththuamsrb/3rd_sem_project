<?php
require_once('.auth.php');
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_SESSION['user'];
    $data = ['success' => false];
    if (isset($_POST['type']) && isset($_POST['dose']) && isset($_POST['amount']) && $_POST['type'] && is_numeric($_POST['dose']) && is_numeric($_POST['amount'])) {
        $district = $user->getDistrict();
        $place = $user->getPlace();
        $date = new DateTime();
        try{
            $date = new DateTime($_POST['date']);
            $now = new DateTime("now");
            if ($date < $now){
                echo json_encode($data);
                die();
            }
        }
        catch (Exception $e){
            echo json_encode($data);
            die();
        }
        $type = $_POST['type'];
        if ($type != "Pfizer" && $type != "Moderna" && $type != "Sinopharm" && $type != "Aztraseneca"){
            echo json_encode($data);
            die();
        }
        $dose = intval($_POST['dose']);
        if ($dose <= 0){
            echo json_encode($data);
            die();
        }
        $amount = intval($_POST['amount']);
        require_once('../.utils/dbcon.php');
        $con = DatabaseConn::get_conn();
        $success = false;
        if ($dose > 0 && $amount > 0) {
            if ($con && $con->update_stocks($district, $place, $date, $type, 'not_reserved', $amount, $dose)) {
                $success = true;
            }
        }
        echo json_encode(['success' => $success]);
    }
    die();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccination/updateStock.php');
