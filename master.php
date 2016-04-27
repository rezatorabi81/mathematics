<!-- This file is used as a template for all other pages -->
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

	<!-- Main header -->

	<header>
		<p>Simple Mathematical helper</p>
	</header>
	<!-- Navigation bar -->

	<nav>
	<ul>
	  <li><a class="active" href="index.php">Home</a></li>
	  <li class="dropdown"><a href="#" class="dropbtn">Functions</a>
		<div id="functionmenu" class="dropdown-content">
		<?php 
			$config = parse_ini_file('config.ini'); 
			$connection = mysqli_connect($config['address'],$config['username'],$config['password'],$config['dbname']);

			if ($connection->connect_error) {
				die("Connection failed:");
			}
			$sql = "SELECT id,name FROM function";
			$result = $connection->query($sql);

			if ($result->num_rows > 0) {
				
				while($row = $result->fetch_assoc()) 
				{
					   $record= array(
						   'name' => $row['name']
						);
							echo "<a href=\"master.php?page=problem_content.php&id=".$row['id']. "\">" .$row['name']. "</a>";	
				}
			} 			
			?>
		</div>
	  </li>
	  <?php 
	  echo "<li><a href=\"master.php?page=leaderboard_content.php\">Leaderboard</a></li>";
	  echo "<li><a href=\"master.php?page=admin_content.php\">Admin Panel</a></li>";
	  ?>
	</ul>
	</nav>

	<!-- this is the main content section -->	
	<section class="main">

	
		<?php 
		if(isset($_GET['page']))
		{
			$page = $_GET['page'];
				if (!empty($page)) 
					include($page);
			
		}
		?>	
	</section>
		

	<!-- Footer -->
	<footer>
		<p>Copyright 2016 by Reza Torabi. All Rights Reserved.</p>
	</footer>
</body>

<?php exit; ?> 