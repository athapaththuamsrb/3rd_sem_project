<?php
require_once('dbcon.php');

abstract class User
{
    private $type;
    private $email;

    protected function __construct($type, $email)
    {
        $this->type = $type;
        $this->email = $email;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getEmail()
    {
        return $this->email;
    }
}

abstract class CentreAdmin extends User
{
    private $place;
    private $district;

    protected function __construct($type, $place, $district, $email)
    {
        parent::__construct($type, $email);
        $this->place = $place;
        $this->district = $district;
    }

    public function getPlace()
    {
        return $this->place;
    }

    public function getDistrict()
    {
        return $this->district;
    }
}

class Administrator extends User
{
    public function __construct($email)
    {
        parent::__construct('admin', $email);
    }
}

class VaccinationAdmin extends CentreAdmin
{
    public function __construct($place, $district, $email)
    {
        parent::__construct('vaccination', $place, $district, $email);
    }

    public function addStock($type, $dose, $date, $amount, $online)
    {
        $data = ['success' => false];
        try {
            $district = $this->getDistrict();
            $place = $this->getPlace();
            $now = new DateTime("now");
            if ($date < $now) {
                $data['reason'] = 'Invalid date';
                return $data;
            }
            if ($type != "Pfizer" && $type != "Moderna" && $type != "Sinopharm" && $type != "Aztraseneca") {
                $data['reason'] = 'Invalid type';
                return $data;
            }
            if ($dose <= 0 || $amount <= 0 || $online <= 0 || $amount < $online) {
                $data['reason'] = 'Invalid amounts or dose';
                return $data;
            }
            $con = DatabaseConn::get_conn();
            if (!$con) {
                $data['reason'] = 'Server error';
                return $data;
            }
            if ($con->add_vaccine_stock($district, $place, $date, $type, $dose, $amount - $online, $online)) {
                $data['success'] = true;
            } else {
                $data['reason'] = 'Add stock failed';
            }
            return $data;
        } catch (Exception $e) {
            return $data;
        }
    }

    public function getPatientDetails($id)
    {
        $data = [];
        try {
            $con = DatabaseConn::get_conn();
            if (!$con) {
                $data['reason'] = 'Server error';
                return $data;
            }
            if (strlen($id) < 4 || strlen($id) > 12) {
                $data['reason'] = 'Invalid ID';
                return $data;
            }
            $data = $con->get_vaccination_records($id, null);
            if (!$data || !is_array($data)) {
                $data = ['id' => $id, 'doses' => []];
            } else {
                foreach ($data['doses'] as $key => $dose) {
                    unset($data['doses'][$key]['place']);
                    unset($data['doses'][$key]['district']);
                }
            }
            return $data;
        } catch (Exception $e) {
            return $data;
        }
    }

    public function addRecord($id, $type, $name, $district, $address, $email, $contact)
    {
        $data = [];
        try {
            $con = DatabaseConn::get_conn();
            if (!$con) {
                $data['reason'] = 'Server error';
                return $data;
            }
            if (strlen($id) < 4 || strlen($id) > 12) {
                $data['reason'] = 'Invalid ID';
                return $data;
            }
            $name_pattern = '/^[a-zA-Z. ]+$/';
            if (!preg_match($name_pattern, $name)) {
                $data['reason'] = 'Invalid name';
                return $data;
            }
            if ($type != "Pfizer" && $type != "Moderna" && $type != "Sinopharm" && $type != "Aztraseneca") {
                $data['reason'] = 'Invalid type';
                return $data;
            }
            $email_pattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
            $contact_pattern = '/^[0-9]{10}+$/';
            if (($contact && !preg_match($contact_pattern, $contact)) || ($email && !preg_match($email_pattern, $email))) {
                $data['reason'] = 'Invalid email or contact';
                return $data;
            }
            $vac_data = ['id' => $id, 'name' => $name, 'type' => $type, 'centre_district' => $this->getDistrict(), 'place' => $this->getPlace(), 'patient_district' => $district, 'address' => $address, 'contact' => $contact, 'email' => $email];
            $token = $con->add_vaccine_record($vac_data);
            return ['token' => $token];
        } catch (Exception $e) {
            return $data;
        }
    }

