/*Javascript for calcating largest prime factor */

function calculate(n)
{
	num = parseInt(n);
	for(i=2;i<num;i++)
	{
		if(num%i==0)
		{
			num/=i;
			i--;
		}
	}
	return i;
}


function validate(n)
{
	if(n>=2)
		return "ok";
	else if(n<2)
	{
		return "Please enter a value larger than 2!";
	}
	else return "Please enter a valid number!";
}