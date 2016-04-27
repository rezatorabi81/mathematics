<!--This file retrive all submited calculation from database in database displays them inside a table-->

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<h3>Leaderboard</h3>

<div class="description">

<?php

//Loading mysql connetion parameters from file and establish connection
$config = parse_ini_file('config.ini'); 
$connection = mysqli_connect($config['address'],$config['username'],$config['password'],$config['dbname']);

if ($connection->connect_error) {
    die("Connection failed:");
}

//Selecting all submited calculation from database
$sql = "SELECT * FROM problem";

//Query database
$result = $connection->query($sql);
	if ($result->num_rows > 0) {
		
		
			echo "<table class='historytable'><tr><th>Problem ID</th><th>Test number</th><th>Test Answer</th><th>Total Run</th>";
				while($row = $result->fetch_assoc()) 
				{
					//Display found record as a row on table 
						   $record= array(
						   'problem_id' => $row['problem_id'],
						   'test_number' => $row['test_number'],
						   'test_answer' => $row['test_answer'],
						   'total_runs' => $row['total_runs']);
						   
						   echo "<tr><td>". $record['problem_id'] ."</td><td>". $record['test_number'] ."</td><td>". $record['test_answer'] ."</td><td>". $record['total_runs'] ."</td></tr>";
						   
				}
				echo "</table>";
	}
?>
</div>
</body>