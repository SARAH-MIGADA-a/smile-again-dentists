<html>

<head>
    <title>Register</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css" type="text/css">
    <link rel="stylesheet" href="https://use.typekit.net/ypn7ljp.css">
</head>

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
            <h1>Register</h1>
        </div>

        <?php // register.php
include "dbconnect.php";
if (isset($_POST['createaccount'])) {
	if (empty($_POST['email']) || empty ($_POST['password'])
		|| empty ($_POST['password2']) || empty ($_POST['firstname']) 
		|| empty ($_POST['lastname']) || empty ($_POST['phone'])) {
    echo "<p> All records to be filled in </p>";
    echo '<br /><a href="registration.html"><p>< &nbsp; <u>Back to registration page</u></p></a>';
	exit;}
	}
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

if ($dbcnx->connect_error){
	echo "Database is not online"; 
	exit;
}

$query = "SELECT* FROM project_users WHERE email='$email'";
$result = $dbcnx->query($query);
if ($result->num_rows)
{
	echo "<p> This email address is already attached to an account ! </p>";
	echo '<br /><a href="registration.html" class="appointment-link"><p>< &nbsp; <u>Back to registration page</u></p></a>';
	exit;
}


if ($password != $password2) {
    echo "<p>The passwords do not match</p>";
    echo '<br /><a href="registration.html" class="appointment-link"><p>< &nbsp; <u>Back to registration page</u></p></a>';
	exit;
}
$password = md5($password);
$query = "INSERT INTO project_users (firstname, lastname, email, phone, password) 
        VALUES ('$firstname', '$lastname', '$email', '$phone', '$password')";
$result = $dbcnx->query($query);

if (!$result){
	echo "<p>Your query failed.</p>";
	echo '<br /><a href="authmain.php"><p>< &nbsp; <u>Back to authentification page</u></p></a>';
}else{
	echo "<p>Welcome ". $firstname . " " . $lastname . ". You are now registered</p>";
	echo '<br /><a href="authmain.php"><p>< &nbsp; <u>Back to authentification page</u></p></a>';
}
	
?>
    </div>
    <footer>
            <table align="center">
                <tr>
                    <td rowspan="3"><img src="logo.png" width="175px"></td>
                    <td>Smile Again Dentists</td>
                    <td>Tel: (+254) 700-0000</td>
                </tr>
                <tr>
                    <td>123 Road Name St.Annes</td>
                    <td>Fax: (+254) 700-0000</td>
                </tr>
                <tr>
                    <td>Singapore 010000</td>
                    <td>Email: SmileAgainDentists@email.com</td>
                </tr>
            </table>
            <br><br>
            <small>&copy; Smile Again Dentists 2019. All Rights Reserved.</small>
        </footer>

</body>

</html>