<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['district']) && isset($_POST['type']) && isset($_POST['dose']) && isset($_POST['date']) && $_POST['district'] && $_POST['type'] && is_numeric($_POST['dose']) && $_POST['date']) {
    $district = $_POST['district'];
    $type = $_POST['type'];
    $dose = intval($_POST['dose']);
    $date = new DateTime($_POST['date']);
    require_once('.utils/dbcon.php');
    if ($con = DatabaseConn::get_conn()) {
      $data = $con->getAvailability($district, $type, $dose, $date);
    } else {
      $data = [];
    }
    echo json_encode($data);
  }
  die();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccineAvailability.php');
