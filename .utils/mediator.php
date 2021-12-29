<?php
require_once('dbcon.php');
require_once('accounts.php');

class Mediator
{
    private $centreList;
    private $type;
    public function __construct($district, $type)
    {
        $con = DatabaseConn::get_conn();
        $this->type = $type;
        $this->centreList = $con->getVaccineCentresInDistrict($district, $type);
    }

    public function sendEmails($user, $dose, $amount)
    {
        $place = $user->getPlace();
        $count  = 0;
        foreach ($this->centreList as $centre) {
            if ($place == $centre->getPlace()) {
                continue;
            }
            if (Mediator::sendEmail($centre->getEmail(), $this->type, $dose, $amount, $place)){
                $count++;
            }
        }
        return $count;
    }

    private static function sendEmail($email, $type, $dose, $amount, $place)
    {
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // the message
        $msg = "<html><body><h3>We need more vaccines at $place </h3><p>type : $type <br>dose : $dose <br>amount : $amount </p><p>click <a href=\"http://$_SERVER[HTTP_HOST]/vaccination/donate.php?place=$place&type=$type\">this link</a> to donate vaccines.</p></body></html>";
        return mail($email, "Request more vaccines", $msg);
    }
}
