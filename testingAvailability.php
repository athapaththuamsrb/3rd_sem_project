<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['district']) && isset($_POST['type']) && isset($_POST['date']) && $_POST['district'] && $_POST['type'] && $_POST['date']) {
    require_once('utils/dbcon.php');
    require_once('utils/global.php');
    $data = [];
    $district = $_POST['district'];
    $type = $_POST['type'];
    if (!in_array($type, TESTS, true) || !in_array($district, DISTRICTS, true)) { // Invalid data
      echo json_encode($data);
      die();
    }
    try {
      $date = new DateTime($_POST['date']);
      $now = new DateTime('today');
      if ($date < $now) {
        echo json_encode($data);
        die();
      }
    } catch (Exception $e) {
      echo json_encode($data);
      die();
    }
    if ($con = DatabaseConn::get_conn()) {
      $data = $con->get_testing_availability($district, $type, $date);
    }
    echo json_encode($data);
  }
  die();
}
@include_once($_SERVER['DOCUMENT_ROOT'] . '/views/testingAvailability.php');
