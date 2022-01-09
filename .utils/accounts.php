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

    public function createUserAccount($type, $email, $username, $password, $place, $district)
    {
        $uname_pattern = '/^[a-zA-Z0-9_]{5,20}$/';
        $pw_pattern = '/^\S{8,15}$/';
        $email_pattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
        if (!preg_match($uname_pattern, $username) || !preg_match($pw_pattern, $password) || !preg_match($email_pattern, $email)) {
            return false;
        }
        if ($type != "admin" && $type != "vaccination" && $type != "testing") {
            return false;
        }
        require_once 'factory.php';
        $details = ['username' => $username, 'password' => $password, 'email' => $email, 'place' => $place, 'district' => $district];
        $accountSaver = AccountFactory::getAccount($type, $details);
        if ($accountSaver && $accountSaver instanceof IaccountSaver && $accountSaver->saveToDB()) {
            sendSuccess(true);
        }
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

    public function requestVaccines($type, $dose, $amount)
    {
        try {
            $district = $this->getDistrict();
            if ($type != "Pfizer" && $type != "Moderna" && $type != "Sinopharm" && $type != "Aztraseneca") {
                return ['count' => 0, 'resaon' => 'Invalid type'];
            }
            if ($dose <= 0 || $amount <= 0) {
                return ['count' => 0, 'resaon' => 'Invalid dose or amount'];
            }
            require_once('mediator.php');
            $mediator = new Mediator($district, $type);
            $count = $mediator->sendEmails($this, $dose, $amount);
            return ['count' => $count];
        } catch (Exception $e) {
            return ['count' => 0, 'resaon' => 'Server error'];
        }
    }

    public function donateVaccines($type, $place, $amount, $dose)
    {
        $data = ['success' => false, 'email' => false];
        try {
            if ($type != "Pfizer" && $type != "Moderna" && $type != "Sinopharm" && $type != "Aztraseneca") {
                $data['reason'] = 'Invalid type';
                return $data;
            }
            if ($dose <= 0 || $amount <= 0) {
                $data['reason'] = 'Invalid dose or amount';
                return $data;
            }
            $success = false;
            $email_sent = false;
            if ($con = DatabaseConn::get_conn()) {
                $success = $con->update_stocks($this->getDistrict(), $this->getPlace(), new DateTime(), $type, 'not_reserved', -$amount, $dose);
                if ($success) {
                    $district = $this->getDistrict();
                    $donor_place = $this->getPlace();
                    $email = $con->getEmailByPlace($district, $place, 'vaccination');
                    if ($email) {
                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $msg = "<html><body><h3>We can donate $amount vaccines from $donor_place to $place </h3><p>type : $type <br>dose : $dose <br>amount : $amount </p><p>You can collect the vaccines from $donor_place</p><p>Once you collect the vaccies, you can update your stock from <a href=\"http://$_SERVER[HTTP_HOST]/vaccination/updateStock.php?type=$type&amount=$amount\">this link</a>.</p></body></html>";
                        $email_sent =  mail($email, "Donate vaccines", $msg, $headers);
                    }
                }
            }
            return ['success' => $success, 'email' => $email_sent];
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
