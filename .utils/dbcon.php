<?php

class DatabaseConn
{
  private static $dbconn;
  private $conn;

  private function __construct($servername, $username, $password, $database)
  {
    $this->conn = new mysqli($servername, $username, $password, $database);
    // mysqli_report(MYSQLI_REPORT_ALL);
  }

  public static function get_conn()
  {
    if (DatabaseConn::$dbconn == null) {
      $dbconfig = parse_ini_file('.env');
      $servername = $dbconfig['DB_HOST'];
      $username = $dbconfig['DB_USERNAME'];
      $password = $dbconfig['DB_PASSWORD'];
      $database = $dbconfig['DB_DATABASE'];
      DatabaseConn::$dbconn = new DatabaseConn($servername, $username, $password, $database);
    }
    return DatabaseConn::$dbconn;
  }

  public function auth($uname, $pw, $type)
  {
    if ($this->validate($uname, $pw)) {
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $q = 'SELECT password, place, district, email FROM admins WHERE username=? AND type=?';
      $arr = array();
      try {
        $stmt = $this->conn->prepare($q);
        $stmt->bind_param('ss', $uname, $type);
        $stmt->execute();
        $stmt->store_result();
        $rowcount = $stmt->num_rows;
        if ($rowcount == 1) {
          $stmt->bind_result($password, $place, $district, $email);
          $stmt->fetch();
          if (password_verify($pw, $password)) {
            $arr['email'] = $email;
            if ($type !== 'admin') {
              $arr['place'] = $place;
              $arr['district'] = $district;
            } else {
              $arr['place'] = '';
              $arr['district'] = '';
            }
            return $arr;
          }
        }
      } catch (Exception $e) {
        return $arr;
      }
    }
    return null;
  }

  public function create_user($uname, $pw, $type, $place, $district, $email)
  {
    if ($type !== 'admin' && (!$place || !$district)) {
      return false;
    }
    if ($this->validate($uname, $pw)) {
      $hashed = password_hash($pw, PASSWORD_BCRYPT, ['cost' => 12]);
      $q = 'INSERT INTO admins (username, password, type, place, district, email) VALUES (?, ?, ?, ?, ?, ?)';
      try {
        $stmt = $this->conn->prepare($q);
        $stmt->bind_param('ssssss', $uname, $hashed, $type, $place, $district, $email);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
      } catch (Exception $e) {
        return false;
      }
    }
    return false;
  }

