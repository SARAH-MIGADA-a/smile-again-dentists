<!DOCTYPE html>
<html>

<head>
    <title>Appointments</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <link rel="stylesheet" href="https://use.typekit.net/ypn7ljp.css">
</head>

<?php //authmain.php
include "dbconnect.php";
session_start();
unset($_SESSION['thedate']);
?>

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
            <h1>Your Appointments</h1>
        </div>

        <?php
    if (isset($_SESSION['message']))
    {
        echo '<p><strong>'.$_SESSION['message'].'</strong></p>';
        unset($_SESSION['message']);
    }
    
    if (!isset($_SESSION['valid_user']))
    {
        echo '<p class="large">You are not logged in ! </p>';
        echo '<a href="authmain.php" class="appointment-link"><p> < &nbsp;<u>Back to log in page</u></p></a>';
    }



    else
    {
        //Upcoming appointments
        //Retrieve appointments data, display them
        echo '<h2>Upcoming appointments</h2>';
        $email = $_SESSION['valid_user'];
        $query = "SELECT * FROM appointments WHERE email='$email' ";
        $result = $dbcnx->query($query);
        $num_results = $result->num_rows;
        if (!$num_results)
        {
            echo '<p class="large"><strong> You have no appointments scheduled !</strong></p>';
        }
        else
        {
            for ($i=0; $i <$num_results; $i++) {
                $row = $result->fetch_assoc();
                $query = "SELECT * FROM doctors WHERE name='$row[doctor]' ";
                $contact = $dbcnx->query($query)->fetch_assoc();
                echo '<br /><table class="upcoming-appointments">';
                echo '<tr><td colspan=2><strong>';
                $date=date_create($row[date]);
                echo date_format($date,"l d, F Y");
                echo ' at '. $row[time] .' with Doctor '. $row[doctor].'</td></tr>';
                echo '<tr style="text-align:left;"><td> F32ee Dentists <br /> 123 Road Name St. <br /> Singapore 000000</td>';
                echo '<td class="upcoming-left">'.$contact[fullname].'<br />'.$contact[phone].'<br />'.$contact[email].'</td></tr>';
                echo '<tr style="text-align:center;">';
                echo '<form action="changeapppointment.php" method="post">';
                echo '<input type="hidden" name="date" value='.$row[date].' />';
                echo '<input type="hidden" name="doctor" value='.$row[doctor].' />';
                echo '<input type="hidden" name="time" value='.$row[time].' />';
                echo '<td><input type="submit" name="change" value="Change" class="button"/></td>'; //Add cookie to transmit date, time and doc
                echo '<td><input type="submit" name="cancel" value="Cancel" class="button"/></td></tr>'; //Add cookie to transmit date, time and doc
                echo '</form></table>';
            }
        }
        //Schedule new appointments
        echo '<div id="new-appointment-wrapper">';
        
        echo '<br /><h2>Schedule new appointments</h2>';
        echo '<table cellspacing="10" class="new-appointment">';
        echo '<tr><td class="left-column"><label>Dentist :</label></td> <td width="50" /> <td class="left-column"><label>Service :</label></td></tr>';

		echo '<form action="scheduleappointment.php" method="post">';
        echo '<tr><td class="left-column"><select id="dentist" name="dentist" class="dropdown">';

        $query = "SELECT * FROM doctors";
        $result = $dbcnx->query($query);
        $num_results = $result->num_rows;
        
        for ($i=0; $i <$num_results; $i++) {
            $row = $result->fetch_assoc();
            echo '<option value="'.$row[name].'">'.$row[fullname].'</option>';
        }
        echo '</select></td>';
        echo '<td width="50" />';

        echo '<td class="left-column"><select id="service" name="service" class="dropdown">';
        echo '<option value="ser1">Service 1</option> <option value="ser2">Service 2</option> <option value="ser3">Service 3</option></select></td></tr>';
        echo '<tr><td height="30" /></tr>';

        echo '<tr><td class="left-column"><label> Select the date :</label></td></tr>';
        echo '<tr><td class="left-column"><input type="date" name="thedate" style="margin-bottom:50px; " class="date-select"></td></tr>';
        echo '<tr><td height="20" /></tr>';

        echo '<tr><td class="left-column"><input type="submit" value="Book Appointment" class="button"></td></tr>';
        echo '</table></form>';
        //Need to think about this one
        }
    ?>
    </div>
	<a href="logout.php" class="button">Log Out</a>
	</div>
    <footer id="logout-footer">
        <table align="center">
            <tr>
                <td rowspan="3"><img src="logo.png" width="175px"></td>
                <td>Smile Again Dentists</td>
                <td>Tel: (+254) 700-9000</td>
            </tr>
            <tr>
                <td>123 Road Name St.Annes</td>
                <td>Fax: (+254) 700000</td>
            </tr>
            <tr>
                <td>Kenya +254</td>
                <td>Email: smileaginDentists@email.com</td>
            </tr>
        </table>
        <br><br>
        <small>&copy; Smile Again Dentists 2023. All Rights Reserved.</small>
    </footer>
</body>

</html>