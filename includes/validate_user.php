<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 3, 2011
Last updated: November 6, 2011

*/

include("db.php");
include("validator.php");

$email = $_POST['email'];
// Invalid Email Address
if (validEmail($email) != 'true')
	echo "<span class=\"red\">Email address is invalid.</span>";

// User already exists
if(existingUser($email) == 'true')
	echo "<span class=\"red\">Email address has alredy been registered.</span>";

// All good
if(validEmail($email) == 'true' && existingUser($email) != 'true')
	echo "<span class=\"green\">Valid email address.</span>";

mysql_close($connection);
?>