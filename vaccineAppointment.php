<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['district']) && isset($_POST['date']) && isset($_POST['id']) && $_POST['district'] && $_POST['date'] && $_POST['id']) {
        $district = $_POST['district'];
        $date = new DateTime($_POST['date']);
        $id = $_POST['id'];
        require_once('.utils/dbcon.php');
        if (isset($_POST['vaccineCenter']) && isset($_POST['vaccineType']) && $_POST['vaccineCenter'] && $_POST['vaccineType']) {
            if ($con = DatabaseConn::get_conn()) {
                $place = $_POST['vaccineCenter'];
                $type = $_POST['vaccineType'];
                $name = isset($_POST['name']) ? $_POST['name'] : '';
                $email = isset($_POST['email']) ? $_POST['email'] : '';
                $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
                $details = ['id' => $id, 'name' => $name, 'contact' => $contact, 'email' => $email, 'district' => $district, 'place' => $place, 'date' => $date, 'type' => $type];
                if ($con->add_appointment($details)) {
                    $data = ['status' => true];
                } else {
                    $data = ['status' => false];
                }
            } else {
                $data = ['status' => false];
            }
        } else {
            if ($con = DatabaseConn::get_conn()) {
                $data = $con->filter_vaccine_centers($district, $date, $id);
            } else {
                $data = [];
            }
        }
        echo json_encode($data);
    }
    die();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/views/vaccineAppointment.php');
