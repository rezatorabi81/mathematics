

<?php
/*This file create or update a record on database for given problem and return the total_runs value*/


/*Problem parameters*/
$problem_id = $_POST['problem_id'];
$test_number = $_POST['test_number'];
$test_answer = $_POST['test_answer'];

/*Loading connection parameters from config file and make sql connection*/

$config = parse_ini_file('config.ini'); 
$connection = mysqli_connect($config['address'],$config['username'],$config['password'],$config['dbname']);

if ($connection->connect_error) {
    die("Connection failed:");
}

/*Select the row which has problem_id and test_number match to given values*/
$sql = "SELECT * FROM problem WHERE problem_id= '".$problem_id."' AND test_number = '".$test_number."' ";

$result = $connection->query($sql);

		if ($result->num_rows > 0) {
			
			if($row = $result->fetch_assoc()) 
			{
				   $record= array(
					   'problem_id' => $row['problem_id'],
					   'test_number' => $row['test_number'],
					   'test_answer' => $row['test_answer'],
					   'total_runs' => $row['total_runs']
					);
		/*If record was exist totat_runs will increased by one and record will return to the calling funtion */					
					$record['total_runs']=$record['total_runs']+1;
					$record['total_runs']=strval($record['total_runs'])	;
				   $sql_update="UPDATE problem SET total_runs='".$record['total_runs']."' 
								WHERE problem_id= '".$record['problem_id']."' 
								AND test_number= '".$record['test_number']."' ";
								
					if(mysqli_query($connection, $sql_update)){
						echo json_encode($record);
					} else {
						echo  mysqli_error($connection);
					}	
			}
		} 
		
		/*If record was not exist, a new record with given parameters will be added to database and return to the calling funtion with total_runs of 1*/		
		else 
			{
				$sql_insert = "INSERT INTO problem (problem_id, test_number, test_answer,total_runs)
				VALUES ('$problem_id', '$test_number', '$test_answer',1)";
				if ($connection->query($sql_insert) === TRUE) {
					$record= array(
					   'problem_id' => $problem_id,
					   'test_number' => $test_number,
					   'test_answer' => $test_answer,
					   'total_runs' => 1
					);
					$record['total_runs']=strval($record['total_runs'])	;
					echo json_encode($record);
				} else {
					echo $connection->error;
				}
				
			}
		/*closing connection*/	
		$connection->close();; 
?>
<?php exit; ?> 