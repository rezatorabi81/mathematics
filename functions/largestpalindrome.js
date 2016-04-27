/*Javascript for calcating largest palindrom */

function IsPalindrom(str)
{
	var mid =0;
	len = str.length;
	
	if(len%2==0)mid = len/2;
	else mid = (len-1)/2;
	
	for(k=1;k<=mid;k++)
	{
		if(str.charAt(k-1)!=str.charAt(len-k))
		return -1;	
	}
	
	return 0;
}

function calculate(digits)
{
	var maxStr='';
	var minStr='';
	var max=0;
	var min=0;
	var largestPalindrome=0;
	for(s=0;s<digits;s++)
	{
		maxStr+='9';
		if(s>0)minStr+='9';
		
	}
	if(maxStr!='')
		max=parseInt(maxStr);
	if(minStr!='')
		min=parseInt(minStr);
	for(x=max; x>min; x--)
	{
		for(y=max; y>min; y--)
		{
			n = x*y;
			if(IsPalindrom(n.toString())==0)
			{
				if(n>largestPalindrome)
					largestPalindrome=n;
			}

		}
	}
	return largestPalindrome;
}

function validate(digits)
{
	if(digits>=1)
		return "ok";
	else if(digits<1)
	{
		return "Please enter a value larger than 0!";
	}
	else return "Please enter a valid number!";
}	