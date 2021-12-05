<?php
require_once('.auth.php');
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = $_SESSION['user'];
  if (isset($_POST['date']) && isset($_POST['type']) && isset($_POST['dose']) && isset($_POST['amount']) && isset($_POST['onlineAmount']) && $_POST['date'] && $_POST['type'] && is_numeric($_POST['dose']) && is_numeric($_POST['amount']) && is_numeric($_POST['onlineAmount'])) {
    $user = $_SESSION['user'];
    $district = $user->getDistrict();
    $place = $user->getPlace();
    $date = new DateTime($_POST['date']);
    $type = $_POST['type'];
    $dose = intval($_POST['dose']);
    $amount = intval($_POST['amount']);
    $online = intval($_POST['onlineAmount']);
    require_once('../.utils/dbcon.php');
    $con = DatabaseConn::get_conn();
    $success = false;
    if ($dose > 0 && $amount > 0 && $online >= 0 && $amount >= $online) {
      if ($con->add_stock($district, $place, $date, $type, $dose, $amount - $online, $online)) {
        $success = true;
      }
    }
    echo json_encode(['success' => $success]);
  }
  die();
}

include_once('../.views/vaccination/addStock.php');