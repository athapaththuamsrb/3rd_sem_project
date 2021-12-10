<?php
class DBConnection
{
  private static $dbconn;
  private $conn;

  private function __construct()
  {
    $dbconfig = parse_ini_file(".env");
    $servername = $dbconfig["DB_HOST"];
    $username = $dbconfig["DB_USERNAME"];
    $password = $dbconfig["DB_PASSWORD"];
    $database = $dbconfig["DB_DATABASE"];
    $this->conn = new mysqli($servername, $username, $password, $database);
    // mysqli_report(MYSQLI_REPORT_ALL);
  }

  public static function get_conn()
  {
    if (DBConnection::$dbconn == null) {

      DBConnection::$dbconn = new DBConnection();
    }
    return DBConnection::$dbconn;
  }
}
