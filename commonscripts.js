
/*clear the fields*/
function clearfields()
{
		document.getElementById('answer').innerHTML="";
		document.getElementById('time').innerHTML="";
		document.getElementById('totalruns').innerHTML = "";
		document.getElementById('error').innerHTML = "";
}

/*Posts the values for current problem to 
the server to update the database. The the return value from server is used to update the total_runs*/

function updatedb(id,tnumber,answer)
		{
			
			/*Problem parameters*/
				var dataString = 'problem_id=' + id + '&test_number=' + tnumber + '&test_answer=' +answer;
				var hr = new XMLHttpRequest();
				/*URL to Backend file contaning necessary code for updating database*/
				var url = "sendtodb.php";
				
				hr.open("POST", url, true);
				hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				document.getElementById('totalruns').innerHTML = '</br>Total runs: Please wait ...';
				hr.onreadystatechange = function() 
				{
					if(hr.readyState == 4 && hr.status == 200) 
					{
						
						var return_data =  hr.responseText;	
							try {
								jsonResponse= JSON.parse(return_data);
								
								document.getElementById("totalruns").innerHTML='</br>Total runs:<b>' + jsonResponse['total_runs'] +'</b>';
							} catch (e) {
								document.getElementById("error").innerHTML=e;
							}				
					}
				}
				hr.send(dataString);
		} 
		
/*Posts the values for current problem to the server for calculation and update the
 page with answer*/		
 
function serversidecalc(id,tnumber,phpfile)
{
	/*Problem parameters*/

		var dataString = 'problem_id=' + id + '&input=' + escape(JSON.stringify(tnumber));
		var hr = new XMLHttpRequest();
		
		/*URL to Backend file contaning mathematical functions*/
		var url = './functions/'+phpfile;
		
		/*Set Timer*/
		var startTime= new Date();
		
		/*Making an Asynchronous Call to server for sending values*/
		hr.open("POST", url, true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() 
		{
			if(hr.readyState == 4 && hr.status == 200) 
			{
				var return_data =  hr.responseText;		
				
				/*clear the fields*/
				clearfields();
					try 
					{
						var finishTime= new Date();

						document.getElementById('answer').innerHTML = '</br>The answer is: <b>'+ return_data+ '</b>';
						document.getElementById('time').innerHTML = 'Total calculation time: <b>'+ (finishTime -startTime)/1000 + '</b>s';
						/*Storing in database  */
						updatedb(id,tnumber,return_data);
						
					} catch (e) {
						
						clearfields();
						document.getElementById("error").innerHTML=e;
					}				
			}

		}
		/*Sending parameters*/
		hr.send(dataString);

}
		