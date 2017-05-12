<?php
	include_once 'dbConnect.php';
	
SESSION_start();

$username=$_SESSION['username']; 


  ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<title>
		What do you want to do today?
	</title>

</head>
<body>
	<form action="projects.php" method="POST"> 
	<button type="submit" value="submit"> Fund a campaign.</button>
	</form>
	<form action="post.php" method="POST">
	<button type="submit" value="submit"> Post a new campaign.</button>
	</form>

	<?php
		$sql1 ="select * from Users natural join Followers f where followername ='$username'";



		$result1 = mysqli_query($conn, $sql1);

   		  while($row = mysqli_fetch_array($result1)) {
		   
		   echo "<br>";
		    echo "<b>";
		    echo htmlspecialchars($row["name"]). "<br>";		    
		    echo htmlspecialchars($row["city"]). "<br>";
		    echo htmlspecialchars($row["state"]). "<br>";
		    $u = $row["username"];

		    $sql3 ="select * from Projects where username='$u'";

		    echo "$username";
		    echo "$u";
			$result3 = mysqli_query($conn, $sql3);

			while($row3 = mysqli_fetch_array($result3)) {
		   
		  	 echo "<br>";"<br>"; "<br>"; "<br>";"<br>";

		    echo "<b>";
		    echo htmlspecialchars($row3["pname"]). "<br>";	    
		    echo htmlspecialchars($row3["pdescription"]). "<br>";
		    echo htmlspecialchars($row3["status"]). "<br>";
		    echo htmlspecialchars($row3["tag"]). "<br>";
		    echo htmlspecialchars($row3["likes"]). "<br>";




		    echo "</b>";
		   }


   		   }

	?>
	

</body>
</html>