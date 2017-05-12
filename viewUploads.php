<?php
	include_once 'dbConnect.php';

	SESSION_start();

	$username = $_SESSION['username'];
	$pid = $_SESSION['cpid'];


?>

<!DOCTYPE html>
<html>
<head>
	<title>View multimedia!</title>
</head>
<body>

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

	$sql = mysqli_query($conn, "SELECT * from multimedia where pid = '$pid' ");

	while($row = mysqli_fetch_array($sql)){

?>

	<p>
		<input type="image" src="<?php echo "$row['mlink']"; ?>" class="img-responsive" style="width:100%" alt="Submit" name="mlink">

	</p>



<?php
	}

?>


<footer class="container-fluid text-center">
  <p>FastFunds Copyright</p>
  </form>
</footer>

</body>
</html>