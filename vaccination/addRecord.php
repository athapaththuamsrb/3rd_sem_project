<?php
require_once '.auth.php';
check_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = $_SESSION['user'];
  if (isset($_POST['id']) && $_POST['id']) {
    $data = [];
    $id = $_POST['id'];
    if (strlen($id) < 4 || strlen($id) > 12){
      echo json_encode($data);
      die();
    }
    require_once '../.utils/dbcon.php';
    $con = DatabaseConn::get_conn();
    if (isset($_POST['name']) && isset($_POST['type']) && isset($_POST['district']) && $_POST['name'] && $_POST['type'] && $_POST['district']) {
      $name = $_POST['name'];
      $name_pattern = '/^[a-zA-Z. ]+$/';
      if (!preg_match($name_pattern, $name)){
        echo json_encode($data);
        die();
      }
      $type = $_POST['type'];
      if ($type != "Pfizer" && $type != "Moderna" && $type != "Sinopharm" && $type != "Aztraseneca"){
        echo json_encode($data);
        die();
      }
      $district = $_POST['district'];
      $address = '';
      $contact = '';
      $email = '';
      $address = isset($_POST['address']) ? $_POST['address'] : '';
      $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
      $email = isset($_POST['email']) ? $_POST['email'] : '';
      $contact_pattern = '/^[0-9]{10}+$/';
      $email_pattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
      if (($contact && !preg_match($contact_pattern, $contact)) || ($email && !preg_match($email_pattern, $email))){
        echo json_encode($data);
        die();
      }
      $vac_data = ['id' => $id, 'name' => $name, 'type' => $type, 'centre_district' => $user->getDistrict(), 'place' => $user->getPlace(), 'patient_district' => $district, 'address' => $address, 'contact' => $contact, 'email' => $email];
      $token = $con->add_vaccine_record($vac_data);
      echo json_encode(['token' => $token]);
    } else {
      $data = $con->get_vaccination_records($id, null);
      if (!$data || !is_array($data)) {
        $data = ['id' => $id, 'doses' => []];
      }else{
      foreach ($data['doses'] as $key => $dose) {
        unset($data['doses'][$key]['place']);
        unset($data['doses'][$key]['district']);
      }
      }
      echo json_encode($data);
    }
  }
  die();
}

include_once($_SERVER['DOCUMENT_ROOT'].'/views/vaccination/addRecord.php');