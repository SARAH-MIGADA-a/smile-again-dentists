<!DOCTYPE html>
<html>

<head>
    <title>Appointments</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <link rel="stylesheet" href="https://use.typekit.net/ypn7ljp.css">
</head>

<?php
    
    include "dbconnect.php";
    session_start();

    if(isset($_POST['wanted_time'])){
        $email = $_SESSION['valid_user'];
        $wanted_time = $_POST['wanted_time'];
        $dentist = $_SESSION['dentist'];
        $thedate = $_SESSION['thedate'];
        $service = $_SESSION['service'];
		
		$to = 'f32ee@localhost';
        $subject = 'Appointment Confirmation';
        $message = 'Hello '.$firstname.' '.$lastname.' !'."\r\n".
                    'Your appointment the '.$thedate.' at '.$wanted_time.' with Doctor '.$dentist.' has been set and confirmed.'."\r\n".
                    'We look forward to see you at our clinic !'."\r\n".
                    'F32ee Dentists, 123 Road Name St.'."\r\n".
					'F32eeDentists@email.com';
        $headers = 'From: f32ee@localhost';
		
		if (isset($_SESSION['reschedule']))
		{
			$olddate = $_SESSION['olddate'];
			$oldtime = $_SESSION['oldtime'];
			unset($_SESSION['reschedule']);
			unset($_SESSION['olddate']);
			unset($_SESSION['oldtime']);
			$query = "UPDATE appointments SET date='$thedate', time='$wanted_time' WHERE email='$email' AND date='$olddate' AND doctor='$dentist' AND time='$oldtime'";
			$result = $dbcnx->query($query);
			if (!$result){
				$_SESSION['message'] = 'Your appointment the '.$olddate.' at '.$oldtime.' with Doctor '.$dentist.' could not be changed !';
			}else{
				$_SESSION['message'] = 'Your appointment the '.$olddate.' at '.$oldtime.' with Doctor '.$dentist.' has been rescheduled to the '.date_format($thedate,"l d, F Y").' at '.$wanted_time.' !';
				mail ($to, $subject, $message, $headers, '-f32ee@localhost');
			}
			header("Location: appointments.php");
		}
		else
		{
			$query = "INSERT INTO `f32ee`.`appointments` (`email`, `date`, `time`, `doctor`) VALUES ('$email', '$thedate', '$wanted_time', '$dentist')";
			$result = $dbcnx->query($query);
			$mydate=date_create($thedate);
			unset($_SESSION['thedate']);
			unset($_SESSION['service']);
			unset($_SESSION['dentist']);
			if (!$result){
				$_SESSION['message'] = 'Your appointment the '.date_format($mydate,"l d, F Y").' at '.$wanted_time.' with Doctor '.$dentist.' could not be set !';
				header("Location: appointments.php");
			}else{
				$_SESSION['message'] = 'Your appointment the '.date_format($mydate,"l d, F Y").' at '.$wanted_time.' with Doctor '.$dentist.' has been set successfully !';
				mail ($to, $subject, $message, $headers, '-f32ee@localhost');
				header("Location: appointments.php");
			}
		}
    }   
?>

<style>
    input {
        width: 20em;
        height: 2em;
    }
</style>
}

<body>
    <div id="container">
        <a href="index.html"><img src="logo.png" width="225px"></a>
        <div id="header">
            <a href="authmain.php" class="button">Book Appointment</a>
            <div id="nav">
                <ul>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
            </div>
        </div>
        <div id="page-intro">
            <h1>Booking an Appointment</h1>
        </div>

        <?php
    if (!isset($_SESSION['thedate'])){
        $_SESSION['thedate'] = $_POST['thedate'];
    }
    if (!isset($_SESSION['service'])){
        $_SESSION['service'] = $_POST['service'];
    }
    if (!isset($_SESSION['dentist'])){
        $_SESSION['dentist'] = $_POST['dentist'];
    }
    $email = $_SESSION['valid_user'];
    $thedate = $_SESSION['thedate'];
    $service = $_SESSION['service'];
    $dentist = $_SESSION['dentist'];
	
	$mydate=date_create($thedate);
    $now = date_create();
	
	if ($mydate < $now)
    {
        echo '<p><td> The date cannot be in the past!</strong></p>';
    }
    else
    {
		echo '<h2>Select a Time</h2> <br />';
		echo '<p> '.date_format($mydate,"l d, F Y").'</p>';
		echo '<table border="1" class="new-appointment">';
		for ($i=0; $i<9; $i++) {
			$temp = 8 + $i;
			$thetime = $temp.':00';
			echo '<tr><td>'.$thetime.'</td>';
			echo '<form action="" method="post">';
			$query = "SELECT * FROM appointments WHERE doctor='$dentist' AND date='$thedate' AND time='$thetime'";
			$result = $dbcnx->query($query);
			$num_results = $result->num_rows;
			if (!$num_results && $temp != 12)
			{
				echo '<td bgcolor="#00FF00" class="new-td"><input type="submit" name="wanted_time" value="'.$thetime.'"  style="background-color: #00ff00; color: #00ff00; border: none;"></td></tr>';
			}else{
				echo '<td bgcolor="#FF0000" style="width: 7em;  height: 2em;" /></tr>';
			}
		}
		echo '</table>';
	}
	?>
        <br /><a href="appointments.php" class="appointment-link">
            <p>
                < &nbsp; <u>Back to appointments page</u>
            </p>
        </a>
    </div>
    <footer>
        <table align="center">
            <tr>
                <td rowspan="3"><img src="logo.png" width="175px"></td>
                <td>F32ee Dentists</td>
                <td>Tel: (00) 000-0000</td>
            </tr>
            <tr>
                <td>123 Road Name St.</td>
                <td>Fax: (00) 000-0000</td>
            </tr>
            <tr>
                <td>Singapore 000000</td>
                <td>Email: F32eeDentists@email.com</td>
            </tr>
        </table>
        <br><br>
        <small>&copy; F32ee Dentists 2019. All Rights Reserved.</small>
    </footer>
</body>

</html>