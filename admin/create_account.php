<?php
require_once('.auth.php');
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['type']) || !$_POST['username'] || !$_POST['password'] || !$_POST['type']) {
    header('Location: ' . $_SERVER['REQUEST_URI']);
    die();
  }
  $place = '';
  $district = '';
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
    $_POST['username'],
    $_POST['password'],
    $_POST['type'],
    $place,
    $district
  )) {
    header('Location: ' .
      $_SERVER['REQUEST_URI']);
    die();
  }
  header('Location: /admin/');
  die();
}

include_once('../views/admin/create_account.php');