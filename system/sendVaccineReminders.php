<?php
/**
 * This file should NOT be served on web to any user.
 * This file should be run daily at a specified time.
 * Use a taks scheduler to run the following command at the scheduled time
 *      php -f system/sendVaccineReminders.php
 */

require_once('../.utils/dbcon.php');
$con = DatabaseConn::get_conn();
if ($con) {
  $appointments = $con->getAppointmentsByDate(new DateTime('tomorrow'));
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
      $msg = "<html><body><h2>Vaccination Reminder</h2><p>You";
      if ($name){
        $msg .= " ($name)";
      }
      $msg .= ", having ID number $id can get your $type vaccine on tomorrow at $place ($district)</p></body></html>";
      mail($email, "Vaccination on tomorrow", $msg, $headers);
      // TODO : use a log to store status of sent mails and failed mails
    } catch (Exception $e) {
    }
  }
}
