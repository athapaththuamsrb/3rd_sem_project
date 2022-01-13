<?php
require_once '.auth.php';
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = ['count' => 0];
    try {
        $user = $_SESSION['user'];
        if (isset($_POST['type']) && isset($_POST['dose']) && isset($_POST['amount']) && $_POST['type'] && $_POST['dose'] && $_POST['amount'] && is_numeric($_POST['dose']) && is_numeric($_POST['amount'])) {
            $type = $_POST['type'];
            $dose = intval($_POST['dose']);
            $amount = intval($_POST['amount']);
            $data = $user->requestVaccines($type, $dose, $amount);
        } else {
            $data = ['count' => 0, 'reason' => 'Insufficient data'];
        }
    } catch (Exception $e) {
        $data = ['count' => 0, 'resaon' => 'Server error'];
    }
    echo json_encode($data);
    die();
}

@include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccination/requestVaccines.php');
