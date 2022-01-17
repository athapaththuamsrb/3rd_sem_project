<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['district']) && isset($_POST['type']) && isset($_POST['dose']) && isset($_POST['date']) && $_POST['district'] && $_POST['type'] && is_numeric($_POST['dose']) && $_POST['date']) {
    require_once('.utils/dbcon.php');
    require_once('.utils/global.php');
    $data = [];
    $district = $_POST['district'];
    $type = $_POST['type'];
    if (!in_array($type, VACCINES, true) || !in_array($district, DISTRICTS, true)) { // Invalid data
      $data['reason'] = 'Invalid Type';
      echo json_encode($data);
      die();
    }
    $dose = intval($_POST['dose']);
    if ($dose <= 0) {
      $data['reason'] = 'Invalid Dose';
      echo json_encode($data);
      die();
    }
    try {
      $date = new DateTime($_POST['date']);
      $yesterday = new DateTime('yesterday');
      if ($date <= $yesterday) {
        $data['reason'] = 'Invalid Date';
        echo json_encode($data);
        die();
      }
    } catch (Exception $e) {
      echo json_encode($data);
      die();
    }
    if ($con = DatabaseConn::get_conn()) {
      $data = $con->getAvailability($district, $type, $dose, $date);
    } else {
      $data['reason'] = 'Server error';
    }
    echo json_encode($data);
  }
  die();
}
@include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccineAvailability.php');
