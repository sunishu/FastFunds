<?php
  include_once 'dbConnect.php';
SESSION_start();

$username=$_SESSION['username']; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Campaigns</title>
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
    <h1>FastFunds</h1>      
    <p>Contribute to the awesome campaigns!</p>
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
      </ul>
      <ul class="nav navbar-nav navbar-right">

        <li>
        
        <a href="logout.php"><span class="glyphicon glyphicon-user"></span>Logout</a></li>
      </ul>
    </div>
  </div>
</nav>


<?php

	$sql = mysqli_query($conn, "SELECT avg(R.user_rating), P.pid, P.pname from rating R natural join FundsPledged F natural join projects P where R.username = '$username' and P.status = 'successful' groupby P.pid");

	while($query = mysqli_fetch_array($sql)){

	?>

	<p>
		
	<h6><?php echo "Project ID" .htmlspecialchars($query['pid']); echo "Project name" .htmlspecialchars($query['pname ']); echo "Project rating" .htmlspecialchars($query['user_rating ']); ?> </h6>
	$pid = $query['pid'];

	<h6> 
	<form action="" method="POST">
	<select name="rating">
  	<option value="1">1</option>
 	 <option value="2">2</option>
 	 <option value="3">3</option>
  	<option value="4">4</option>
	 <option value="5">5</option>
	</select></h6>

	<button type="submit" name="rate" >Rate!</button>


	</form>
	</p>


<?php

	if(isset($_POST['rate'])){

		$r = $_POST['rating'];

		$sql = mysqli_query($conn, "INSERT into rating VALUES ('$pid', '$username', '$r', 'now()')");

	}

}

?>

<footer class="container-fluid text-center">
  <p>FastFunds Copyright</p>
  </form>
</footer>

</body>
</html>

