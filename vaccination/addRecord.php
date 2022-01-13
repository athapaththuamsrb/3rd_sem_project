<?php
require_once '.auth.php';
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = $_SESSION['user'];
  if (isset($_POST['id']) && $_POST['id']) {
    $data = [];
    $id = $_POST['id'];
    if (isset($_POST['name']) && isset($_POST['type']) && isset($_POST['district']) && $_POST['name'] && $_POST['type'] && $_POST['district']) {
      $name = $_POST['name'];
      $type = $_POST['type'];
      $district = $_POST['district'];
      $address = isset($_POST['address']) ? $_POST['address'] : '';
      $email = isset($_POST['email']) ? $_POST['email'] : '';
      $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
      $data = $user->addRecord($id, $type, $name, $district, $address, $email, $contact);
    } else {
      $data = $user->getPatientDetails($id);
    }
  } else {
    $data['reason'] = 'Insufficient information';
  }
  echo json_encode($data);
  die();
}

@include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccination/addRecord.php');
