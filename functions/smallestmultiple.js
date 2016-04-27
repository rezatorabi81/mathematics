
/*Javascript for calcating Smallest multiple */

function gcd(x, y) {
	if (y==0) {
		return x;
	}
	return gcd(y, x % y);
}

function lcm(x,y)
{
	return (x*y) / gcd(x,y);
	
}

function calculate(n1,n2)
{

	var max=0;
	var min=0;
	var num1 =parseInt(n1);
	var num2 =parseInt(n2);
	if(num1>num2){max=num1; min=num2;}
	else {max=num2; min=num1;}
	var smlmltp = min;
	for(var s=parseInt(min);s<=max;s++)
	{
		
		smlmltp = lcm(parseInt(s),parseInt(smlmltp));
	}
	return smlmltp;
}

function validate(n1,n2)
{
	if(n1>=1 && n2>=1)
		return "ok";
	if(n1>=1 || n2>=1)
	{
		return "Both value should be larger than 0!";
	}
	else return "Please enter a valid numbers!";
}	
