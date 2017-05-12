<?php
include_once 'dbConnect.php';

SESSION_start();
$_SESSION["timeout"] = time();


if(empty($_POST['username']) || empty($_POST['password'])){
	$error = "Both the fields are required.";
}

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$sql = mysqli_query($conn, "SELECT username from users where username = '$username' and pwd = '$password'");
$sql_array = mysqli_fetch_assoc($sql);
$username = $sql_array['username'];

$rowCount = mysqli_num_rows($sql);

if($rowCount == 1){
	$_SESSION['username'] = $username;

	header("Location: action.php");
}else{

	echo "Incorrect username or password.";

}


if((time() - $_SESSION["timeout"]) > 100){ 
    unset($_SESSION["timeout"]);
}

?>