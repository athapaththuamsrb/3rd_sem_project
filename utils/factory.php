<?php
require_once('dbcon.php');

class AccountFactory
{
  public static function getAccount($type, $details)
  {
    if (!$details['username'] || !$details['password'] || !$details['email']) {
      return null;
    }
    $con = DatabaseConn::get_conn();
    switch ($type) {
      case 'admin': {
          return new AdminSaver($con, $details['username'], $details['password'], $details['email']);
          break;
        }
      case 'vaccination': {
          if (!$details['place'] || !$details['district']) {
            return null;
          }
          return new VaccinationAdminSaver($con, $details['username'], $details['password'], $details['place'], $details['district'], $details['email']);
          break;
        }
      case 'testing': {
          if (!$details['place'] || !$details['district']) {
            return null;
          }
          return new TestingAdminSaver($con, $details['username'], $details['password'], $details['place'], $details['district'], $details['email']);
          break;
        }
      default:
        return null;
        break;
    }
  }
}

interface IaccountSaver
{
  public function saveToDB();
}

abstract class AccountSaver implements IaccountSaver
{
  private $username;
  private $password;
  private $email;
  protected $con;

  protected function __construct($con, $username, $password, $email)
  {
    $this->con = $con;
    $this->username = $username;
    $this->password = $password;
    $this->email = $email;
  }

  protected function getUsername()
  {
    return $this->username;
  }

  protected function getPassword()
  {
    return $this->password;
  }

  protected function getEmail()
  {
    return $this->email;
  }
}

abstract class CentreAdminSaver extends AccountSaver
{
  private $place;
  private $district;

  protected function __construct($con, $username, $password, $place, $district, $email)
  {
    parent::__construct($con, $username, $password, $email);
    $this->place = $place;
    $this->district = $district;
  }

  protected function getPlace()
  {
    return $this->place;
  }

  protected function getDistrict()
  {
    return $this->district;
  }
}

class AdminSaver extends AccountSaver
{
  public function __construct($con, $username, $password, $email)
  {
    parent::__construct($con, $username, $password, $email);
  }

  public function saveToDB()
  {
    if (!$this->con) {
      return false;
    }
    return $this->con->create_user($this->getUsername(), $this->getPassword(), 'admin', null, null, $this->getEmail());
  }
}

class VaccinationAdminSaver extends CentreAdminSaver
{
  public function __construct($con, $username, $password, $place, $district, $email)
  {
    parent::__construct($con, $username, $password, $place, $district, $email);
  }

  public function saveToDB()
  {
    if (!$this->con) {
      return false;
    }
    return $this->con->create_user($this->getUsername(), $this->getPassword(), 'vaccination', $this->getPlace(), $this->getDistrict(), $this->getEmail());
  }
}

class TestingAdminSaver extends CentreAdminSaver
{
  public function __construct($con, $username, $password, $place, $district, $email)
  {
    parent::__construct($con, $username, $password, $place, $district, $email);
  }

  public function saveToDB()
  {
    if (!$this->con) {
      return false;
    }
    return $this->con->create_user($this->getUsername(), $this->getPassword(), 'testing', $this->getPlace(), $this->getDistrict(), $this->getEmail());
  }
}
