<?php
require_once('dbcon.php');
require_once('global.php');

abstract class User
{
    /** @var \String */
    private $type;
    /** @var \String */
    private $email;

    protected function __construct($type, $email)
    {
        $this->type = $type;
        $this->email = $email;
    }

    public function getType(): String
    {
        return $this->type;
    }

    public function getEmail(): String
    {
        return $this->email;
    }
}

abstract class CentreAdmin extends User
{
    /** @var \String */
    private $place;
    /** @var \String */
    private $district;

    protected function __construct($type, $place, $district, $email)
    {
        parent::__construct($type, $email);
        $this->place = $place;
        $this->district = $district;
    }

    public function getPlace(): String
    {
        return $this->place;
    }

    public function getDistrict(): String
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

    public function createUserAccount($type, $email, $username, $password, $place, $district): Bool
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
        if (!in_array($district, DISTRICTS, true)) {
            return false;
        }
        require_once 'factory.php';
        $details = ['username' => $username, 'password' => $password, 'email' => $email, 'place' => $place, 'district' => $district];
        $accountSaver = AccountFactory::getAccount($type, $details);
        if ($accountSaver && $accountSaver instanceof IaccountSaver && $accountSaver->saveToDB()) {
            return true;
        }
        return false;
    }
}

class VaccinationAdmin extends CentreAdmin
{
    public function __construct($place, $district, $email)
    {
        parent::__construct('vaccination', $place, $district, $email);
    }

    public function addStock($type, $dose, $date, $amount, $online): array
    {
        $data = ['success' => false];
        try {
            $district = $this->getDistrict();
            $place = $this->getPlace();
            $now = new DateTime('today');
            if ($date <= $now) {
                $data['reason'] = 'Invalid date';
                return $data;
            }
            if (!in_array($type, VACCINES, true)) {
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

    public function getPatientDetails($id): array
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

    public function addRecord($id, $type, $name, $district, $address, $email, $contact): array
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
            if (!in_array($type, VACCINES, true)) {
                $data['reason'] = 'Invalid type';
                return $data;
            }
            if (!in_array($district, DISTRICTS, true)) {
                $data['reason'] = 'Invalid district';
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

    public function updateStock($type, $dose, $amount): array
    {
        $data = ['success' => false];
        try {
            $district = $this->getDistrict();
            $place = $this->getPlace();
            $date = new DateTime();
            if (!in_array($type, VACCINES, true)) {
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

    public function requestVaccines($type, $dose, $amount): array
    {
        try {
            $district = $this->getDistrict();
            if (!in_array($type, VACCINES, true)) {
                return ['count' => 0, 'resaon' => 'Invalid type'];
            }
            if ($dose <= 0 || $amount <= 0) {
                return ['count' => 0, 'resaon' => 'Invalid dose or amount'];
            }
            $con = DatabaseConn::get_conn();
            if (!$con) {
                return ['count' => 0, 'resaon' => 'Server error'];
            }
            $place = $this->getPlace();
            $success = $con->add_request_for_extra_vaccines($district, $place, new DateTime(), $type, $amount);
            if (!$success) {
                return ['count' => 0, 'resaon' => 'Failed to add request'];
            }
            require_once('mediator.php');
            $mediator = new Mediator($district, $type);
            $count = $mediator->sendEmails($this, $dose, $amount);
            return ['count' => $count];
        } catch (Exception $e) {
            return ['count' => 0, 'resaon' => 'Server error'];
        }
    }

    public function donateVaccines($type, $place, $amount, $dose): array
    {
        $data = ['success' => false, 'email' => false];
        try {
            if (!in_array($type, VACCINES, true)) {
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
                //$success = $con->update_stocks($this->getDistrict(), $this->getPlace(), new DateTime(), $type, 'not_reserved', -$amount, $dose);
                $success = $con->donate_vaccines($this->getDistrict(), $this->getPlace(), new DateTime(), $type, $dose, $amount, $place);
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

    public function addStock($type, $date, $amount, $online): array
    {
        $data = ['success' => false];
        try {
            $district = $this->getDistrict();
            $place = $this->getPlace();
            $now = new DateTime();
            if ($date <= $now) {
                $data['reason'] = 'Invalid date';
                return $data;
            }
            if (!in_array($type, TESTS, true)) {
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

    public function getPatientDetails($id): array
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

    public function addRecord($id, $type, $name, $district, $address, $email, $contact): array
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
            if (!in_array($type, TESTS, true)) {
                $data['reason'] = 'Invalid type';
                return $data;
            }
            if (!in_array($district, DISTRICTS, true)) {
                $data['reason'] = 'Invalid district';
                return $data;
            }
            $email_pattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
            $contact_pattern = '/^[0-9]{10}+$/';
            if (($contact && !preg_match($contact_pattern, $contact)) || ($email && !preg_match($email_pattern, $email))) {
                $data['reason'] = 'Invalid email or contact';
                return $data;
            }
            $vac_data = ['id' => $id, 'name' => $name, 'type' => $type, 'centre_district' => $this->getDistrict(), 'place' => $this->getPlace(), 'patient_district' => $district, 'address' => $address, 'contact' => $contact, 'email' => $email];
            $token = $con->add_test_record($vac_data);
            return ['token' => $token];
        } catch (Exception $e) {
            $data['reason'] = 'Server error';
            return $data;
        }
    }

    public function addResult($token, $result): array
    {
        $data = ['success' => false];
        try {
            $con = DatabaseConn::get_conn();
            if (!$con) {
                $data['reason'] = 'Server error';
                return $data;
            }
            if (strlen($token) != 6) {
                $data['reason'] = 'Invalid token';
                return $data;
            }
            if ($result !== 'Positive' && $result !== 'Negative') {
                $data['reason'] = 'Invalid result';
                return $data;
            }
            $data['success'] = $con->add_testing_results($token, $result);
        } catch (Exception $e) {
            $data['reason'] = 'Server error';
        }
        return $data;
    }
}
