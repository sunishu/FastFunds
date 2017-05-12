<?php
	include_once 'dbConnect.php';

	SESSION_start();

	$username = $_SESSION['username'];


?>

<!DOCTYPE html>
<html>
<head>
	<title>Search Result</title>
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

      	<form action="search.php" method="POST">
          <li><input type="text" name="search" id="search" placeholder="search" required><a href="search.php"><span class="glyphicon glyphicon-search"></span>Search</a></li>
        </form>
        <li>
        <a href="logout.php"><span class="glyphicon glyphicon-user"></span>Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<?php

	if(!empty($_POST['search'])){


		$search = mysqli_real_escape_string($conn, $_POST['search']);
		$sql = mysqli_query($conn, "SELECT p.pid,p.pname, p.pdescription,m.mlink from Projects p natural Join multimedia m where pname LIKE '%$search%' OR pdescription LIKE '%$search%' OR tag LIKE '%$search%'");

		$noResults = mysqli_num_rows($sql);

		if($noResults>0){

			while($query = mysqli_fetch_array($sql)){

				$pid = $query['pid'];
       			$pname = $query['pname'];
        		$pdescription = $query['pdescription'];
       			$mlink = $query['mlink'];

				?>

			<div class="panel-heading"><?php echo "$pname"; ?></div>
        <div class="panel-body">

<form action="showProject.php" method='GET'>
  <input type="image" src="<?php echo "$mlink"; ?>" name = "link" value = "<?php echo "$pid"; ?>" class="img-responsive" style="width:100%" alt="Submit" name="mlink">
  </div>
</form>

        
        <div class="panel-footer"><?php echo "$pdescription"; ?></div>
  
      </div>
    </div>


<?php
			}

		}else{

			echo "No matching results found!";

		}



	}


?>

</body>


</body>
</html>