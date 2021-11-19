<?php

class DatabaseConn
{
  private static $dbconn;
  private $conn;

  private function __construct($servername, $username, $password, $database)
  {
    $this->conn = new mysqli($servername, $username, $password, $database);
    mysqli_report(MYSQLI_REPORT_ALL);
  }

  public static function get_conn()
  {
    if (DatabaseConn::$dbconn == null) {
      $dbconfig = parse_ini_file(".env");
      $servername = $dbconfig["DB_HOST"];
      $username = $dbconfig["DB_USERNAME"];
      $password = $dbconfig["DB_PASSWORD"];
      $database = $dbconfig["DB_DATABASE"];
      DatabaseConn::$dbconn = new DatabaseConn($servername, $username, $password, $database);
    }
    return DatabaseConn::$dbconn;
  }

  public function auth($uname, $pw, $type)
  {
    if ($this->validate($uname, $pw)) {
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $q = "SELECT password, place, district FROM admins WHERE username=? AND type=?";
      $arr = array();
      try{
        $stmt = $this->conn->prepare($q);
        $stmt->bind_param("ss", $uname, $type);
        $stmt->execute();
        $stmt->store_result();
        $rowcount = $stmt->num_rows;
        if ($rowcount == 1) {
          $stmt->bind_result($password, $place, $district);
          $stmt->fetch();
          if (password_verify($pw, $password)) {
            if ($type !== "admin"){
              $arr["place"] = $place;
              $arr["district"] = $district;
            }
            else{
              $arr["place"] = "";
              $arr["district"] = "";
            }
            return $arr;
          }
        }
      }
      catch (Exception $e){
        return $arr;
      }
    }
    return null;
  }
  
  public function create_user($uname, $pw, $type, $place, $district)
  {
    if ($type !== 'admin' && !$place){
      return false;
    }
    if ($this->validate($uname, $pw)) {
      $hashed = password_hash($pw, PASSWORD_BCRYPT, ["cost" => 12]);
      $q = "INSERT INTO admins (username, password, type, place, district) VALUES (?, ?, ?, ?, ?)";
      try{
        $stmt = $this->conn->prepare($q);
        $stmt->bind_param("sssss", $uname, $hashed, $type, $place, $district);
        $stmt->execute();
        return $stmt->close();
      }
      catch (Exception $e){
        return false;
      }
    }
    return false;
  }

  public function get_vaccination_records($id, $token)
  {
    try{
      if ($token == null){
        $q0 = "SELECT name, district FROM persons WHERE id=?";
        $stmt = $this->conn->prepare($q0);
        $stmt->bind_param("s", $id);
      }
      else{
        $q0 = "SELECT name, district FROM persons WHERE id=? and token=?";
        $stmt = $this->conn->prepare($q0);
        $stmt->bind_param("ss", $id, $token);
      }
      $stmt->execute();
      $stmt->store_result();
      $arr = array();
      if ($stmt->num_rows() == 0){
        return $arr;
      }
      $stmt->bind_result($name, $district);
      $stmt->fetch();
      $arr["name"] = $name; $arr["district"] = $district; $arr["id"] = $id; $arr["doses"] = array();
      $q = "SELECT * FROM vaccines WHERE id=? ORDER BY dose";
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param("s", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      while($row = $result->fetch_assoc()){
        $details = array("type"=>$row["type"], "date"=>$row["date"], "place"=>$row["place"]);
        array_push($arr["doses"], $details);
      }
      return $arr;
    }
    catch (Exception $e){
      return false;
    }   
  }

  public function add_vaccine_record($details)
  {
    try{
      $online = true;
      $id = $details['id']; $name = $details['name']; $district = $details['district']; $type = $details['type']; $place = $details['place']; $address = $details['address']; $contact = $details['contact']; $email = $details['email']; $date = date("Y-m-d");
      $Q = "SELECT * FROM appointments WHERE id=? AND date=? AND type=? AND district=? AND place=?";
      $Stmt = $this->conn->prepare($Q);
      $Stmt->bind_param("sssss", $id, $date, $type, $district, $place);
      $Stmt->execute();
      $Result = $Stmt->get_result();
      if ($Result->num_rows == 0){
        $online = false;
      }
      $q0 = "SELECT token, last_dose FROM persons WHERE id=?";
      $stmt = $this->conn->prepare($q0);
      $stmt->bind_param("s", $id);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows() == 0) {
        for ($i = 0; $i < 5; $i++) {
          $token = rand(1, (int)pow(2, 64) - 1);
          $token = base_convert($token, 10, 32);
          $q = "INSERT INTO persons (id, name, district, address, contact, email, token, last_dose) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
          $stmt = $this->conn->prepare($q);
          $new_dose = 1;
          $stmt->bind_param("sssssssi", $id, $name, $district, $address, $contact, $email, $token, $new_dose);
          $success = $stmt->execute();
          if ($success){
            if ($online){
              $this->update_stocks($district, $place, $date, $type, "online",-1, $new_dose);
            }
            else{
              $this->update_stocks($district, $place, $date, $type, "offline",-1, $new_dose);
            }
            break;
          }
        }
      } else {
        $stmt->bind_result($token, $last_dose);
        $stmt->fetch();
        $new_dose = $last_dose + 1;
        $q1 = "UPDATE persons SET last_dose=?  WHERE id=?";
        $stmt1 = $this->conn->prepare($q1);
        $stmt1->bind_param("is", $new_dose, $id);
        $stmt1->execute();
        if ($online){
          $this->update_stocks($district, $place, $date, $type, "online",-1, $new_dose);
        }
        else{
          $this->update_stocks($district, $place, $date, $type, "offline",-1, $new_dose);
        }
      }
      $q2 = "INSERT INTO vaccines (type, dose, date, place, id) VALUES (?, ?, ?, ?, ?)";
      $stmt2 = $this->conn->prepare($q2);
      $stmt2->bind_param("sisss", $type, $new_dose, $date, $place, $id);
      $stmt2->execute();
      return $token;
    }
    catch (Exception $e){
      return false;
    }
  }

