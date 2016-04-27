<!--Inculding all contents for Sargest palindrome product page-->

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

	<!-- Header -->

	<h3>Largest palindrome product</h3>

	<!-- Page description -->

	<div class="description">
		<p>This calculator is a dynamic solution to problem No.4 in: </p><a href="https://projecteuler.net/problem=4" target="_blank" >Projecteuler.net</a>
		"A palindromic number reads the same both ways. The largest palindrome made from the product of two 2-digit numbers is 9009 = 91 x 99. Find the largest palindrome made from the product of two 3-digit numbers."
		</p></br>
		<p>Please enter an integer number (digits) below to caculate its Largest Prime Factors. Note: Answering to values larger than 3 may take significant time to process.</p>
	</div>

	<!-- Calculation form -->

	<fieldset> 	
		<table>
		<tr>
			<td><p class="label1" > <label  >Product of two: </label> </p> </td>
			<td><input class="smallTxtBox" type="text" id="input1"> digits</td>
		</tr>
		<tr>		
			<td><p class="label1" > <button id="btm">Calculate</button> </p></td>
			<td ><input  type="checkbox" id="serverside"> Calculate at server</td>	
		</tr>
		</table>
		<p class="label2" > <label id="answer" ></label></p>
		<p class="label2" > <label id="time" ></label></p>
		<p class="label2" > <label id="totalruns" ></label></p>
		<p class="error" > <label id="error" ></label></p>	
	</fieldset>
	
</body>

<!-- Scripts -->

<script src="math.js"> </script>
<script src="dbscript.js"> </script>
<script src="pagescript.js"> </script>
<script type="text/javascript"> 

<!-- Do calculation -->
	var button= document.getElementById('btm');
	button.onclick= function (){calculate(2);}
	
</script>