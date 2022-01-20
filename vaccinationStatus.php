<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = null;
  if (!isset($_POST['id']) || !$_POST['id']) {
    echo json_encode($data);
    die();
  }
  $id = $_POST['id'];
  if (strlen($id) < 4 || strlen($id) > 12) {
    echo json_encode($data);
    die();
  }
  require_once('utils/dbcon.php');
  $conn = DatabaseConn::get_conn();
  if ($conn) {
    $data = $conn->get_vaccination_records($id, null);
    if (isset($data['doses']) && is_array($data['doses'])) {
      $data = $data['doses'];
      foreach ($data as $key => $dose) {
        unset($data[$key]['place']);
        unset($data[$key]['district']);
      }
    }
  }
  echo json_encode($data);
  die();
}

@include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccinationStatus.php');
