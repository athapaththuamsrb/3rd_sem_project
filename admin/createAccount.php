<?php
require_once('.auth.php');
check_auth();

function sendSuccess($success)
{
  echo json_encode(['success' => $success]);
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
  require_once('../.utils/accounts.php');
  $user = $_SESSION['user'];
  $success = $user->createUserAccount($type, $email, $username, $password, $place, $district);
  sendSuccess($success);
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/views/admin/createAccount.php');
