<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "final_project";

$conn = new mysqli($servername, $username, $password,$dbname);
if($conn->connect_error){
	die("Connection failed:".$conn->connect_error);
}

$conn2 = new mysqli($servername, $username, $password,$dbname);
if($conn2->connect_error){
	die("Connection failed:".$conn2->connect_error);
}

?>