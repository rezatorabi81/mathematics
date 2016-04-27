<?php	

/*This file contains all necessary codes to display a form for the selected function, recieve inputs for a new problem call other scripts to calculate the answer and display it to user*/


/*Check which function chosen by the user*/	
if (isset($_GET['id']))
{
	$functionid= $_GET['id'];
	
	/*Loading parameters for connecting to database */
	$config = parse_ini_file('config.ini'); 
	
	/*Select all attributes relate to chosen function*/
	$connection = mysqli_connect($config['address'],$config['username'],$config['password'],$config['dbname']);
	
	/*Connect to database and collect the data*/
	if ($connection->connect_error) {
		die("Connection failed:");
	}
	$sql = "SELECT * FROM function WHERE id='".$functionid."'";
	$result = $connection->query($sql);

	if ($result->num_rows > 0) {
		
		if($row = $result->fetch_assoc()) 
		{
			   $function= array(
				   'id' => $row['id'],
				   'name' => $row['name'],
				   'inputs' => $row['inputs'],
				   'Jscript_path' => $row['Jscript_path'],
				   'PHP_path' => $row['PHP_path'],
				   'description' => $row['description'],
				);
		}
	} 
	
	/*Display the name of the function in header*/	
			echo "<h3>" .$function['name']. "</h3>";
			
			/*Function form*/	
			echo "<div class=\"description\">";
			echo $function['description'];
			echo "</div>";
			echo "<fieldset>"; 
			echo		"<table>";
			echo		"<tr>";
			echo			"<td><p class=\"label1\" > <label  >Enter input(s):</label></p> </td>";
			
			/*Making necessary textfields for inputs*/	
			if($function['inputs']>1)$txtboxclass="smallTxtBox";
			else $txtboxclass="largTxtBox";
				
			echo "<td><p>";
			for($i=0;$i<$function['inputs'];$i++)
			{

				echo "<input class=\"".$txtboxclass."\" type=\"text\" id=\"input" .($i+1)."\">";
				if($i+1<$function['inputs'])echo " - ";
			}
			echo "</p></td>";
			
			echo		"</tr>";
			echo		"<tr>";
			
			/*Calculation button*/	
			
			echo			"<td><p class=\"label1\" > <button id=\"btm\">Calculate</button> </p></td>";
			if($function['PHP_path']!=null)
			{
				echo			"<td ><input type=\"checkbox\" id=\"serverside\"> Calculate at server</td>";			
			}
			
			/*Labales for displaying answer, time, total runs and errors*/	
			
			echo	'<tr>
					</table>
					<p class="label2" > <label id="answer" ></label></p>
					<p class="label2" > <label id="time" ></label></p>
					<p class="label2" > <label id="totalruns" ></label></p>
					<p class="error" > <label id="error" ></label></p>
				</fieldset>';
			
			/*Loading function's javascript file*/	
			echo "<script src=\"commonscripts.js\"> </script>";
			echo "<script src=\"./functions/" .$function['Jscript_path']. "\"> </script>";
			echo "<script type=\"text/javascript\">";
			
			
			
			echo  "var button= document.getElementById('btm');";
			
			/*On submite calculation button*/	
			echo "button.onclick= function ()";
			
			/*making JS variables for inputs*/	
			echo "{";
				for($i=0;$i<$function['inputs'];$i++)
				{		
					echo "testInput" .($i+1). "=document.getElementById('input".($i+1)."').value;";
				}
				
				/*Clean all fields*/	
				echo "clearfields();";
				
				echo "document.getElementById('answer').innerHTML = \"</br>Please wait....\";";
				
				/*If the problem will be calculated on client side:*/
				echo "if(!document.getElementById(\"serverside\").checked)";
				echo "{";
						echo "var testAnswer=0;";
						/*Trigger function for calling the calculate function on function's javascript file*/
						echo "function trigger () {";
						
							echo "var startTime= new Date();";	
							/*calling calculating function and get the answer*/
							echo "testAnswer=calculate(";
							for($i=0;$i<$function['inputs'];$i++)
							{		
								echo "testInput".($i+1);
								if($i+1<$function['inputs'])
								echo ",";
							}
							echo ");";
							echo "var finishTime= new Date();";
						/*Display the results*/
						
						echo "document.getElementById('answer').innerHTML = '</br>The answer is: <b>'+ testAnswer+ '</b>' ;";
						echo "document.getElementById('time').innerHTML = 'Total calculation time: <b>'+ (finishTime -startTime)/1000 + '</b>s';";
						
						
						/*Prepare vaules for inserting or updating the record of the problem*/
						if($function['inputs']>1)
						{
							echo "var testInputs=[";
									for($i=0;$i<$function['inputs'];$i++)
									{		
										echo "testInput".($i+1);
										if($i+1<$function['inputs'])
										echo ",";
									}
							echo "];";
							/*updating the record of the problem in database*/
							echo "updatedb(".$function['id'].",testInputs,testAnswer);";
						}
						else echo "updatedb(".$function['id'].",testInput1,testAnswer);";
						echo "}";
						
						/*Validate values before calculating*/
						echo "var validback = validate(";
							for($i=0;$i<$function['inputs'];$i++)
							{		
								echo "testInput".($i+1);
								if($i+1<$function['inputs'])
								echo ",";
							}
							echo ");";
							/*If values were valid call the trigger function*/
						echo "if(validback==\"ok\")setTimeout(trigger,50);";
						echo "else {";
							echo "clearfields();";
							/*Display error if values were not valid*/
							echo "document.getElementById(\"error\").innerHTML=validback;";
						echo "}";
				echo "}";
				
				/*If the problem will be calculated on server side:*/
				echo "else";
					echo "{";
					/*validate values*/
							echo "var validback = validate(";
							for($i=0;$i<$function['inputs'];$i++)
							{		
								echo "testInput".($i+1);
								if($i+1<$function['inputs'])
								echo ",";
							}
							echo ");";
						echo "if(validback==\"ok\")";
						echo "{";	
						if($function['inputs']>1)
						{
							echo "var testInputs=[";
									for($i=0;$i<$function['inputs'];$i++)
									{		
										echo "testInput".($i+1);
										if($i+1<$function['inputs'])
										echo ",";
									}
							echo "];";
							/*(for multiple value problems)Call serversidecalc function for sending value to server side calculate the answer*/
						echo "serversidecalc(".$function['id'].",testInputs,\"" .$function['PHP_path']."\");";
						}
						/*(for single value problems)Call serversidecalc function for sending value to server side calculate the answer*/
						else echo "serversidecalc(".$function['id'].",testInput1,\"" .$function['PHP_path']."\");";
						echo "}";
						echo "else {";
							echo "clearfields();";
							echo "document.getElementById(\"error\").innerHTML=validback;";
						echo "}";
					echo "}";
			echo "}";
			echo "</script>";
}
?>