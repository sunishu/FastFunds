<?php
	include_once 'dbConnect.php';

	SESSION_start();


?>

<!DOCTYPE html>
<html>
<head>
	<title>View Project!</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */ 
    .navbar {
      margin-bottom: 50px;
      border-radius: 0;
    }
    
    /* Remove the jumbotron's default bottom margin */ 
    .jumbotron {
      margin-bottom: 0;
    }
   
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }
  </style>
</head>
<body>




<?php 

	if(!empty($_POST['checkbox'])){
		$username = $_SESSION['username'];
		$pid = $_POST['checkbox'];
		$_SESSION['pid'] = $pid;
		echo $pid;
	

	$sql = mysqli_query($conn, "SELECT * from Projects natural join Multimedia where pid = '$pid'");
	$result = mysqli_fetch_assoc($sql);

	 while($query = mysqli_fetch_array($sql)){ ?> 

	 <?php
   

        $pid = $query['pid'];
        $pname = $query['pname'];
        $pdescription = $query['pdescription'];
        $mlink = $query['mlink'];
        $status = $query['status'];


      ?>

<div class="jumbotron">
  <div class="container text-center">
    <h1>FastFunds!</h1>      
    <p><b><font color=blue></font><?php echo htmlspecialchars("$pname"); ?></font></b></p>
    <p><?php echo "$pdescription"; ?></p>
    <p><?php echo htmlspecialchars("$status"); ?></p>
  </div>
</div>

<?php }  ?>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="allUsers.php">Users</a></li>
        <li><a href="userProjects.php">Your Projects</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span>Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<center>
	<!--This is a comment. Comments are not displayed in the browser
	<img src="<?//php echo "$result['mlink']"; ?>">
	<h6><?php //echo "Minimum Funds needed:" .htmlspecialchars($result['minfunds']); ?></h6>
	<h6><?php //echo "Maximum Funds needed:" .htmlspecialchars($result['maxfunds']); ?></h6>
	<h6><?php //echo "Campaing posted on:" .htmlspecialchars($result['camp_post_date']); ?></h6>
	<h6><?php //echo "Campaing end date:" .htmlspecialchars($result['camp_end_date']); ?></h6>
	<h6><?php //echo "The project finishes on:" .htmlspecialchars($result['pro_end_date']); ?></h6>
	<h6><?php //echo "Tag for this project:" .htmlspecialchars($result['tag']); ?></h6>
	<h6><?php //.htmlspecialchars($result['likes']) "people like this."; ?></h6> 
	-->

	<br>
	<br>
	<form action = "" method="POST">
	<label>"Enter the amount you wish to pledge:"</label>
	<input type="number" name="amount" required>
	<label>"Choose your credit card:"</label>
	<?php
			$sql = mysqli_query($conn, "SELECT ccn from CreditCard where username='$username'");
			while($sql_array = mysqli_fetch_array($sql)){
				$ccn = $sql_array['ccn'];

	?>
	<select name = "ccn" value = "$ccn"><?php echo "$ccn"; ?></select>
	<?php 	}
	?>
			
	<button type="submit" name="fund" value="fund">Fund!</button>

	</form>

	<?php

		if(isset($_POST['fund'])){

			$amount = $_POST['amount'];
			$ccn = $_POST['ccn'];

			$pledged = mysqli_query($conn, "INSERT into FundsPledged VALUES ('$username', '$pid', '$amount', '$ccn', 'now()')");

			$sql = mysqli_query($conn, "SELECT funds from FundsRaised where pid = '$pid'");
			$sql_array = mysqli_fetch_array($sql);
			$totalFunds = $sql_array['funds'];

			$totalFunds = $amount + $totalFunds;

			$raised = mysqli_query($conn, "INSERT into FundsRaised VALUES ('$pid', '$totalFunds')");

		}

	?>

</center>

<h3>Comments:</h3>

<?php
	
	$sql = mysqli_query($conn, "SELECT * from discussion where pid = '$pid' ");

	$commentCount = mysqli_num_rows($sql);
	if($commentCount = 0){

?>		
	<br><?php echo"No comments yet!"; }else{
	
		while ($sql_array = mysqli_fetch_array($sql)) {
		
?>
		<br><?php echo "Posted by: ".htmlspecialchars($sql_array['$username'])."at" .htmlspecialchars($sql_array['tcomment']); ?>
		<textarea rows = "5" cols="150"><?php echo htmlspecialchars($sql_array['comment']); ?></textarea>

<?php 
		} 
	}	
?>
	
	<form action="" method="POST">
	<br><br><label><b><font color=blue>YOUR COMMENT:</font></b></label>
	<input type="text" name="comment" placeholder="Enter your comment here." required>
	<button type="submit" name="postComment" value="comment">Post!</button>
	</form>

<?php
	
	if(isset($_POST['postComment'])){

		$id_query = mysqli_query($conn, "SELECT uuid()");
    	$id_array = mysqli_fetch_assoc($id_query);
    	$id = $id_array['uuid()'];

		//$sql = mysqli_query($conn, "INSERT into discussion VALUES ('$id', '$username', '$pid', 'now()', '$_POST['comment']')");

	}	

?>

</body>
</html>