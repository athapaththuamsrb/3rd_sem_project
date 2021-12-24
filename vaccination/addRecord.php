<?php
require_once '.auth.php';
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = $_SESSION['user'];
  if (isset($_POST['id']) && $_POST['id']) {
    $id = $_POST['id'];
    require_once '../.utils/dbcon.php';
    $con = DatabaseConn::get_conn();
    if (isset($_POST['name']) && isset($_POST['type']) && isset($_POST['district']) && $_POST['name'] && $_POST['type'] && $_POST['district']) {
      $name = $_POST['name'];
      $type = $_POST['type'];
      $district = $_POST['district'];
      $address = '';
      $contact = '';
      $email = '';
      if (isset($_POST['address']) && $_POST['address']) {
        $address = $_POST['address'];
      }
      if (isset($_POST['contact']) && $_POST['contact']) {
        $contact = $_POST['contact'];
      }
      if (isset($_POST['email']) && $_POST['email']) {
        $email = $_POST['email'];
      }
      $vac_data = ['id' => $id, 'name' => $name, 'type' => $type, 'centre_district' => $user->getDistrict(), 'place' => $user->getPlace(), 'patient_district' => $district, 'address' => $address, 'contact' => $contact, 'email' => $email];
      $token = $con->add_vaccine_record($vac_data);
      echo json_encode(['token' => $token]);
    } else {
      $data = $con->get_vaccination_records($id, null);
      if (!$data || !is_array($data)) {
        $data = ['id' => $id, 'doses' => []];
      }
      echo json_encode($data);
    }
  }
  die();
}

include_once($_SERVER['DOCUMENT_ROOT'].'/views/vaccination/addRecord.php');