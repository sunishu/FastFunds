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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<title>Post a campaign!</title>
</head>
<body>
	<form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
	<div class="form-group">
    <label class="control-label col-sm-2" for="pname">Campaign name:</label>
    <div class="col-sm-10"> 
      <input type="text" class="form-control" id="pname" placeholder="Enter campaign name." required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="pdescription">Campaign description:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="pdescription" placeholder="Enter campaign description." required>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="multimedia">Upload Photos:</label>
    <div class="col-sm-10">
      <input type="file" name="fileToUpload" class="form-control" id="multimedia" required>
    </div>
  </div>
<div class="form-group">
    <label class="control-label col-sm-2" for="minfunds">Minimum funds needed:</label>
    <div class="col-sm-10">
      <input type="number" pattern="[0-9]+([\.,][0-9])?" step="0.01" class="form-control" id="minfunds" placeholder="Enter minimum funds to qualify." required>
    </div>
  </div>
 <div class="form-group">
    <label class="control-label col-sm-2" for="maxfunds">Maximum funds needed:</label>
    <div class="col-sm-10">
      <input type="number" pattern="[0-9]+([\.,][0-9])?" step="0.01" class="form-control" id="maxfunds" placeholder="Enter maximum funds needed." required>
    </div>
  </div> 
 <div class="form-group">
    <label class="control-label col-sm-2" for="camp_enddate">The last date for campaigning is:</label>
    <div class="col-sm-10">
      <input type="datetime-local" class="form-control" id="camp_enddate" placeholder="Enter the campaign end date.(YYYY-MM-DD hh:mm:ss)" required>
    </div>
  </div>  
  <div class="form-group">
    <label class="control-label col-sm-2" for="pro_end_date">This project will be completed by:</label>
    <div class="col-sm-10">
      <input type="datetime-local" class="form-control" id="pro_end_date" placeholder="Enter the project's end date.(YYYY-MM-DD hh:mm:ss)" required>
    </div>
  </div>
  <div class="form-group">
  
   <div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Status
  <span class="caret"></span></button>
  <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
    <li role="presentation" selected disabled>Accepting Funds</li>
  </ul>
  </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="tag">Tag:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="tag" placeholder="Enter one appropriate tag." required>
    </div>
  </div>

  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default" value="submit">Submit</button>
    </div>
  </div>
 	
 <?php

 		$pname = $_POST['pname'];
 		$pdescription = $_POST['pdescription'];
 		$multimedia = $_POST['fileToUpload'];
 		$name = $_POST['name'];
 		$minfunds = $_POST['minfunds'];
 		$maxfunds = $_POST['maxfunds'];
 		$camp_enddate = $_POST['camp_enddate'];
 		$pro_end_date = $_POST['pro_end_date'];
 		$tag = $_POST['tag'];

 		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES['$multimedia']['$name']);
		$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
		if(isset($_POST["submit"])) {
   			 $check = getimagesize($_FILES['$multimedia']['$name']);
   			 if($check !== false) {
    	     	move_uploaded_file($_FILES['$multimedia']['$name'], $target_file)
        	}
		}

 		$sql = "INSERT into Projects VALUES ('', '$_SESSION['username']', '$pname', 'pdescription', '', '$minfunds', '$maxfunds', 'camp_enddate', 'now()', '$pro_end_date', 'accepting funds', '$tag', '0')";

 		mysqli_query($conn, $sql);

 		header("Location: congrats.php");

   ?>
</body>
</html>