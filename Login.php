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

if(!empty($_POST['username'])){
	$name = $_POST['username'];
	$sql = "SELECT * FROM users where username = '$name'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	
	if(!empty($row['username'])){
		$_SESSION['username'] = $row['username'];
		$_SESSION['password'] = $_POST['password'];
		header("Location: projects.php ");
		exit;
	}else{
		echo "Incorrect username.";
	}
}else{
	echo "Please enter customer name.";
}

$conn->close();

?>