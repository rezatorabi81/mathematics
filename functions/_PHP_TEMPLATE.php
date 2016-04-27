<?php

/*reieving inputs*/
$input=$_POST['input'];


/*This statements is necessary to avoid any problem on servers with Magic Quotes plug in*/
if(get_magic_quotes_gpc()){
  $input = stripslashes($_POST['input']);
}else{
  $input=$_POST['input'];
}
/*This line will convert input object into JSON format*/
$input= json_decode( $input,true);



/*The calculating function can be anyname and it must return a value back*/
function aMathematicalfunction($input)
{
	return $value
}

/*This line will call the calculating function if any value was posted to the page */
if(isset($input))
{	
	/*the answer will echo back to calling function*/
	echo aMathematicalfunction($input[0],$input[1],$input[n]);
}
else "enter inputs.";

?>