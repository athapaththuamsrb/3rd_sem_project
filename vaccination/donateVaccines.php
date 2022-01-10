<?php
require_once '.auth.php';
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = ['success' => false, 'email' => false];
    try {
        $user = $_SESSION['user'];
        if (isset($_POST['type']) && isset($_POST['place']) && isset($_POST['amount']) && isset($_POST['dose']) && $_POST['type'] && $_POST['place'] && is_numeric($_POST['amount']) && is_numeric($_POST['dose'])) {
            $type = $_POST['type'];
            $dose = intval($_POST['dose']);
            $amount = intval($_POST['amount']);
            $place = $_POST['place'];
            $data = $user->donateVaccines($type, $place, $amount, $dose);
        }
    } catch (Exception $e) {
        $data = ['success' => false, 'email' => false];
    }
    echo json_encode($data);
    die();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['type']) || !isset($_GET['place']) || !isset($_GET['amount']) || !$_GET['type'] || !$_GET['place'] || !is_numeric($_GET['amount'])) {
        header('Location: /vaccination/');
        die();
    }
    include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccination/donateVaccines.php');
}
