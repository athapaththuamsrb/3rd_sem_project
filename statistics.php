<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = [];
  if (!isset($_POST['district']) || !isset($_POST['dose']) || !$_POST['district'] || !is_numeric($_POST['dose'])) {
    echo json_encode($data);
    die();
  }
  require_once('.utils/global.php');
  $district = $_POST['district'];
  if ($district === 'all') {
    $district = null;
  } else if (!in_array($district, DISTRICTS, true)) {
    $data['reason'] = 'Invalid district';
    echo json_encode($data);
    die();
  }
  $dose = intval($_POST['dose']);
  if ($dose < 0) {
    $data['reason'] = 'Invalid dose';
    echo json_encode($data);
    die();
  }
  require_once('.utils/dbcon.php');
  $conn = DatabaseConn::get_conn();
  if (!$conn) {
    $data['reason'] = 'Server error';
    echo json_encode($data);
    die();
  }
  if ($dose) {
    $data['result'] = $conn->getVaccineStatistics($dose, $district);
  } else {
    $data['result'] = $conn->getTestStatistics($district);
  }
  echo json_encode($data);
  die();
}
@include_once($_SERVER['DOCUMENT_ROOT'] . '/views/statistics.php');
