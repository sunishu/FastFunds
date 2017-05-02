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
	$sql = mysqli_query($conn, "SELECT * FROM users where username = '$name'");
	$result = mysqli_fetch_array($sql);
	
	if($result = $name){
		$password = $_POST['password'];
		$sql = mysqli_query($conn, "SELECT pwd FROM users where username = '$name'");
		$result = mysqli_fetch_array($sql);

		if($result = $password){
			$_SESSION[username] = $name;
			header("Location: action.php")

		}else{
			echo "incorrect password.";
		}

	}else{
		echo "username incorrect."
	}

	
}else{
	echo "Please enter username.";
}

$conn->close();

?>