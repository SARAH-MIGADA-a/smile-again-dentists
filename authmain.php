<html>

<head>
    <title>Authentication</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <link rel="stylesheet" href="https://use.typekit.net/ypn7ljp.css">
</head>

<?php //authmain.php
include "dbconnect.php";
session_start();

if (isset($_POST['email']) && isset($_POST['password']))
{
  // if the user has just tried to log in
  $email = $_POST['email'];
  $password = $_POST['password'];

  $password = md5($password);
  $query = 'select * from project_users '
           ."where email='$email' "
           ." and password='$password'";

  $result = $dbcnx->query($query);
  if ($result->num_rows >0 )
  {
    // if they are in the database register the user id
    $_SESSION['valid_user'] = $email;    
  }
  $dbcnx->close();
}
?>

<body>


    <div id="container">
        <a href="index.html"><img src="logo.png" width="225px"></a>
        <div id="header">
            <a href="#" class="button">Book Appointment</a>
            <div id="nav">
                <ul>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
            </div>
        </div>
        <div id="page-intro">
            <h1>Authentication</h1>
        </div>
        
        <?php
  if (isset($_SESSION['valid_user']))
  { //Go to your appointments or whatever
    header("Location: appointments.php");
    // echo 'You are logged in with: '.$_SESSION['valid_user'].' <br />';
    // echo '<a href="appointments.php" class="button">View Your Appointments</a>';
    // echo '<a href="logout.php" class="button">Log out</a><br />';
    //OR 
  }
  else
  {
    if (isset($email))
    {
      // if they've tried and failed to log in
      echo '<p>Could not log you in.</p>';
    }
    // else 
    // {
    //   // they have not tried to log in yet or have logged out
    //   echo 'You are not logged in.<br />';
    // }

    // provide form to log in 
    
    echo '<form method="post" action="authmain.php">';
    echo '<table border="0" class="new-appointment">';
    echo '<tr><td class="left-column"><label>Email:</label></td>';
    echo '<td class="left-column"> <label>Password:</label></td></tr>';
    echo '<tr><td class="left-column"><input type="text" name="email" class="text-input"></td>';
    echo '<td class="left-column"><input type="password" name="password" class="text-input"></td>';
    echo '<td class="left-column"><input type="submit" value="Login" name="createaccount" id="createaccount" class="button"></td></tr>';
    echo '<tr;"><td colspan=2 class="no-account">Do not have an account? <a href="registration.html" class="appointment-link"><u>Sign Up.</u></a></td></tr>';
    echo '</table>';
    echo '</form>';

  }
?>
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