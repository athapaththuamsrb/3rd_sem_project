<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [];
    if (isset($_POST['district']) && isset($_POST['date']) && isset($_POST['id']) && $_POST['district'] && $_POST['date'] && $_POST['id']) {
        try {
            $date = new DateTime($_POST['date']);
            $now = new DateTime("now");
            if ($date < $now) {
                echo json_encode($data);
                die();
            }
        } catch (Exception $e) {
            echo json_encode($data);
            die();
        }
        $id = $_POST['id'];
        if (strlen($id) < 4 || strlen($id) > 12) {
            echo json_encode($data);
            die();
        }
        $district = $_POST['district'];
        require_once('.utils/dbcon.php');
        if (isset($_POST['testingCenter']) && isset($_POST['testType']) && $_POST['testingCenter'] && $_POST['testType']) {
            if ($con = DatabaseConn::get_conn()) {
                $place = $_POST['testingCenter'];
                $type = $_POST['testType'];
                if ($type != "PCR" && $type != "Rapid Antigen" && $type != "Antibody") {
                    $data = ['status' => false];
                    echo json_encode($data);
                    die();
                }
                $name = isset($_POST['name']) ? $_POST['name'] : '';
                $name_pattern = '/^[a-zA-Z. ]+$/';
                $email = isset($_POST['email']) ? $_POST['email'] : '';
                $email_pattern = "/^[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,4}$/";
                
                $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
                $contact_pattern = '/^[0-9]{10}+$/';
                
                if (!preg_match($name_pattern, $name) || ($email && !preg_match($email_pattern, $email)) || ($contact && !preg_match($contact_pattern, $contact))) {
                    echo json_encode($data);
                    die();
                }
                $details = ['id' => $id, 'name' => $name, 'contact' => $contact, 'email' => $email, 'district' => $district, 'place' => $place, 'date' => $date, 'type' => $type];
                if ($con->add_testing_appointment($details)) {
                    $data = ['status' => true];
                } else {
                    $data = ['status' => false];
                }
            } else {
                $data = ['status' => false];
            }
        } else {
            if ($con = DatabaseConn::get_conn()) {
                $data = $con->filter_testing_centers($district, $date);
            }
            if (!$data){
                $data = [];
            }
        }
        echo json_encode($data);
    }
    die();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/views/testingAppointment.php');
