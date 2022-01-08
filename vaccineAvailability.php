<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['district']) && isset($_POST['type']) && isset($_POST['dose']) && isset($_POST['date']) && $_POST['district'] && $_POST['type'] && is_numeric($_POST['dose']) && $_POST['date']) {
    $data = [];
    $district = $_POST['district'];
    $type = $_POST['type'];
    if ($type != "Pfizer" && $type != "Moderna" && $type != "Sinopharm" && $type != "Aztraseneca"){
      echo json_encode($data);
      die();
    }
    $dose = intval($_POST['dose']);
    if ($dose <= 0){
      echo json_encode($data);
      die();
    }
    try{
      $date = new DateTime($_POST['date']);
      $now = new DateTime("now");
      if ($date < $now){
        echo json_encode($data);
        die();
      }
    }
    catch (Exception $e){
      echo json_encode($data);
      die();
    }
    require_once('.utils/dbcon.php');
    if ($con = DatabaseConn::get_conn()) {
      $data = $con->getAvailability($district, $type, $dose, $date);
    }
    echo json_encode($data);
  }
  die();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccineAvailability.php');
