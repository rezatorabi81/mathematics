<?php
/*This file contains all necessary codes for adding a new function to the web site */


/*Checking if  values were submited by posting. If yes, the values are copied into the variable to validate and the store in database. */
	if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['inputs']) && isset($_FILES['jsfile']))
	{
		/*Storing posted data into variables, including file data*/
		$name = $_POST['name'];
		$inputs=$_POST['inputs'];
		$description=$_POST['description'];
		$jsfilename=$_FILES['jsfile']['name'];
		$jsfile=$_FILES['jsfile'];
		$phpfilename = $_FILES['phpfile']['name'];
		$phpfile=$_FILES['phpfile'];
		
		$error=null;
		
		/*Check if javascript file and php file both are exist*/
		if(!empty($jsfilename) && !empty($phpfilename))
		{
			/*uploading js file*/
			if(!fileupload($jsfile,"js"))			
				exit;
			
			/*uploading php file*/
			if(!fileupload($phpfile,"php"))
				exit;
		}
		/*php file is optional. if it was not exisit this statement make sure at least javascript file exisit*/
		else if (!empty($jsfilename))
			{
				/*uploading js file*/
				if(!fileupload($jsfilename,"js"))
				exit;
			}
		else exit; /*If none of javascript or php file were exist exit from here.*/
			
		/*if uploading of file(s) were sucessfull, the attribute of the new function including its name, description , number of inputs and script names are stored in database*/
		$config = parse_ini_file('config.ini'); 
		$connection = mysqli_connect($config['address'],$config['username'],$config['password'],$config['dbname']);
			
			if ($connection->connect_error) {
				die("Connection failed:");
			}

			$sql = "INSERT INTO function (name, inputs, Jscript_path, PHP_path, description) VALUES( '".$name."','".$inputs."','".$jsfilename."','".$phpfilename."','".$description."')";


			if ($connection->query($sql) === TRUE) {
				
				echo "<h3> Function '".$name."' added to the system successfully! </h3>";
				echo "<p class=\"description\">Please go to home page now so navigation bar updates with new the function.<p>";
				
			} else {
				echo "Error: " . $sql . "<br>" . $connection->error;
		}
		
	}
	
/*Submition form. Will be displayed only if noting was posted to the page*/
else 
{
echo '
<h3>New function</h3>
<div class="description">  
	  <table>
	  <tr>
	  <td>
      <form action="" name="addform" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data">
         <table>
		 <tr>
			 <td><p class="label1" > <label  >Name </label> </p> </td>
			 <td><input class="largTxtBox" type="text" name="name" /></td>
		 </tr>
		 <tr>
		 <tr>
			 <td><p class="label1" > <label>Number of inputs </label> </p> </td>
			 <td><input class="smallTxtBox" type="text" name="inputs" /></td>
		 </tr>
		 <tr>
			<td><p class="label1" > <label  >Description </label> </p></td>
			<td colspan="2"><textarea rows="5" cols="40" name="description" /></textarea>
			</td>
		 </tr>
		 <tr>
			<td><p class="label1" > <label  >JScript File </label> </p>
			</td>
			<td><input type="file" name="jsfile" /></td>
		 </tr>
		 	<tr>
			<td><p class="label1" > <label  >PHP File </label> </p>
			</td>
			<td><input type="file" name="phpfile" /></td>
			<td><p>(optional)</p></td>
		</tr>
		</tr>
		<tr>
			<td>

			</td>
			<td>	
		
			</td>
			<td>
							</br>
				<input type="submit" value="Submit"/>	

			</td>
		 </tr>
			
		 </table>
		 
      </form>
	  </td>
	  <td>
      <p class="error" > <label id="error" ></label></p>	
	  </td>
	  </table>
   </div>';
}

/*Will upload script and php file into function directory*/
	function fileupload($file,$expensions)
		{
		  $errors=null;
		  $file_name = $file['name'];
		  $file_size =$file['size'];
		  $file_tmp =$file['tmp_name'];
		  $file_type=$file['type'];
		  $file_ext=strtolower(end(explode('.',$file['name'])));
		  
		  if($file_ext!=$expensions){
			 $errors="extension not allowed, please choose a *." .$expensions." file</b>";
		  }
		  
		  if($file_size > 102400){
			 $errors+='File size must be less than 100kb</b>';
		  }
		  
		  if(empty($errors)==true){
				 try
				 {
					move_uploaded_file($file_tmp,"functions/".$file_name);
					return true;
				 }
				catch (Exception $e) {
					echo  $e->getMessage(), "\n";
					return false;
				}
			}else{
			echo $errors;
			 return false;
		  }
			
		}
	


 ?>

<script type="text/javascript">


/*Will validate inputs before submition*/
function validateForm() {
    var name = document.forms["addform"]["name"].value;
	var inputs = document.forms["addform"]["inputs"].value;
	var jsfile = document.forms["addform"]["jsfile"].value;
	var phpfile = document.forms["addform"]["phpfile"].value;
	var description = document.forms["addform"]["description"].value;
	var error = document.getElementById("error");
	error.innerHTML="";
    var valid=true;
	if (name == null || name == "") {
        error.innerHTML+="* Name must be filled out</br>";
        valid=false;
    }
	if (description == null || description == "") {
        error.innerHTML+="* Description must be filled out</br>";
        valid=false;
    }
	if (jsfile == null || jsfile == "") {
        error.innerHTML+="* Plase choose a Java Script file for this function</br>";
        valid=false;
    }
	if (inputs == null || inputs == "") {
        error.innerHTML+="* inputs must be filled out</br>";
        valid=false;
    }
	else if (parseInt(inputs) > 10 || 1 > parseInt(inputs)) 
	{
		error.innerHTML+="* inputs must be between 1 to 10</br>";
        valid=false;
	}
	if(valid==false)return false;

}
</script>
