<?php

use function PHPSTORM_META\type;

class DatabaseConn
{
  private static $dbconn;
  private $conn;

  private function __construct($servername, $username, $password, $database)
  {
    $this->conn = new mysqli($servername, $username, $password, $database);
    mysqli_report(MYSQLI_REPORT_ALL);
  }

  public static function get_conn($servername, $username, $password, $database)
  {
    if (DatabaseConn::$dbconn == null) {
      DatabaseConn::$dbconn = new DatabaseConn($servername, $username, $password, $database);
    }
    return DatabaseConn::$dbconn;
  }

  public function auth($uname, $pw, $type)
  {
    if ($this->validate($uname, $pw)) {
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

  public function add_vaccine_record($name, $id, $vaccine, $dose, $place, $date)
  {
    if ($dose == 1) {
      for ($i = 0; $i < 5; $i++) {
        $token = rand(0, (int)pow(2, 64) - 1);
        $token = base_convert($token, 10, 32);
        $q = "INSERT INTO vaccination (name, id, token, vaccine, f_place, f_date) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($q);
        $stmt->bind_param("ssssss", $name, $id, $token, $vaccine, $place, $date);
        $success = $stmt->execute();
        if ($success) {
          return $token;
        }
      }
      return false;
    } else {
      $q = "SELECT token FROM vaccination WHERE id=? AND vaccine=?";
      $stmt = $this->conn->prepare($q);
      $stmt->bind_param("ss", $id, $vaccine);
      $stmt->execute();
      $stmt->store_result();
      $rowcount = $stmt->num_rows;
      if ($rowcount == 0) {
        return false;
      }
      $q1 = "UPDATE vaccination SET s_place=?, s_date=?  WHERE id=?";
      $stmt1 = $this->conn->prepare($q1);
      $stmt1->bind_param("sss", $place, $date, $id);
      $success = $stmt1->execute();
      $stmt->bind_result($token);
      $stmt->fetch();
      if ($success) {
        return $token;
      }
      return false;
    }
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