<?php
require_once('.auth.php');
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_SESSION['user'];
    $data = ['success' => false];
    if (isset($_POST['type']) && isset($_POST['dose']) && isset($_POST['amount']) && $_POST['type'] && is_numeric($_POST['dose']) && is_numeric($_POST['amount'])) {
        $type = $_POST['type'];
        $dose = intval($_POST['dose']);
        $amount = intval($_POST['amount']);
        $data = $user->updateStock($type, $dose, $amount);
    }
    echo json_encode($data);
    die();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccination/updateStock.php');
