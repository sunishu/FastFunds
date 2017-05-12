<?php
	include_once 'dbConnect.php';

	SESSION_start();

	$username = $_SESSION['username'];


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

<div class="jumbotron">
  <div class="container text-center">
    <h1>FastFunds!</h1>     
  </div>
</div>

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

        <li>
        
        <a href="logout.php"><span class="glyphicon glyphicon-user"></span>Logout</a></li>
      </ul>
    </div>
  </div>
</nav>


<?php 

	if(!empty($_GET['link'])){
		$_SESSION['pid'] = $_GET['link'];
		$pid = $_SESSION['pid'];

	$sql = mysqli_query($conn, "SELECT * from Projects natural join Multimedia where pid = '$pid'");

	 while($query = mysqli_fetch_array($sql)){ 

        $pname = $query['pname'];
        $pdescription = $query['pdescription'];
        $mlink = $query['mlink'];
        $status = $query['status'];

?>

<center>
	
	<img src="<?php echo "$mlink"; ?>">
	<b>
    <p><b><font color=blue></font><?php echo htmlspecialchars("$pname"); ?></font></b></p>
    <p><?php echo "$pdescription"; ?></p>
    <p><?php echo htmlspecialchars("$status"); ?>
    </p>
	<h6><?php echo "Minimum Funds needed:" .htmlspecialchars($query['minfunds']); ?></h6>
	<h6><?php echo "Maximum Funds needed:" .htmlspecialchars($query['maxfunds']); ?></h6>
	<h6><?php echo "Campaign posted on:" .htmlspecialchars($query['pro_post_date']); ?></h6>
	<h6><?php echo "Campaign end date:" .htmlspecialchars($query['camp_end_date']); ?></h6>
	<h6><?php echo "The project finishes on:" .htmlspecialchars($query['pro_end_date']); ?></h6>
	<h6><?php echo "Tag for this project:" .htmlspecialchars($query['tag']); ?></h6>
	<h6><?php htmlspecialchars($query['likes']) ."people like this."; ?></h6> 
	</b>

<?php } } 

?>




<?php

	$pid = $_SESSION['pid'];	

	$sql = mysqli_query($conn, "SELECT likes from Projects where pid = '$pid' ");
	$sql_array = mysqli_fetch_array($sql);
	$totalLikes = $sql_array['likes'];

	echo "$totalLikes people like this.";

	if(isset($_POST['postLike'])){

		$pid = $_SESSION['pid'];


		$sql_array = mysqli_query($conn, " UPDATE Projects set likes = '$totalLikes' + 1  where pid = '$pid' ");

	}

?>


<center>
	
<form action="" method="POST">
<button type="submit" name="postLike" onClick="this.disabled = true">Like it!</button>

</form>

</center>

	<br>
	<br>
	<form action = "" method="POST">
	<label>"Enter the amount you wish to pledge:"</label>
	<input type="number" name="amount" required>

			
	<button type="submit" name="fund" value="fund">Fund!</button>

	</form>

	<?php

		if(isset($_POST['fund'])){

			$amount = $_POST['amount'];

			$pid = $_SESSION['pid'];
			
			$ccnquery = mysqli_query($conn, "SELECT ccn from Creditcard where username = '$username'");
			$ccn_array = mysqli_fetch_array($ccnquery);
			$ccn = $ccn_array['ccn'];

			$pledged = mysqli_query($conn, "INSERT into fundspledged VALUES ('$username', '$pid', '$amount', '$ccn', now())");

			$sql = mysqli_query($conn, "SELECT funds from FundsRaised where pid = '$pid'");
			$sql_array = mysqli_fetch_array($sql);
			$totalFunds = $sql_array['funds'];

			$raised = mysqli_query($conn, "INSERT into FundsRaised VALUES ('$pid', '$totalFunds +$amount')");

		}

	?>

</center>

<h3>Comments:</h3>

<?php
	
	$pid = $_SESSION['pid'];

	$sql = mysqli_query($conn, "SELECT * from discussion where pid = '$pid' ");

	$commentCount = mysqli_num_rows($sql);
	if($commentCount = 0){

?>		
	<br><?php echo"No comments yet!"; }else{
	
		while ($sql_array = mysqli_fetch_array($sql)) {
		
?>
		<br><?php echo "Posted by: ".htmlspecialchars($username)."at" .htmlspecialchars($sql_array['tcomment']); ?>
		<textarea rows = "5" cols="150"><?php echo htmlspecialchars($sql_array['comment']); ?></textarea>

<?php 
		} 
	}	
?>
	
	<form action="" method="POST">
	<br><br><label><b><font color=blue>YOUR COMMENT:</font></b></label>
	<input type="text" name="userComment" placeholder="Enter your comment here." required>
	<button type="submit" name="postComment" >Post!</button>
	</form>

<?php
	
	if(isset($_POST['postComment'])){

		$pid = $_SESSION['pid'];

		$id_query = mysqli_query($conn, "SELECT uuid()");
    	$id_array = mysqli_fetch_assoc($id_query);
    	$id = $id_array['uuid()'];

    	$comment = $_POST['userComment'];

    	echo "$id";
    	echo "$username";
    	echo "$pid";
    	echo "$comment";

		$sql = mysqli_query($conn, "INSERT into Discussion VALUES ('$id', '$username', '$pid', 'now()', '$comment')");

	}	

?>



</body>
</html>