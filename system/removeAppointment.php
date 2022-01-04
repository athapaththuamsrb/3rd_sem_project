<?php

/**
 * This file should NOT be served on web to any user.
 * This file should be run daily at a specified time.
 * Use a taks scheduler to run the following command at the scheduled time
 *      php -f system/removeAppointments.php
 */
chdir(__DIR__);
require_once('../.utils/dbcon.php');
define('LOG_FILE', 'sys.log');

function logStatus($status, $type)
{
  $fp = fopen(LOG_FILE, 'a');
  fwrite($fp, "Remove $type Appointments:\t");
  fwrite($fp, '[' . (new DateTime('now'))->format('Y-m-d H:i:s') . "]\t");
  if ($status) {
    fwrite($fp, "Success");
  } else {
    fwrite($fp, "Failed");
  }
  fwrite($fp, "\n");
  fclose($fp);
}
$con = DatabaseConn::get_conn();
if ($con) {
  $status_vaccine = $con->removeAppointments('vaccination', new DateTime());
  logStatus($status_vaccine, 'Vaccine');
  $status_testing = $con->removeAppointments('testing', new DateTime());
  logStatus($status_testing, 'Testing');
}
