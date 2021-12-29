<?php
require_once '.auth.php';
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $user = $_SESSION['user'];
        if (isset($_POST['type']) && isset($_POST['dose']) && isset($_POST['amount']) && $_POST['type'] && $_POST['dose'] && $_POST['amount'] && is_numeric($_POST['dose']) && is_numeric($_POST['amount'])) {
            $district = $user->getDistrict();
            $place = $user->getPlace();
            $type = $_POST['type'];
            $dose = intval($_POST['dose']);
            $amount = intval($_POST['amount']);
            $count = 0;
            if ($dose > 0 && $amount > 0) {
                require_once('../.utils/mediator.php');
                $mediator = new Mediator($district, $type);
                $count = $mediator->sendEmails($user, $dose, $amount);
            }
            echo json_encode(['count' => $count]);
        }
    } catch (Exception $e) {
        echo json_encode(['count' => 0]);
    }
    die();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccination/requestVaccines.php');
