<?php
require_once('.auth.php');
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = $_SESSION['user'];
  $data = ['success' => false];
  if (isset($_POST['date']) && isset($_POST['type']) && isset($_POST['dose']) && isset($_POST['amount']) && isset($_POST['onlineAmount']) && $_POST['date'] && $_POST['type'] && is_numeric($_POST['dose']) && is_numeric($_POST['amount']) && is_numeric($_POST['onlineAmount'])) {
    $district = $user->getDistrict();
    $place = $user->getPlace();
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
    $type = $_POST['type'];
    if ($type != "Pfizer" && $type != "Moderna" && $type != "Sinopharm" && $type != "Aztraseneca"){
      echo json_encode($data);
      die();
    }
    $dose = intval($_POST['dose']);
    $amount = intval($_POST['amount']);
    if ($dose <= 0 || $amount <= 0){
      echo json_encode($data);
      die();
    }
    $online = intval($_POST['onlineAmount']);
    require_once('../.utils/dbcon.php');
    $con = DatabaseConn::get_conn();
    if ($dose > 0 && $amount > 0 && $online >= 0 && $amount >= $online) {
      if ($con->add_stock($district, $place, $date, $type, $dose, $amount - $online, $online)) {
        $data['success'] = true;
      }
    }
    echo json_encode($data);
  }
  die();
}

include_once($_SERVER['DOCUMENT_ROOT'].'/views/vaccination/addStock.php');