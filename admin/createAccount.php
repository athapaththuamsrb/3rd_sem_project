<?php
require_once('.auth.php');
check_auth();

function sendSuccess($success){
  echo json_encode(['success'=>$success]);
  die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['type']) || !isset($_POST['email']) || !isset($_POST['district']) || !isset($_POST['place'])) {
    sendSuccess(false);
  }
  require_once '../.utils/factory.php';
  $details = ['username' => $_POST['username'], 'password' => $_POST['password'], 'email' => $_POST['email'], 'place' => $_POST['place'], 'district' => $_POST['district']];
  $accountSaver = AccountFactory::getAccount($_POST['type'], $details);
  if ($accountSaver && $accountSaver instanceof IaccountSaver && $accountSaver->saveToDB()) {
    sendSuccess(true);
  }
  sendSuccess(false);
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/views/admin/createAccount.php');
