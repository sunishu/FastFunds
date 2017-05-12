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
        <li class="active"><a href="projects.php">Home</a></li>
        <li><a href="allUsers.php">Users</a></li>
        <li><a href="userProjects.php">Your Projects</a></li>
        <li><a href="rateProjects.php">Rate Projects</a></li>
        <li><a href="recommendations.php">Your Recommendations</a></li>
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
	<h6><?php  $sql = mysqli_query($conn, "SELECT funds from FundsRaised where pid = '$pid'");
			   $sql_array = mysqli_fetch_array($sql);
			   $totalFunds = $sql_array['funds'];
			   echo "Funds raised until now:" .htmlspecialchars($totalFunds);
			   ?></h6>
	<h6><?php htmlspecialchars($query['likes']) ."people like this."; ?></h6> 
	</b>

<?php } } 

?>

	<br>
	<br>
	<form action = "" method="POST">
	<label>"Do you wish to pledge for your own project:"</label>
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
			$totalFunds = $totalFunds+$amount;

			$raised = mysqli_query($conn, "INSERT into FundsRaised VALUES ('$pid', '$totalFunds')");

		}

	?>

</center>

<center>
	
	<h3>
	Upload more multimedia:
	<form action = "" method="POST" enctype="multipart/form-data">
	<div class="form-group">
    <label class="control-label col-sm-2" for="multimedia">Upload Photos:</label>
    <div class="col-sm-10">
      <input type="file" name="fileToUpload" class="form-control" id="multimedia" required>
    </div>
  </div>
  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default" name="Upload" value="submit">Upload</button>
    </div>
  </div>

  </form>

</h3>

<?php


	if(isset($_POST['Upload'])){

		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES['fileToUpload']['name']);

		if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
              echo "Upload Complete.";
          }


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

			$cid = $sql_array['cid'];
		
?>
		<br><?php echo "Posted by: ".htmlspecialchars($username)."at" .htmlspecialchars($sql_array['tcomment']); ?>
		<textarea rows = "5" cols="150"><?php echo htmlspecialchars($sql_array['comment']); ?></textarea>


		<form>
			<button type="submit" name="deleteComment" value="<?php echo "$cid"; ?>">Delete!</button>
		</form>

<?php 
		} 
?>

<?php 
	}	

	if(isset($_POST['deleteComment'])){

		$cid = $_POST['deleteComment'];

		$delComment = mysqli_query($conn, "DELETE from Discussion where cid = '$cid' ");


	}


?>

<footer class="container-fluid text-center">
  <p>FastFunds Copyright</p>
  </form>
</footer>


</body>
</html>