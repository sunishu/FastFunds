<?php
	include_once 'dbConnect.php';

	SESSION_start();

	$username = $_SESSION['username'];

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<title>FastFunds Users</title>
</head>
<body>

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






<h4><b><font color=red>Here are our valued Users!!</font></b></h4>
<?php
	$sql = mysqli_query($conn, "SELECT * FROM USERS where username NOT IN('$username')");

	while($result = mysqli_fetch_array($sql)){

		$user = htmlspecialchars($result['username']);
		$name = htmlspecialchars($result['name']);
		$city = htmlspecialchars($result['city']);
		$state = htmlspecialchars($result['state']);
		$email = htmlspecialchars($result['email']);

		 $query1 = mysqli_query($conn2, "SELECT count(followername) from FOLLOWERS where username = '$username'");
		 $query1a = mysqli_fetch_assoc($query1);
		 $countFollowers = $query1a['count(followername)'];

		 $query2 = mysqli_query($conn, "SELECT count(username) from FOLLOWERS where followername = '$username'");
		 $query2a = mysqli_fetch_assoc($query2);
		 $countFollowing = $query2a['count(username)'];
	?>

		<div class="container">
		<div class="row login_box">
	    <div class="col-md-12 col-xs-12" align="center">
            <div class="outter"><i class="glyphicon glyphicon-user"></i></div>   
            <h1><?php echo"$name"; ?></h1>
	    </div>
        <div class="col-md-6 col-xs-6 follow line" align="center">
            <h3>
                <?php echo "$countFollowing"; ?> 
                <br/> <span>FOLLOWS</span>
            </h3>
        </div>
        <div class="col-md-6 col-xs-6 follow line" align="center">
            <h3>
                <?php echo "$countFollowers"; ?> 
                <br/> <span>FOLLOWERS</span>
            </h3>
        </div>
        
        <div class="col-md-12 col-xs-12 login_control">
                
                <div class="control">
                    <div class="outter"><i class="glyphicon glyphicon-envelope"></i>Email Address</div>
                    <span><?php echo "$email"; ?></span>
                </div>
                
                <div class="control">
                    <div class="outter"><i class="glyphicon glyphicon-map-marker">
                        </i>From</div>
                        <span><?php echo "$city"; echo ", "; echo "$state"; ?></span>
                </div>
                <div align="center">
                	<form action="" method="POST">
                	<input type="hidden" name="user" value="<?php echo "$user"; ?>" />
                    <button class="btn btn-orange" name="submit" value="submit">FOLLOW</button>
                    </form>
                </div>
                
        </div>

	<?php } 

	if(isset($_POST['submit'])){

		$user = $_POST['user'];

		$sql = "INSERT into followers VALUES ('$user', '$username')";
		mysqli_query($conn, $sql);

	}


?>


<footer class="container-fluid text-center">
  <p>FastFunds Copyright</p>
  </form>
</footer>

</body>
</html>