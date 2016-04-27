<?php
$input=$_POST['input'];

if(get_magic_quotes_gpc()){
  $input = stripslashes($_POST['input']);
}else{
  $input=$_POST['input'];
}
$input= json_decode( $input,true);


function IsPalindrom($str)
{
	$mid =0;
	$len = strlen($str);
	
	if($len%2==0)$mid = $len/2;
	else $mid = ($len-1)/2;
	
	for($k=1;$k<=$mid;$k++)
	{
		if($str[$k-1]!=$str[$len-$k])
		{	
		return -1;	
		}
	}
	
	return 0;
}

function LargestPalindromeProduct($digits)
{
	$maxStr="";
	$minStr="";
	$max=0;
	$min=0;
	$largestPalindrome=0;
	for($s=0;$s<$digits;$s++)
	{
		$maxStr .="9";
		if($s>0)$minStr .="9";	
	}
	if(strlen($maxStr)>0)
		$max=$maxStr;
	if(strlen($minStr)>0)
		$min=$minStr;
		
	for($x=$max; $x>$min; $x--)
	{
		for($y=$max; $y>$min; $y--)
		{
			$n = $x*$y;
			if(IsPalindrom(strval($n))==0)
			{
				if($n>$largestPalindrome)
					$largestPalindrome=$n;
			}
		}
	}
	return $largestPalindrome;
}	

if(isset($input))
{
	echo LargestPalindromeProduct($input);
}
else "enter inputs.";

?>