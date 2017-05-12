<?php
	include_once 'dbConnect.php';
SESSION_start();

$username=$_SESSION['username']; 

  ?>

  <!DOCTYPE html>
  <html>
  <head>
  	<title>hi!</title>
  </head>
  <body>
  		Hi<?php echo "$username"; ?>
  </body>
  </html>