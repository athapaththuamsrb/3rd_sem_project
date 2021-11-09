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
      $q = "SELECT password FROM admins WHERE username=? AND type=?";
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param("ss", $uname, $type);
      $stmt->execute();
      $stmt->store_result();
      $rowcount = $stmt->num_rows;
      if ($rowcount == 1) {
        $stmt->bind_result($password);
        $stmt->fetch();
        if (password_verify($pw, $password)) {
          return true;
        }
      }
    }
    return false;
  }
  /*
  public function auth($uname, $pw, $type) {
    if ($this->validate($uname, $pw)){
      $q = "SELECT password FROM admins WHERE username=? AND type=?";
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param("ss", $uname, $type);
      $stmt->execute();
      //$stmt->store_result();
      $result = $stmt->get_result();
      $rowcount=$result->num_rows;
      if ($rowcount == 1){
        $row = $result->fetch_assoc();
        if (password_verify($pw, $row['password'])){
          return true;
        }
      }
    }
    return false;
  }
*/
  public function create_user($uname, $pw, $type)
  {
    if ($this->validate($uname, $pw)) {
      $hashed = password_hash($pw, PASSWORD_BCRYPT, ["cost" => 12]);
      $q = "INSERT INTO admins (username, password, type) VALUES (?, ?, ?)";
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param("sss", $uname, $hashed, $type);
      $stmt->execute();
      return $stmt->close();
    }
    return false;
  }

  public function get_vaccination_records($id)
  {
    $q0 = "SELECT name, district FROM persons WHERE id=?";
    $arr = array();
    $stmt = $this->conn->prepare($q0);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->store_result();
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

  public function add_vaccine_record($id, $name, $district, $type, $place)
  {
    $q0 = "SELECT token, last_dose FROM persons WHERE id=?";
    $stmt = $this->conn->prepare($q0);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows() == 0) {
      for ($i = 0; $i < 5; $i++) {
        $token = rand(0, (int)pow(2, 64) - 1);
        $token = base_convert($token, 10, 32);
        $q = "INSERT INTO persons (id, name, district, token, last_dose) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($q);
        $new_dose = 1;
        $stmt->bind_param("ssssi", $id, $name, $district, $token, $new_dose);
        $success = $stmt->execute();
        if ($success){
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
    }
    $q2 = "INSERT INTO vaccines (type, dose, date, place, id) VALUES (?, ?, ?, ?, ?)";
    $stmt2 = $this->conn->prepare($q2);
    $date = date("Y/m/d");
    $stmt2->bind_param("sisss", $type, $new_dose, $date, $place, $id);
    $stmt2->execute();
    return $token;
  }

  public function add_test_record($name, $id, $test, $result, $place, $date)
  {
    for ($i = 0; $i < 5; $i++) {
      $token = rand(0, (int)pow(2, 64) - 1);
      $token = base_convert($token, 10, 32);
      $q = "INSERT INTO testing (name, id, token, test, result, place, date) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param("sssssss", $name, $id, $token, $test, $result, $place, $date);
      $success = $stmt->execute();
      if ($success) {
        return $token;
      }
    }
    return false;
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


/*
class DatabaseConn {
  private static $dbconn;
  private $conn;
  
  private function __construct($servername, $username, $password, $database) {
    $this->conn = new mysqli($servername, $username, $password, $database);
  }

  public static function get_conn($servername, $username, $password, $database) {
    if (DatabaseConn::$dbconn == null){
      DatabaseConn::$dbconn = new DatabaseConn($servername, $username, $password, $database);
    }
    return DatabaseConn::$dbconn;
  }

  public function auth($uname, $pw, $type) {
    $q = "SELECT * FROM admins WHERE username='$uname' AND password='$pw' AND type='$type'";
    $result = $this->conn->query($q);
    $rowcount=$result->num_rows;
    if ($rowcount == 1){
      return true;
    }
    return false;
  }

  function __destruct() {
    if ($this->conn) $this->conn->close();
  }
    
}
*/