  public function add_test_record($details)
  {
    try{
      $name = $details['name']; $id = $details['id']; $address = $details['address']; $contact = $details['contact']; $email = $details['email']; $test = $details['test']; $result = $details['result']; $place = $details['place']; $date = $details['date'];
      $q0 = "SELECT id FROM persons WHERE id=?";
      $stmt0 = $this->conn->prepare($q0);
      $stmt0->bind_param("s", $id);
      $stmt0->execute();
      $stmt0->store_result();
      if ($stmt0->num_rows() == 0) {
        $q1 = "INSERT INTO persons (id, name, district, address, contact, email) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt1 = $this->conn->prepare($q1);
        $stmt1->bind_param("ssssss", $id, $name, $district, $address, $contact, $email);
        $stmt1->execute();
      }
      for ($i = 0; $i < 5; $i++) {
        $token = rand(1, (int)pow(2, 64) - 1);
        $token = base_convert($token, 10, 32);
        $q2 = "INSERT INTO testing (id, token, test, result, place, date) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt2 = $this->conn->prepare($q2);
        $stmt2->bind_param("ssssss", $id, $token, $test, $result, $place, $date);
        $success = $stmt2->execute();
        if ($success) {
          return $token;
        }
      }
    }
    catch (Exception $e){
      return false;
    }
  }

  public function add_stock($district, $place, $date, $type, $dose, $offline, $online){
    try{
      $q = "INSERT INTO stocks (district, place, date, type, dose, offline, online, appointments) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $this->conn->prepare($q);
      $datestr = $date->format('Y-m-d');
      $stmt->bind_param("ssssiiii", $district, $place, $datestr, $type, $dose, $offline, $online, $online);
      $success = $stmt->execute();
      return $success;
    }
    catch (Exception $e){
      return false;
    }
  }

  public function update_stocks($district, $place, $date, $type, $field, $amount, $dose){
    try{
      if ($field === "online"){
        $q = "UPDATE table stocks online = online + $amount WHERE district = ? AND place = ? AND date = ? and type = ? and dose = ?";
      }
      else if ($field === "offline"){
        $q = "UPDATE table stocks offline = offline + $amount district = ? AND place = ? AND date = ? and type = ? and dose = ?";
      }
      else{
        $q = "UPDATE table stocks appointments = appointements + $amount WHERE district = ? AND place = ? AND date = ? and type = ? and dose = ?";
      }
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param("ssssi", $district, $place, $date, $type, $dose);
      $success = $stmt->execute();
      return $success;
    }
    catch (Exception $e){
      return false;
    }  
  }

  public function filter_vaccine_centers($district, $date){
    try{
      $q0 = "SELECT place FROM admins WHERE district=?";
      $stmt0 = $this->conn->prepare($q0);
      $stmt0->bind_param("s", $district);
      $stmt0->execute();
      $result0 = $stmt0->get_result();
      $arr = array();
      while($row = $result0->fetch_assoc()){
        $record = array();
        $place = $row['place'];
        $record["place"] = $place;
        $q1 = "SELECT type, offline, online FROM stocks WHERE district=? AND place=? AND date=?";
        $stmt1 = $this->conn->prepare($q1);
        $stmt1->bind_param("sss", $district, $place, $date);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        while ($center = $result1->fetch_assoc()){
          $type = $center['type']; $offline = $center['offline']; $online = $center['online']; 
          $availability = array("offline"=>$offline, "online"=>$online);
          $record[$type] = $availability;
        }
        array_push($arr, $record);
      }
      return $arr;
    }
    catch (Exception $e){
      return false;
    } 
  }

  public function add_appointment($id, $name, $address, $contact, $email, $district, $place, $date, $type){
    try{
      $q = "INSERT INTO appointments (id, name, address, contact, email, district, place, date, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param("sssssssss", $id, $name, $address, $contact, $email, $district, $place, $date, $type);
      $stmt->execute();
      $q0 = "SELECT last_dose FROM persons WHERE id=?";
      $stmt = $this->conn->prepare($q0);
      $stmt->bind_param("s", $id);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows() == 0) {
        $dose = 1;
      }
      else{
        $stmt->bind_result($last_dose);
        $stmt->fetch();
        $dose = $last_dose + 1;
      }
      $this->update_stocks($district, $place, $date, $type, "appointment", -1, $dose);
    }
    catch (Exception $e){
      return false;
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
    $uname_pattern = "/^[a-zA-Z0-9_]{5,20}$/";
    $pw_pattern = "/^\S{8,15}$/";
    //$pw_pattern = "/^\S*(?=\S{8,15})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/";
    if (preg_match($uname_pattern, $uname) && preg_match($pw_pattern, $pw)) {
      return true;
    }
    return false;
  }

  public function __destruct()
  {
  }
}

