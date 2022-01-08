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
    try {
      if (DatabaseConn::$dbconn == null) {
        $dbconfig = parse_ini_file('.env');
        $servername = $dbconfig['DB_HOST'];
        $username = $dbconfig['DB_USERNAME'];
        $password = $dbconfig['DB_PASSWORD'];
        $database = $dbconfig['DB_DATABASE'];
        DatabaseConn::$dbconn = new DatabaseConn($servername, $username, $password, $database);
      }
      return DatabaseConn::$dbconn;
    } catch (Exception $e) {
      return null;
    }
  }

  public function auth($uname, $pw, $type)
  {
    if ($this->validate($uname, $pw)) {
      $arr = array();
      ($this->conn)->begin_transaction();
      try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $q = 'SELECT password, place, district, email FROM admins WHERE username=? AND type=?';
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
          }
        }
        $stmt->close();
        ($this->conn)->commit();
        return $arr;
      } catch (Exception $e) {
        ($this->conn)->rollback();
        return $arr;
      }
    }
    return null;
  }

  public function create_user($uname, $pw, $type, $place, $district, $email)
  {
    ($this->conn)->query("CREATE TABLE IF NOT EXISTS admins (
        username varchar(20) not null,
        password varchar(100) not null,
        type varchar(20) not null,
        place varchar(50),
        district varchar(20),
        email varchar(50) not null,
        primary key (username)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    if ($type !== 'admin' && (!$place || !$district)) {
      return false;
    }
    if ($this->validate($uname, $pw)) {
      $hashed = password_hash($pw, PASSWORD_BCRYPT, ['cost' => 12]);
      $q = 'INSERT INTO admins (username, password, type, place, district, email) VALUES (?, ?, ?, ?, ?, ?)';
      ($this->conn)->begin_transaction();
      try {
        $stmt = $this->conn->prepare($q);
        $stmt->bind_param('ssssss', $uname, $hashed, $type, $place, $district, $email);
        $success = $stmt->execute();
        $stmt->close();
        ($this->conn)->commit();
        return $success;
      } catch (Exception $e) {
        ($this->conn)->rollback();
        return false;
      }
    }
    return false;
  }

  private function get_last_dose($id)
  {
    ($this->conn)->begin_transaction();
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
      $stmt->close();
      ($this->conn)->commit();
      return intval($dose);
    } catch (Exception $e) {
      ($this->conn)->rollback();
      return -1; // was 0 before
    }
  }

  public function get_vaccination_records($id, $token)
  {
    ($this->conn)->begin_transaction();
    try {
      if ($token == null) {
        $q0 = 'SELECT name, district, address, contact, email FROM persons WHERE id =?';
        $stmt = $this->conn->prepare($q0);
        $stmt->bind_param('s', $id);
      } else {
        $q0 = 'SELECT name, district, address, contact, email FROM persons WHERE id =? and token=?';
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
      $stmt->close();
      $q = 'SELECT * FROM vaccines WHERE id=? ORDER BY dose';
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param('s', $id);
      $stmt->execute();
      $result = $stmt->get_result();
      while ($row = $result->fetch_assoc()) {
        $details = array('type' => $row['type'], 'date' => $row['date'], 'place' => $row['place'], 'district' => $row['district']);
        array_push($arr['doses'], $details);
      }
      $stmt->close();
      ($this->conn)->commit();
      return $arr;
    } catch (Exception $e) {
      ($this->conn)->rollback();
      return null;
    }
  }

  public function add_vaccine_record($details)
  {
    ($this->conn)->query("CREATE TABLE IF NOT EXISTS persons (
        id varchar(20) not null, 
        name varchar(100) not null, 
        district varchar(20) not null, 
        address varchar(100),
        contact varchar(15),
        email varchar(50),
        token varchar(50) not null, 
        last_dose int not null, 
        primary key (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    ($this->conn)->query("CREATE TABLE IF NOT EXISTS vaccines (
        vaccine_id int NOT NULL AUTO_INCREMENT,
        type varchar(20) NOT NULL,
        dose int not null,
        date varchar(15) not null,
        district varchar(25) not null,
        place varchar(50) not null,
        id varchar(20) not null,
        PRIMARY KEY (vaccine_id),
        foreign key (id) references persons (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    ($this->conn)->begin_transaction();
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
      $last_dose = $this->get_last_dose($id);
      if ($last_dose < 0) {
        return false;
      }
      $new_dose = $last_dose + 1;
      if ($reserved) {
        $res = $this->update_stocks($centre_district, $place, $date, $type, 'reserved', -1, $new_dose);
        if (!$res) {
          return false;
        }
      } else {
        $res = $this->update_stocks($centre_district, $place, $date, $type, 'not_reserved', -1, $new_dose);
        if (!$res) {
          return false;
        }
      }
      $Stmt->close();
      $q0 = 'SELECT token, last_dose FROM persons WHERE id=?';
      $stmt = $this->conn->prepare($q0);
      $stmt->bind_param('s', $id);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows() == 0) {
        for ($i = 0; $i < 5; $i++) {
          $token = base_convert(rand(1, 0x7fffffff), 10, 36);
          $token = str_pad($token, 6, '0', STR_PAD_LEFT);
          $q = 'INSERT INTO persons (id, name, district, address, contact, email, token, last_dose) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
          $stmt1 = $this->conn->prepare($q);
          $new_dose = 1;
          $stmt1->bind_param('sssssssi', $id, $name, $patient_district, $address, $contact, $email, $token, $new_dose);
          $success = $stmt1->execute();
          $stmt1->close();
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
        $stmt1->close();
      }
      $stmt->close();
      $q2 = 'INSERT INTO vaccines (type, dose, date, district, place, id) VALUES (?, ?, ?, ?, ?, ?)';
      $stmt2 = $this->conn->prepare($q2);
      $stmt2->bind_param('sissss', $type, $new_dose, $date, $centre_district, $place, $id);
      $stmt2->execute();
      $stmt2->close();
      ($this->conn)->commit();
      return $token;
    } catch (Exception $e) {
      ($this->conn)->rollback();
      return false;
    }
  }

  public function add_stock($district, $place, $date, $type, $dose, $not_reserved, $reserved)
  {
    ($this->conn)->query("CREATE TABLE IF NOT EXISTS stocks (
        district varchar(20) not null,
        place varchar(50) not null,
        date varchar(15) not null,
        type varchar(20) not null,
        dose int not null,
        reserved int not null,
        not_reserved int not null,
        appointments int not null,
        primary key (district, place, date, type, dose)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    ($this->conn)->begin_transaction();
    try {
      $datestr = $date->format('Y-m-d');
      $q = 'INSERT INTO stocks (district, place, date, type, dose, not_reserved, reserved, appointments) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param('ssssiiii', $district, $place, $datestr, $type, $dose, $not_reserved, $reserved, $reserved);
      $success = $stmt->execute();
      $stmt->close();
      ($this->conn)->commit();
      return $success;
    } catch (Exception $e) {
      ($this->conn)->rollback();
      return false;
    }
  }

  public function update_stocks($district, $place, $date, $type, $field, $amount, $dose)
  {
    ($this->conn)->begin_transaction();
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
      $num = $stmt->affected_rows;
      $stmt->close();
      ($this->conn)->commit();
      if (!$success) return false;
      return ($num > 0);
    } catch (Exception $e) {
      ($this->conn)->rollback();
      return false;
    }
  }

  public function filter_vaccine_centers($district, $date, $id)
  {
    ($this->conn)->begin_transaction();
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
        $stmt1->close();
      }
      $stmt0->close();
      ($this->conn)->commit();
      return $arr;
    } catch (Exception $e) {
      ($this->conn)->rollback();
      return [];
    }
  }

  public function getAvailability($district, $type, $dose, $date)
  {
    ($this->conn)->begin_transaction();
    try {
      $date = $date->format('Y-m-d');
      $q0 = "SELECT place, reserved, not_reserved FROM stocks WHERE district=? AND type=? AND dose=? AND date=?";
      $stmt0 = $this->conn->prepare($q0);
      $stmt0->bind_param('ssis', $district, $type, $dose, $date);
      $stmt0->execute();
      $result0 = $stmt0->get_result();
      $arr = array();
      while ($row = $result0->fetch_assoc()) {
        $place = $row['place'];
        $reserved = $row['reserved'];
        $not_reserved = $row['not_reserved'];
        array_push($arr, array('place' => $place, 'booking' => $reserved, 'not_booking' => $not_reserved));
      }
      $stmt0->close();
      ($this->conn)->commit();
      return $arr;
    } catch (Exception $e) {
      ($this->conn)->rollback();
      return [];
    }
  }

  public function add_appointment($details)
  {
    ($this->conn)->query("CREATE TABLE IF NOT EXISTS appointments (
      id varchar(20) not null,
      name varchar(100) not null,
      contact varchar(15),
      email varchar(50),
      district varchar(20) not null,
      place varchar(50) not null,
      date varchar(15) not null,
      type varchar(20) not null,
      primary key (id, date)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    ($this->conn)->begin_transaction();
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
      $stmt0->close();
      $q = 'INSERT INTO appointments (id, name, contact, email, district, place, date, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param('ssssssss', $id, $name, $contact, $email, $district, $place, $date, $type);
      $stmt->execute();
      $stmt->close();
      ($this->conn)->commit();
      return $this->update_stocks($district, $place, $date, $type, 'appointment', -1, $dose);
    } catch (Exception $e) {
      ($this->conn)->rollback();
      return false;
    }
  }

  public function getVaccineCentresInDistrict($district, $type)
  {
    $arr = array();
    $date = date('Y-m-d');
    ($this->conn)->begin_transaction();
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
      $stmt0->close();
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
          $stmt1->close();
        }
      }
      ($this->conn)->commit();
      return $arr;
    } catch (Exception $e) {
      ($this->conn)->rollback();
      return $arr;
    }
  }

  public function getEmailByPlace($district, $place, $type)
  {
    ($this->conn)->begin_transaction();
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
        $stmt0->close();
        return $email;
      }
      $stmt0->close();
      ($this->conn)->commit();
      return null;
    } catch (Exception $e) {
      ($this->conn)->rollback();
      return null;
    }
  }

  public function getAppointmentsByDate($date)
  {
    ($this->conn)->begin_transaction();
    try {
      $arr = array();
      if ($date instanceof DateTime) {
        $date = $date->format('Y-m-d');
      }
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
      $stmt->close();
      ($this->conn)->commit();
      return $arr;
    } catch (Exception $e) {
      ($this->conn)->rollback();
      return [];
    }
  }

  public function removeAppointments($type, $date)
  {
    ($this->conn)->begin_transaction();
    try {
      if ($date instanceof DateTime) {
        $date = $date->format('Y-m-d');
      }
      switch ($type) {
        case 'vaccination':
          $q = 'update stocks set not_reserved = not_reserved + appointments, appointments=0 where date=?'; // TODO : rename table to vaccine_stocks
          break;

        case 'testing':
          $q = 'update testing_stocks set not_reserved = not_reserved + appointments, appointments=0 where date=?'; // TODO : create table
          break;

        default:
          return false;
          break;
      }
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param('s', $date);
      $success = $stmt->execute();
      $stmt->close();
      ($this->conn)->commit();
      return $success;
    } catch (Exception $e) {
      ($this->conn)->rollback();
      return false;
    }
  }

  public function add_test_record($details)
  {
    ($this->conn)->query("CREATE TABLE IF NOT EXISTS persons (
      id varchar(20) not null, 
      name varchar(100) not null, 
      district varchar(20) not null, 
      address varchar(100),
      contact varchar(15),
      email varchar(50),
      token varchar(50) not null, 
      last_dose int not null, 
      primary key (id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    ($this->conn)->query("CREATE TABLE IF NOT EXISTS tests (
      test_id int NOT NULL AUTO_INCREMENT,
      type varchar(20) NOT NULL,
      date varchar(15) not null,
      district varchar(25) not null,
      place varchar(50) not null,
      id varchar(20) not null,
      PRIMARY KEY (test_id),
      foreign key (id) references persons (id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    ($this->conn)->begin_transaction();
    try {
      $name = $details['name'];
      $id = $details['id'];
      $address = $details['address'];
      $contact = $details['contact'];
      $email = $details['email'];
      $type = $details['test'];
      $result = $details['result'];
      $place = $details['place'];
      $date = date('Y-m-d');
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
        $stmt1->close();
      }
      $stmt0->close();
      for ($i = 0; $i < 5; $i++) {
        $token = rand(1, (int)pow(2, 64) - 1);
        $token = base_convert($token, 10, 32);
        $q2 = 'INSERT INTO tests (id, token, type, result, place, date) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt2 = $this->conn->prepare($q2);
        $stmt2->bind_param('ssssss', $id, $token, $type, $result, $place, $date);
        $success = $stmt2->execute();
        $stmt2->close();
        if ($success) {
          ($this->conn)->commit();
          return $token;
        }
      }
      ($this->conn)->commit();
    } catch (Exception $e) {
      ($this->conn)->rollback();
      return false;
    }
  }

  public function add_testing_appointment($details)
  {
    ($this->conn)->query("CREATE TABLE IF NOT EXISTS testing_appointments (
      id varchar(20) not null,
      name varchar(100) not null,
      contact varchar(15),
      email varchar(50),
      district varchar(20) not null,
      place varchar(50) not null,
      date varchar(15) not null,
      type varchar(20) not null,
      primary key (id, date)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    ($this->conn)->begin_transaction();
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
      $q0 = 'SELECT appointments FROM testing_stocks WHERE district = ? AND place = ? AND date = ? AND type = ? AND appointments > 0';
      $stmt0 = $this->conn->prepare($q0);
      $stmt0->bind_param('ssss', $district, $place, $date, $type);
      $stmt0->execute();
      $result = $stmt0->get_result();
      if ($result->num_rows == 0) {
        return false;
      }
      $stmt0->close();
      $q = 'INSERT INTO testing_appointments (id, name, contact, email, district, place, date, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param('ssssssss', $id, $name, $contact, $email, $district, $place, $date, $type);
      $success = $stmt->execute();
      $stmt->close();
      ($this->conn)->commit();
      return $success;
    } catch (Exception $e) {
      ($this->conn)->rollback();
      return false;
    }
  }

  public function add_testing_stock($district, $place, $date, $type, $dose, $not_reserved, $reserved)
  {
    ($this->conn)->query("CREATE TABLE IF NOT EXISTS testing_stocks (
        district varchar(20) not null,
        place varchar(50) not null,
        date varchar(15) not null,
        type varchar(20) not null,
        reserved int not null,
        not_reserved int not null,
        appointments int not null,
        primary key (district, place, date, type)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    ($this->conn)->begin_transaction();
    try {
      $datestr = $date->format('Y-m-d');
      $q = 'INSERT INTO testing_stocks (district, place, date, type, not_reserved, reserved, appointments) VALUES (?, ?, ?, ?, ?, ?, ?)';
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param('ssssiii', $district, $place, $datestr, $type, $not_reserved, $reserved, $reserved);
      $success = $stmt->execute();
      $stmt->close();
      ($this->conn)->commit();
      return $success;
    } catch (Exception $e) {
      ($this->conn)->rollback();
      return false;
    }
  }

  public function get_testing_availability($district, $type, $date)
  {
    ($this->conn)->begin_transaction();
    try {
      $date = $date->format('Y-m-d');
      $q0 = "SELECT place, reserved, not_reserved FROM stocks WHERE district=? AND type=? AND date=?";
      $stmt0 = $this->conn->prepare($q0);
      $stmt0->bind_param('ssis', $district, $type, $date);
      $stmt0->execute();
      $result0 = $stmt0->get_result();
      $arr = array();
      while ($row = $result0->fetch_assoc()) {
        $place = $row['place'];
        $reserved = $row['reserved'];
        $not_reserved = $row['not_reserved'];
        array_push($arr, array('place' => $place, 'booking' => $reserved, 'not_booking' => $not_reserved));
      }
      $stmt0->close();
      ($this->conn)->commit();
      return $arr;
    } catch (Exception $e) {
      ($this->conn)->rollback();
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
