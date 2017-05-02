<?php
	$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final_project";

$conn = new mysqli($servername, $username, $password,$dbname);
if($conn->connect_error){
	die("Connection failed:".$conn->connect_error);
}
SESSION_start();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Registrtaion Successful!</title>
</head>
<body>

<h2>Registration Successful!</h2>

<br><h3><a href="projects.php"> Want to view the campaigns and contribute to them? Click here.</a></h3></br>

</body>
</html>