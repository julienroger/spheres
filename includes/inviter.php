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

session_start();
	  	
// Retrieve data from POST
$email = $_POST['email'];
$inviter_uid = $_SESSION['user_id'];
$inviter_name = $_SESSION['user_firstname'];

// Check to see if the username is valid
if(validEmail($email) != 1) {
    header('Location: ../profile.php?inv=1');
	die("Not a valid email address.");
}
	
// Check to see if the username exists
if(existingUser($email) == 1) {
    header('Location: ../profile.php?inv=2');
	die("User already exists.");
}

	// Generate token
	$hash = hash('sha256', $email);
	$timestamp = time();
	
	function createSalt() {
	    $string = md5(uniqid(rand(), true));
	    return substr($string, 0, 4);
	}	
	$salt = createSalt();
	$regtoken = hash('sha256', $salt . $hash);

	// Create Invitation Database Entry
	$email1 = mysql_real_escape_string($email);
	$inviter_uid = mysql_real_escape_string($inviter_uid);
	$query = "INSERT INTO invitations ( inviter, email, token, timestamp ) VALUES ( '$inviter_uid', '$email1' , '$regtoken' , $timestamp );";
    mysql_query($query) or die(mysql_error());
	
	// Email Portion
	$reg_url = "***.com/register.php?email=" . rawurlencode($email) . "&token=" . $regtoken ;
	
	$to=$email;
	$subject="Invitation to Spheres!"; // Your subject
	
	// From
	$header = 'From: ***' . "\r\n" .
	'Reply-To: ***' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();

	// Your message
	$messages .= "Hey!\r\n\r\n";
	$messages .= "Your friend $inviter_name thought it would be a great idea for you to check out Spheres. What's that?\r\n\r\n";
	$messages .= "Spheres lets you connect and interact with the places you love - even when you're not there!\r\n\r\n";
	$messages .= "--------------------------------------\r\n";
	$messages .= "Spheres is currently invite only; your invitation link is below:\r\n";
	$messages .= "$reg_url\r\n";
	$messages .= "-------------------------------------- \r\n\r\n";
	$messages .= "Enjoy!\r\n\r\n";
	$messages .= "- Spheres\r\n";
	// send email
	$sentmail = mail($to,$subject,$messages,$header);
	
	if($sentmail) // if your email succesfully sent
	{
	    header('Location: ../profile.php?inv=5');
	}
	else // Cannot send invite to email address
	{
	    header('Location: ../profile.php?inv=3');
	}

?>