    public function updateStock($type, $dose, $amount)
    {
        $data = ['success' => false];
        try {
            $district = $this->getDistrict();
            $place = $this->getPlace();
            $date = new DateTime();
            if ($type != "Pfizer" && $type != "Moderna" && $type != "Sinopharm" && $type != "Aztraseneca") {
                $data['reason'] = 'Invalid type';
                return $data;
            }
            if ($dose <= 0 || $amount <= 0) {
                $data['reason'] = 'Invalid amounts or dose';
                return $data;
            }
            $con = DatabaseConn::get_conn();
            if (!$con) {
                $data['reason'] = 'Server error';
                return $data;
            }
            $data['success'] = $con->update_stocks($district, $place, $date, $type, 'not_reserved', $amount, $dose);
            return $data;
        } catch (Exception $e) {
            return $data;
        }
    }
}

class TestingAdmin extends CentreAdmin
{
    public function __construct($place, $district, $email)
    {
        parent::__construct('testing', $place, $district, $email);
    }

    public function addStock($type, $date, $amount, $online)
    {
        $data = ['success' => false];
        try {
            $district = $this->getDistrict();
            $place = $this->getPlace();
            $now = new DateTime("now");
            if ($date < $now) {
                $data['reason'] = 'Invalid date';
                return $data;
            }
            if ($type != "PCR" && $type != "Rapid Antigen" && $type != "Antibody") {
                $data['reason'] = 'Invalid type';
                return $data;
            }
            if ($amount <= 0 || $online <= 0 || $amount < $online) {
                $data['reason'] = 'Invalid amounts';
                return $data;
            }
            $con = DatabaseConn::get_conn();
            if (!$con) {
                $data['reason'] = 'Server error';
                return $data;
            }
            if ($con->add_testing_stock($district, $place, $date, $type, $amount - $online, $online)) {
                $data['success'] = true;
            } else {
                $data['reason'] = 'Add stock failed';
            }
            return $data;
        } catch (Exception $e) {
            return $data;
        }
    }

    public function getPatientDetails($id)
    {
        $data = [];
        try {
            $con = DatabaseConn::get_conn();
            if (!$con) {
                $data['reason'] = 'Server error';
                return $data;
            }
            if (strlen($id) < 4 || strlen($id) > 12) {
                $data['reason'] = 'Invalid ID';
                return $data;
            }
            $data = $con->get_patient_details($id, null);
            if (!$data || !is_array($data)) {
                $data = ['id' => $id];
            }
            return $data;
        } catch (Exception $e) {
            return $data;
        }
    }

    public function addRecord($id, $type, $name, $district, $address, $email, $contact)
    {
        $data = [];
        try {
            $con = DatabaseConn::get_conn();
            if (!$con) {
                $data['reason'] = 'Server error';
                return $data;
            }
            if (strlen($id) < 4 || strlen($id) > 12) {
                $data['reason'] = 'Invalid ID';
                return $data;
            }
            $name_pattern = '/^[a-zA-Z. ]+$/';
            if (!preg_match($name_pattern, $name)) {
                $data['reason'] = 'Invalid name';
                return $data;
            }
            if ($type != "PCR" && $type != "Rapid Antigen" && $type != "Antibody") {
                $data['reason'] = 'Invalid type';
                return $data;
            }
            $email_pattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
            $contact_pattern = '/^[0-9]{10}+$/';
            if (($contact && !preg_match($contact_pattern, $contact)) || ($email && !preg_match($email_pattern, $email))) {
                $data['reason'] = 'Invalid email or contact';
                return $data;
            }
            $vac_data = ['id' => $id, 'name' => $name, 'type' => $type, 'centre_district' => $this->getDistrict(), 'place' => $this->getPlace(), 'patient_district' => $district, 'address' => $address, 'contact' => $contact, 'email' => $email];
            $token = $con->add_testing_record($vac_data);
            return ['token' => $token];
        } catch (Exception $e) {
            return $data;
        }
    }
}
