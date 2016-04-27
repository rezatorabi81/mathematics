<?php
$input=$_POST['input'];

if(get_magic_quotes_gpc()){
  $input = stripslashes($_POST['input']);
}else{
  $input=$_POST['input'];
}
$input= json_decode( $input,true);


function gcd($x, $y) {
	if ($y==0) {

		return $x;
	}

	return gcd($y, fmod($x, $y));
}

function lcm($x,$y)
{
	return ($x*$y) / gcd($x,$y);
	usleep(1);
	
}

function smallestMultiple($n1,$n2)
{
	$max=0;
	$min=0;
	if($n1>$n2){$max=$n1; $min=$n2;}
	else {$max=$n2; $min=$n1;}
	$smlmltp = $min;

	for($s=$min;$s<=$max;$s++)
	{
		$smlmltp = lcm($s,$smlmltp);

	}
	return $smlmltp;
}

if(isset($input))
{
	echo smallestMultiple($input[0],$input[1]);
}

?>