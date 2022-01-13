<?php
require_once('.auth.php');
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = $_SESSION['user'];
  $data = ['success' => false];
  if (isset($_POST['date']) && isset($_POST['type']) && isset($_POST['dose']) && isset($_POST['amount']) && isset($_POST['onlineAmount']) && $_POST['date'] && $_POST['type'] && is_numeric($_POST['dose']) && is_numeric($_POST['amount']) && is_numeric($_POST['onlineAmount'])) {
    $type = $_POST['type'];
    try {
      $dose = intval($_POST['dose']);
      $amount = intval($_POST['amount']);
      $online = intval($_POST['onlineAmount']);
      $date = new DateTime($_POST['date']);
    } catch (Exception $e) {
      $data['reason'] = 'Invalid information';
      echo json_encode($data);
      die();
    }
    $data = $user->addStock($type, $dose, $date, $amount, $online);
  } else {
    $data = ['success' => false, 'reason' => 'Insufficient information'];
  }
  echo json_encode($data);
  die();
}

@include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccination/addStock.php');
