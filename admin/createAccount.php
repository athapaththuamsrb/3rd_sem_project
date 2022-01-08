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
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  $type = $_POST['type'];
  $district = $_POST['district'];
  $place = $_POST['place'];
  $uname_pattern = '/^[a-zA-Z0-9_]{5,20}$/';
  $pw_pattern = '/^\S{8,15}$/';
  $email_pattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
  if (!preg_match($uname_pattern, $uname) || !preg_match($pw_pattern, $pw) || !preg_match($email_pattern, $email)){
    sendSuccess(false);
  }
  if ($type != "admin" && $type != "vaccination" && $type != "testing"){
    sendSuccess(false);
  }
  require_once '../.utils/factory.php';
  $details = ['username' => $username, 'password' => $_password, 'email' => $email, 'place' => $place, 'district' => $district];
  $accountSaver = AccountFactory::getAccount($type, $details);
  if ($accountSaver && $accountSaver instanceof IaccountSaver && $accountSaver->saveToDB()) {
    sendSuccess(true);
  }
  sendSuccess(false);
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/views/admin/createAccount.php');