  private function get_last_dose($id)
  {
    try {
      $q0 = 'SELECT last_dose FROM persons WHERE id=?';
      $stmt = $this->conn->prepare($q0);
      $stmt->bind_param('s', $id);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows() == 0) {
        $dose = 0;
      } else {
        $stmt->bind_result($dose);
        $stmt->fetch();
      }
      return intval($dose);
    } catch (Exception $e) {
      return 0;
    }
  }

  public function get_vaccination_records($id, $token)
  {
    try {
      if ($token == null) {
        $q0 = 'SELECT name, district, address, contact, email FROM persons WHERE id=?';
        $stmt = $this->conn->prepare($q0);
        $stmt->bind_param('s', $id);
      } else {
        $q0 = 'SELECT name, district, address, contact, email FROM persons WHERE id=? and token=?';
        $stmt = $this->conn->prepare($q0);
        $stmt->bind_param('ss', $id, $token);
      }
      $stmt->execute();
      $stmt->store_result();
      $arr = array();
      if ($stmt->num_rows() == 0) {
        return ['doses' => []];
      }
      $stmt->bind_result($name, $district, $address, $contact, $email);
      $stmt->fetch();
      $arr['name'] = $name;
      $arr['district'] = $district;
      $arr['id'] = $id;
      $arr['address'] = $address;
      $arr['contact'] = $contact;
      $arr['email'] = $email;
      $arr['doses'] = array();
      $q = 'SELECT * FROM vaccines WHERE id=? ORDER BY dose';
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param('s', $id);
      $stmt->execute();
      $result = $stmt->get_result();
      while ($row = $result->fetch_assoc()) {
        $details = array('type' => $row['type'], 'date' => $row['date'], 'place' => $row['place'], 'district' => $row['district']);
        array_push($arr['doses'], $details);
      }
      return $arr;
    } catch (Exception $e) {
      return null;
    }
  }

  public function add_vaccine_record($details)
  {
    try {
      $reserved = true;
      $id = $details['id'];
      $name = $details['name'];
      $patient_district = $details['patient_district'];
      $centre_district = $details['centre_district'];
      $type = $details['type'];
      $place = $details['place'];
      $address = $details['address'];
      $contact = $details['contact'];
      $email = $details['email'];
      $date = date('Y-m-d');
      $Q = 'SELECT * FROM appointments WHERE id=? AND date=? AND type=? AND district=? AND place=?';
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $Stmt = $this->conn->prepare($Q);
      $Stmt->bind_param('sssss', $id, $date, $type, $centre_district, $place);
      $Stmt->execute();
      $Result = $Stmt->get_result();
      if ($Result->num_rows == 0) {
        $reserved = false;
      }
      $q0 = 'SELECT token, last_dose FROM persons WHERE id=?';
      $stmt = $this->conn->prepare($q0);
      $stmt->bind_param('s', $id);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows() == 0) {
        for ($i = 0; $i < 5; $i++) {
          $token = base_convert(rand(1, (int)pow(2, 30) - 1), 10, 32);
          $q = 'INSERT INTO persons (id, name, district, address, contact, email, token, last_dose) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
          $stmt = $this->conn->prepare($q);
          $new_dose = 1;
          $stmt->bind_param('sssssssi', $id, $name, $patient_district, $address, $contact, $email, $token, $new_dose);
          $success = $stmt->execute();
          if ($success) {
            break;
          }
        }
      } else {
        $stmt->bind_result($token, $last_dose);
        $stmt->fetch();
        $new_dose = $last_dose + 1;
        $q1 = 'UPDATE persons SET last_dose=?  WHERE id=?';
        $stmt1 = $this->conn->prepare($q1);
        $stmt1->bind_param('is', $new_dose, $id);
        $stmt1->execute();
      }
      if ($reserved) {
        $this->update_stocks($centre_district, $place, $date, $type, 'reserved', -1, $new_dose);
      } else {
        $this->update_stocks($centre_district, $place, $date, $type, 'not_reserved', -1, $new_dose);
      }
      $q2 = 'INSERT INTO vaccines (type, dose, date, district, place, id) VALUES (?, ?, ?, ?, ?, ?)';
      $stmt2 = $this->conn->prepare($q2);
      $stmt2->bind_param('sissss', $type, $new_dose, $date, $centre_district, $place, $id);
      $stmt2->execute();
      return $token;
    } catch (Exception $e) {
      return false;
    }
  }

  public function add_test_record($details)
  {
    try {
      $name = $details['name'];
      $id = $details['id'];
      $address = $details['address'];
      $contact = $details['contact'];
      $email = $details['email'];
      $test = $details['test'];
      $result = $details['result'];
      $place = $details['place'];
      $date = $details['date'];
      $q0 = 'SELECT id FROM persons WHERE id=?';
      $stmt0 = $this->conn->prepare($q0);
      $stmt0->bind_param('s', $id);
      $stmt0->execute();
      $stmt0->store_result();
      if ($stmt0->num_rows() == 0) {
        $q1 = 'INSERT INTO persons (id, name, district, address, contact, email) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt1 = $this->conn->prepare($q1);
        $stmt1->bind_param('ssssss', $id, $name, $district, $address, $contact, $email);
        $stmt1->execute();
      }
      for ($i = 0; $i < 5; $i++) {
        $token = rand(1, (int)pow(2, 64) - 1);
        $token = base_convert($token, 10, 32);
        $q2 = 'INSERT INTO testing (id, token, test, result, place, date) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt2 = $this->conn->prepare($q2);
        $stmt2->bind_param('ssssss', $id, $token, $test, $result, $place, $date);
        $success = $stmt2->execute();
        if ($success) {
          return $token;
        }
      }
    } catch (Exception $e) {
      return false;
    }
  }

  public function add_stock($district, $place, $date, $type, $dose, $not_reserved, $reserved)
  {
    try {
      $datestr = $date->format('Y-m-d');
      $q = 'INSERT INTO stocks (district, place, date, type, dose, not_reserved, reserved, appointments) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param('ssssiiii', $district, $place, $datestr, $type, $dose, $not_reserved, $reserved, $reserved);
      $success = $stmt->execute();
      return $success;
    } catch (Exception $e) {
      return false;
    }
  }

  public function update_stocks($district, $place, $date, $type, $field, $amount, $dose)
  {
    try {
      if ($date instanceof DateTime) {
        $date = $date->format('Y-m-d');
      }
      if ($field === 'reserved') {
        $q = "UPDATE stocks SET reserved = reserved + $amount WHERE district = ? AND place = ? AND date = ? and type = ? and dose = ?";
      } else if ($field === 'not_reserved') {
        $q = "UPDATE stocks SET not_reserved = not_reserved + $amount WHERE district = ? AND place = ? AND date = ? and type = ? and dose = ?";
      } else {
        $q = "UPDATE stocks SET appointments = appointments + $amount WHERE district = ? AND place = ? AND date = ? and type = ? and dose = ?";
      }
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param('ssssi', $district, $place, $date, $type, $dose);
      $success = $stmt->execute();
      if (!$success) return false;
      return ($stmt->affected_rows > 0);
    } catch (Exception $e) {
      return false;
    }
  }

  public function filter_vaccine_centers($district, $date, $id)
  {
    try {
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $date = $date->format('Y-m-d');
      $dose = $this->get_last_dose($id) + 1;
      $q0 = "SELECT place FROM admins WHERE district=? AND type='vaccination'";
      $stmt0 = $this->conn->prepare($q0);
      $stmt0->bind_param('s', $district);
      $stmt0->execute();
      $result0 = $stmt0->get_result();
      $arr = array();
      while ($row = $result0->fetch_assoc()) {
        $record = array();
        $place = $row['place'];
        $record['place'] = $place;
        $q1 = 'SELECT type, not_reserved, appointments FROM stocks WHERE district=? AND place=? AND date=? AND dose=?';
        $stmt1 = $this->conn->prepare($q1);
        $stmt1->bind_param('sssi', $district, $place, $date, $dose);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        while ($center = $result1->fetch_assoc()) {
          $type = $center['type'];
          $not_reserved = $center['not_reserved'];
          $appointments = $center['appointments'];
          $availability = array('not_reserved' => $not_reserved, 'appointments' => $appointments);
          $record[$type] = $availability;
        }
        if (count($record) > 1) {
          array_push($arr, $record);
        }
      }
      return $arr;
    } catch (Exception $e) {
      return [];
    }
  }

  public function getAvailability($district, $type, $dose, $date)
  {
    try {
      $date = $date->format('Y-m-d');
      $q0 = "SELECT place, reserved, not_reserved FROM stocks WHERE district=? AND type=? AND dose=? AND date=?";
      $stmt0 = $this->conn->prepare($q0);
      $stmt0->bind_param('ssis', $district, $type, $dose, $date);
      $stmt0->execute();
      $result0 = $stmt0->get_result();
      $arr = array();
      while ($row = $result0->fetch_assoc()) {
        $place = $row['place']; $reserved = $row['reserved']; $not_reserved = $row['not_reserved'];
        array_push($arr, array('place'=>$place, 'booking'=>$reserved, 'not_booking'=>$not_reserved));
      }
      // filter stocks by given data
      // return [] if error or not found
      // UI is implemented. test with http://localhost:8888/vaccineAvailability.php
      // sample output
      //return [['place' => 'General hosp.', 'booking' => 85, 'not_booking' => 23], ['place' => 'MOH office', 'booking' => 46, 'not_booking' => 41]];
      return $arr;
    } catch (Exception $e) {
      return [];
    }
  }

  public function add_appointment($details)
  {
    try {
      mysqli_report(MYSQLI_REPORT_ALL);
      $id = $details['id'];
      $name = $details['name'];
      $contact = $details['contact'];
      $email = $details['email'];
      $district = $details['district'];
      $place = $details['place'];
      $date = $details['date']->format('Y-m-d');
      $type = $details['type'];
      $dose = $this->get_last_dose($id) + 1;
      $q0 = 'SELECT appointments FROM stocks WHERE district = ? AND place = ? AND date = ? AND type = ? AND dose = ? AND appointments > 0';
      $stmt0 = $this->conn->prepare($q0);
      $stmt0->bind_param('ssssi', $district, $place, $date, $type, $dose);
      $stmt0->execute();
      $result = $stmt0->get_result();
      if ($result->num_rows == 0) {
        return false;
      }
      $q = 'INSERT INTO appointments (id, name, contact, email, district, place, date, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param('ssssssss', $id, $name, $contact, $email, $district, $place, $date, $type);
      $stmt->execute();
      return $this->update_stocks($district, $place, $date, $type, 'appointment', -1, $dose);
    } catch (Exception $e) {
      return false;
    }
  }

  public function getVaccineCentresInDistrict($district, $type)
  {
    $arr = array();
    $date = date('Y-m-d');
    try {
      require_once('accounts.php');
      $q0 = 'SELECT place FROM stocks WHERE district = ? AND type = ? AND date = ?';
      $stmt0 = $this->conn->prepare($q0);
      $stmt0->bind_param('sss', $district, $type, $date);
      $stmt0->execute();
      $result = $stmt0->get_result();
      if ($result->num_rows == 0) {
        return $arr;
      }
      $places = array();
      while ($row = $result->fetch_assoc()) {
        $place = $row['place'];
        if (!isset($places["$place"])) {
          $places["$place"] = $place;
          $q1 = 'SELECT email FROM admins WHERE district = ? AND place = ?';
          $stmt1 = $this->conn->prepare($q1);
          $stmt1->bind_param('ss', $district, $place);
          $stmt1->execute();
          $stmt1->store_result();
          $stmt1->bind_result($email);
          $stmt1->fetch();
          $vadmin = new VaccinationAdmin($place, $district, $email);
          array_push($arr, $vadmin);
        }
      }
      return $arr;
    } catch (Exception $e) {
      return $arr;
    }
  }

  public function getEmailByPlace($district, $place, $type)
  {
    try {
      $q0 = 'SELECT email FROM admins WHERE district = ? AND place = ? AND type = ?';
      $stmt0 = $this->conn->prepare($q0);
      $stmt0->bind_param('sss', $district, $place, $type);
      $stmt0->execute();
      $stmt0->store_result();
      $rowcount = $stmt0->num_rows;
      if ($rowcount == 1) {
        $stmt0->bind_result($email);
        $stmt0->fetch();
        return $email;
      }
      return null;
    } catch (Exception $e) {
      return null;
    }
  }

  public function getAppointmentsByDate($date){
    try{
      $arr = array();
      $date = $date->format('Y-m-d');
      $q = 'SELECT * FROM appointments WHERE date = ?';
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param('s', $date);
      $stmt->execute();
      $result = $stmt->get_result();
      while ($row = $result->fetch_assoc()) {
        $details = array('email' => $row['email'], 'id' => $row['id'], 'name' => $row['name'], 'type' => $row['type'], 'place' => $row['place'], 'district' => $row['district']);
        array_push($arr, $details);
      }
      return $arr;
    }catch (Exception $e) {
      return [];
    }
  }

  public function close_conn()
  {
    if (DatabaseConn::$dbconn != null) {
      $this->conn->close();
    }
    $this->__destruct();
  }

  private function validate($uname, $pw)
  {
    $uname = htmlspecialchars($uname);
    $pw = htmlspecialchars($pw);
    $uname_pattern = '/^[a-zA-Z0-9_]{5,20}$/';
    $pw_pattern = '/^\S{8,15}$/';
    //$pw_pattern = '/^\S*(?=\S{8,15})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/';
    if (preg_match($uname_pattern, $uname) && preg_match($pw_pattern, $pw)) {
      return true;
    }
    return false;
  }

  public function __destruct()
  {
  }
}
