<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 7, 2011
Last updated: November 7, 2011

*/

include("db.php");
include("validator.php");
include("session.php");

// Retrieve our data from POST
$email = $_POST['email'];
$new_pass1 = $_POST['newpass1'];
$new_pass2 = $_POST['newpass2'];
$passstrength = $_POST['passstrength'];
$token = $_POST['token'];
$rawemail = rawurlencode($email);
$token = rawurlencode($token);

// Sanatize non-hashed stuff
$email = mysql_real_escape_string($email);
$token = mysql_real_escape_string($token);

// Validation of new data
if($passstrength==0) {
    header('Location: ../forgot_pass.php?email=' . $rawemail . "&token=" . $token . "&sit=5");
    die();
}
if($new_pass1 != $new_pass2) {
    header('Location: ../forgot_pass.php?email=' . $rawemail . "&token=" . $token . "&sit=6");
    die();
}
if(validEmail($email) != 'true') {
    header('Location: ../forgot_pass.php?email=' . $rawemail . "&token=" . $token . "&sit=7");
    die();
}

// ReValidate Token
$query = "SELECT timestamp, used FROM passwordreset WHERE email = '$email' AND token = '$token';";

// Validate token
$result = mysql_query($query);

if(mysql_num_rows($result) < 1) {
	echo "No token/email match";
	die();
} else {
	$passRequestData = mysql_fetch_array($result, MYSQL_NUM);
	$timestamp = $passRequestData[0];
	$tokenage = time() - $timestamp; // Seconds since the token was issued; must not be more than 1*60*60 seconds
	$used = $passRequestData[1];
	
	if($tokenage<3630 && $used == 0)
	{
		$hash = hash('sha256', $new_pass1);
		function createSalt()
		{
		    $string = md5(uniqid(rand(), true));
		    return substr($string, 0, 3);
		}
		$salt = createSalt();
		$hash = hash('sha256', $salt . $hash);
		
		$query1 = "UPDATE users SET salt = '$salt', password = '$hash' WHERE email = '$email';";
		$query2 = "UPDATE passwordreset SET used = 1 WHERE email = '$email' AND token = '$token';";
		
		mysql_query($query1) or die(mysql_error());
		mysql_query($query2) or die(mysql_error());
		mysql_close($connection);
	
		header('Location: ../index.php');
		die();
	} else {
		mysql_close($connection);
		header('Location: ../forgot_pass.php?sit=8');
		die();
	}
}
?>