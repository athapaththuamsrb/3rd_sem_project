<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_POST['id']) || !$_POST['id']) {
    die();
  }
  $id = $_POST['id'];
  require_once('.utils/dbcon.php');
  $conn = DatabaseConn::get_conn();
  if ($conn) {
    $data = $conn->get_vaccination_records($id, null);
    if (isset($data['doses']) && is_array($data['doses'])) {
      $data = $data['doses'];
      foreach ($data as $key => $dose) {
        unset($data[$key]['place']);
      }
    } else {
      $data = null;
    }
  } else {
    $data = null;
  }
  echo json_encode($data);
  die();
}

include_once($_SERVER['DOCUMENT_ROOT'].'/views/vaccinationStatus.php');
