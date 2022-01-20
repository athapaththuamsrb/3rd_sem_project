<?php

/**
 * This file should NOT be served on web to any user.
 * This file should be run daily at a specified time.
 * Use a taks scheduler to run the following command at the scheduled time
 *      php -f system/sendTestingReminders.php
 */
chdir(__DIR__);
require_once('../utils/dbcon.php');
define('LOG_FILE', 'sys.log');

$con = DatabaseConn::get_conn();
if ($con) {
  $appointments = $con->getTestingAppointmentsByDate(new DateTime('tomorrow'));
  foreach ($appointments as $appointment) {
    try {
      $email = $appointment['email'];
      $id = $appointment['id'];
      $type = $appointment['type'];
      $place = $appointment['place'];
      $district = $appointment['district'];
      if (!$email) {
        continue;
      }
      $name = $appointment['name'];

      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

      // the message
      $msg = "<html><body><h2>Testing Reminder</h2><p>You";
      if ($name) {
        $msg .= " ($name)";
      }
      $msg .= ", having ID number $id can do your $type test on tomorrow at $place ($district)</p></body></html>";
      $status = mail($email, "Testing on tomorrow", $msg, $headers);
      $fp = fopen(LOG_FILE, 'a');
      fwrite($fp, "Send Testing Reminders:\t");
      fwrite($fp, '[' . (new DateTime('now'))->format('Y-m-d H:i:s') . "]\t");
      if ($status) {
        fwrite($fp, "Success\t");
      } else {
        fwrite($fp, "Failed\t");
      }
      fwrite($fp, "TO:$email\n");
      fclose($fp);
    } catch (Exception $e) {
      $msg = $e->getMessage();
      $msg = str_replace(["\n", "\r"], ' ', $msg);
      $fp = fopen(LOG_FILE, 'a');
      fwrite($fp, "Send Testing Reminders:\t");
      fwrite($fp, '[' . (new DateTime('now'))->format('Y-m-d H:i:s') . "]\t");
      fwrite($fp, "Error\t");
      fwrite($fp, "TO:$email\t");
      fwrite($fp, "($msg)\n");
      fclose($fp);
    }
  }
}
