<?php
require_once('.auth.php');
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['type']) || !isset($_POST['email']) || !$_POST['username'] || !$_POST['password'] || !$_POST['type'] || !$_POST['email']) {
    header('Location: ' . $_SERVER['REQUEST_URI']);
    die();
  }
  $username = $_POST['username'];
  $password = $_POST['password'];
  $type = $_POST['type'];
  $email = $_POST['email'];
  $place = null;
  $district = null;
  if ($_POST['type'] != 'admin') {
    if (!isset($_POST['district']) || !isset($_POST['place']) || !$_POST['district'] || !$_POST['place']) {
      header('Location: ' . $_SERVER['REQUEST_URI']);
      die();
    }
    $place = $_POST['place'];
    $district = $_POST['district'];
  }
  require_once '../.utils/dbcon.php';
  $conn = DatabaseConn::get_conn();
  if (!$conn || !$conn->create_user(
    $username,
    $password,
    $type,
    $place,
    $district,
    $email
  )) {
    header('Location: ' .
      $_SERVER['REQUEST_URI']);
    die();
  }
  header('Location: /admin/');
  die();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/views/admin/createAccount.php');
