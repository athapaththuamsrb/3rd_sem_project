<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['district']) && isset($_POST['type']) && isset($_POST['dose']) && isset($_POST['date']) && $_POST['district'] && $_POST['type'] && is_numeric($_POST['dose']) && $_POST['date']) {
    require_once('utils/accounts.php');
    $district = $_POST['district'];
    $type = $_POST['type'];
    $dose = intval($_POST['dose']);
    $datestr = $_POST['date'];
    $data = [];
    try {
      if (!in_array($type, VACCINES, true) || !in_array($district, DISTRICTS, true)) { // Invalid data
        $data['reason'] = 'Invalid Type';
        echo json_encode($data);
        die();
      }
      if ($dose <= 0) {
        $data['reason'] = 'Invalid Dose';
        echo json_encode($data);
        die();
      }
      $date = new DateTime($datestr);
      $yesterday = new DateTime('yesterday');
      if ($date <= $yesterday) {
        $data['reason'] = 'Invalid Date';
        echo json_encode($data);
        die();
      }
      if ($con = DatabaseConn::get_conn()) {
        $data = $con->getAvailability($district, $type, $dose, $date);
      } else {
        $data['reason'] = 'Server error';
      }
    } catch (Exception $e) {
      echo json_encode($data);
      die();
    }
    echo json_encode($data);
    die();
  }
  die();
}
@include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccineAvailability.php');
