<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = [];
  if (!isset($_POST['id']) || !$_POST['id'] && !isset($_POST['token']) || !$_POST['token']) {
    echo json_encode($data);
    die();
  }
  $id = $_POST['id'];
  $token = $_POST['token'];
  if (strlen($id) < 4 || strlen($id) > 12 || strlen($token) != 6) {
    echo json_encode($data);
    die();
  }
  require_once('.utils/dbcon.php');
  $conn = DatabaseConn::get_conn();
  if ($conn) {
    $result = $conn->get_test_result($id, $token);
    if ($result) {
      $data = $result;
    }
  }
  echo json_encode($data);
  die();
}

@include_once($_SERVER['DOCUMENT_ROOT'] . '/views/testResults.php');
