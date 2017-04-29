<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<title>Projects!</title>
</head>
<body>
	<<?php 

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "marketplace";

	$conn = new mysqli($servername, $username, $password,$dbname);
	if($conn->connect_error){
		die("Connection failed:"$conn->connect_error);
	}

	SESSION_start();


	







	 ?>



</body>
</html>