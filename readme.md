*This instruction assuming web application will be installed on a machine with Microsoft Windows and :
	
	*MySQL Server installed and is operational in C:\Program Files\MySQL\MySQL Server 5.6\bin
	*PHP Version 5.3.0 or higher installed and is operational
	*Apache server 2.0 is installed and operational and default folder for hosting default website is in C:\Program Files\Apache Group\Apache2\htdocs 
		And accessible when user types http://localhost
	

--------------------------------------------------------------------
I- Creating database and inserting default data
--------------------------------------------------------------------



1-Open a command prompt and CD to bin directory of mysql this can be different based on version of Mysql currently installed on your system
	e.g. C:\Program Files\MySQL\MySQL Server 5.6\bin
	
2-Execute mysql with following parameters: -u root -p , here you need to modify root with your root user So: 
	
	C:\Program Files\MySQL\MySQL Server 5.6\bin\mysql -u root -p

3- Enter password for root user.

4- Now in mysql shell create mathdb database by entering this command: 
	
	CREATE DATABASE mathdb;

5- Connect to mathdb database by following command:

	CONNECT mathdb;
	
6- Create 'function' table which keeps information about individual mathematical functions (e.g. Largest Prime Factor):	


	CREATE TABLE IF NOT EXISTS `function` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `inputs` int(11) NOT NULL,
  `Jscript_path` varchar(1000) NOT NULL,
  `PHP_path` varchar(1000) DEFAULT NULL,
  `description` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

7- 	Insert data for three functions "Largest Prime Factor", "Smallest multiple Calculator" and "Largest palindrome product":


INSERT INTO `function` (`name`, `inputs`, `Jscript_path`, `PHP_path`, `description`) VALUES
('Largest Prime Factor', 1, 'largestprimefactor.js', 'largestprimefactor.php', 'The greatest prime factor of an integer n is the largest prime number that divides the number. For example, the greatest prime factor of 44100 is 7 (all larger divisors of 44100 are composite). A prime number is its own greatest prime factor (as well as its own least prime factor). By convention, 1 is sometimes given as its own greatest prime factor. oeis.org'),
('Smallest multiple Calculator', 2, 'smallestmultiple.js', 'smallestmultiple.php', 'This calculator is a dynamic solution to problem No.5 in: Projecteuler.net "2520 is the smallest number that can be divided by each of the numbers from 1 to 10 without any remainder.What is the smallest positive number that is evenly divisible by all of the numbers from 1 to 20?"'),
('Largest palindrome product', 1, 'largestpalindrome.js', 'largestpalindrome.php', 'This calculator is a dynamic solution to problem No.4 in: Projecteuler.net "A palindromic number reads the same both ways. The largest palindrome made from the product of two 2-digit numbers is 9009 = 91 x 99. Find the largest palindrome made from the product of two 3-digit numbers." ');


6- Create 'problem' table which keeps record for each individual records submited for each function:	

CREATE TABLE IF NOT EXISTS `problem` (
  `problem_id` int(11) NOT NULL,
  `test_number` varchar(256) NOT NULL,
  `test_answer` varchar(256) NOT NULL,
  `total_runs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--------------------------------------------------------------------
II- Placing web files inside webserver
--------------------------------------------------------------------

1- Unzip the website zip file. It consists of :

	website files	
	|
	|
	function : This folder consists of  javascripts(client side calculation) and php files (server side calculation) for each mathematical function. 
	|	|
	|	|-- _JS_TEMPLATE_.js		"Template for creating new javascript of mathematical functions"
	|	|-- _PHP_TEMPLATE.php		"Template for creating new php code of  mathematical functions"
	|	|--largestpalindrome.js		"Javascript file for Largest Prime Factor function"
	|	|--largestpalindrome.php	"PHP file for Largest Prime Factor function"
	|	|--largestpalindrome.js		"Javascript file for Largest palindrome product"
	|	|--largestpalindrome.php	"PHP file for Largest palindrome product"		
	|	|--smallestmultiple.js		"Javascript file for Smallest multiple"		
	|	|--smallestmultiple.php		"PHP file for Smallest multiple"		
	|
	|--	style.css					"Keeps the CSS of all pages"
	|--	config.ini					"Keeps parametrs for connecting to the database" $$$ This file must be edited and user needs to replace the defualt values with username and password of database$$$$$
	|--	commonscripts.js 			"Keeps scripts for making AJAX call to server to send parameter for server side calculation and also adding/updating a record for a new problem "
	|--admin_content.php 			"Keeps backend code for creating admin form, uploading new scripts and adding new function"
	|--home_content.php 			"Keeps contents of home page"
	|--index.php 					"Default file called when visiting website. This file includs master.php and home_content.php"
	|--leaderboard_content.php 		"Show a history of previous solved problems, their id, problem question, answer and total run"
	|--master.php 					"the master page which keeps the navigation bar and section for including other pages and scripts"
	|--problem_content.php			"Keeps codes to display a form for the selected function, recieve inputs for a new problem call other scripts to calculate the answer and display it to user"
	|--sendtodb.php					"This file create or update a record on database for given problem and return the total_runs value"
	|--SQL.txt						"Although all commands for creating database is explained in  readme file, these commands also available separately inside SQL.txt file"

2-copy the folder and all files to the 	default web directory of apache e.g C:\Program Files\Apache Group\Apache2\htdocs

3-Edit config.ini file replace the default value with the username and password of your mysql server. If mysql server host in other machine you can change the value of address to address of remote mysql server. 

4-Website is ready to be used. Open your internet browser and type : http://localhost in address bar, you should now able to see the home page now.
