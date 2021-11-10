<?php
require_once('dbcon.php');

class User
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }
}

class Authenticator
{
    private $type;
    protected function __construct($type)
    {
        $this->type = $type;
    }

    public function authenticate($uname, $passwd)
    {
        $dbcon = DatabaseConn::get_conn();
        if (!$dbcon || !$dbcon->auth($uname, $passwd, $this->type)) {
            session_start();
            $_SESSION['invalidPass'] = true;
            session_write_close();
            header('HTTP/1.1 401 UNAUTHORIZED');
            header("Location: /$this->type/login.php");
            die();
        } else {
            $user = new User($this->type);
            session_start();
            $_SESSION['invalidPass'] = false;
            $_SESSION['user'] = $user;
            $target = '/' . $this->type;
            if (isset($_SESSION['target']) && $_SESSION['target']){
                if (preg_match("/^\/$this->type\/.*$/", $_SESSION['target'])){ // redirect only if the target is allowed for the logged in user
                    $target = $_SESSION['target'];
                }
                unset($_SESSION['target']);
            }
            session_write_close();
            header('HTTP/1.1 302 Found');
            header("Location: $target");
            die();
        }
    }

    public function check_auth()
    {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user'] == null || $_SESSION['user']->getType() != $this->type) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET'){
                $_SESSION['target'] = $_SERVER['REQUEST_URI'];
            }
            session_write_close();
            $type = $this->type;
            header('HTTP/1.1 401 UNAUTHORIZED');
            header("Location: /$type/login.php");
            die();
        } else {
            session_write_close();
        }
    }
}

?>