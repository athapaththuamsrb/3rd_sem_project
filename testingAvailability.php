<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['district']) && isset($_POST['type']) && isset($_POST['date']) && $_POST['district'] && $_POST['type'] && $_POST['date']) {
    $data = [];
    $district = $_POST['district'];
    $type = $_POST['type'];
    if ($type != "PCR" && $type != "Rapid Antigen" && $type != "Antibody") {
      echo json_encode($data);
      die();
    }
    try {
      $date = new DateTime($_POST['date']);
      $now = new DateTime("now");
      if ($date < $now) {
        echo json_encode($data);
        die();
      }
    } catch (Exception $e) {
      echo json_encode($data);
      die();
    }
    require_once('.utils/dbcon.php');
    if ($con = DatabaseConn::get_conn()) {
      $data = $con->get_testing_availability($district, $type, $date);
    }
    echo json_encode($data);
  }
  die();
}
@include_once($_SERVER['DOCUMENT_ROOT'] . '/views/testingAvailability.php');
