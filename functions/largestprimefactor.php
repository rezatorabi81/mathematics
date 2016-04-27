<?php
$input=$_POST['input'];

if(get_magic_quotes_gpc()){
  $input = stripslashes($_POST['input']);
}else{
  $input=$_POST['input'];
}
$input= json_decode( $input,true);


function primeFactor($n)
{
	for($i=2;$i<$n;$i++)
	{
		if($n%$i==0)
		{
			$n/=$i;
			$i--;
		}
		
	}
	return $i;
}

if(isset($input))
{
	echo primeFactor($input);
}
else "enter inputs.";

?>