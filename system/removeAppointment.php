<?php

/**
 * This file should NOT be served on web to any user.
 * This file should be run daily at a specified time.
 * Use a taks scheduler to run the following command at the scheduled time
 *      php -f system/removeAppointments.php
 */
chdir(__DIR__);
require_once('../.utils/dbcon.php');
$con = DatabaseConn::get_conn();
if ($con) {
  $con->removeAppointments('vaccination', new DateTime());
  $con->removeAppointments('testing', new DateTime());
  // TODO : log the results
}
