<?php //authmain.php
include "dbconnect.php";
session_start();
$date = $_POST['date'];
$time = $_POST['time'];
$doctor = $_POST['doctor'];
$_SESSION['dentist'] = $doctor;


    if (isset($_POST['cancel'])) {
        
        $query = "DELETE FROM appointments WHERE time='$time' AND date='$date' AND doctor='$doctor'";
        $result = $dbcnx->query($query);
        if ($result) {
            $_SESSION['message'] = 'Cancellation of the ' .$date. ', ' . $time . ' appointment with Doctor ' . $doctor . ' has been successful !';
            header("Location: appointments.php");
        } else {
            $_SESSION['message'] = 'Cancellation of the ' . $date . ', ' . $time . ' appointment with Doctor ' . $doctor . ' could not be performed !';
            header("Location: appointments.php");
        }
    } else {
		$_SESSION['reschedule'] = 'yeah';
		$_SESSION['olddate'] = $date;
		$_SESSION['oldtime'] = $time;
        $_SESSION['message'] = '<form action="scheduleappointment.php" method="post">
		<p class="large"> Select the new date for your ' .$date. ', ' . $time . ' appointment with Doctor ' . $doctor . ':</p><br />
		<input type="date" name="thedate"  style="margin: auto;" class="date-select"><br>
		<input type="submit" value="Book New Appointment" class="button" style="margin: 100px 0;"></form>';
		header("Location: appointments.php");
    }
?>
