<?php
require_once('.auth.php');
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = $_SESSION['user'];
  $data = ['success' => false];
  if (isset($_POST['token']) && isset($_POST['result']) && $_POST['token'] && $_POST['result']) {
    $token = $_POST['token'];
    $result = $_POST['result'];
    $data = $user->addResult($token, $result);
  }
  echo json_encode($data);
  die();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/views/testing/addTestResult.php');
