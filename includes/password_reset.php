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

  require_once('recaptchalib.php');
  $privatekey = "***";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    header('Location: ../forgot_pass.php?sit=0');
    die();
  } else {
	  	
	// Retrieve data from POST
	$email = $_POST['email'];
	
	// Check to see if the username is valid
	if(validEmail($email) != 1)
		{
	    header('Location: ../forgot_pass.php?sit=1');
		die("User does not exist.");
		}
		
	// Check to see if the username exists
	if(existingUser($email) != 1)
		{
	    header('Location: ../forgot_pass.php?sit=2');
		die("User does not exist.");
		}

		// Get the user's first name, or set it to a default greeting
		$email1 = mysql_real_escape_string($email);
		$rawemail = rawurlencode($email);
		$query = "SELECT firstname FROM users WHERE email = '$email1';";
		$result = mysql_query($query);
		$userdata = mysql_fetch_array($result, MYSQL_NUM);
		if (empty($userdata[0]))
			$greeting = "Hey there Project Jupiter user,";
		else
			$greeting = "Hey " . $userdata[0] . ",";

		// Generate token
		$hash = hash('sha256', $email);
		$timestamp = time();
		function createSalt()
		{
		    $string = md5(uniqid(rand(), true));
		    return substr($string, 0, 4);
		}
		$salt = createSalt();
		$token = hash('sha256', $salt . $hash);

		// Create Password Reset Database Entry
		$query = "INSERT INTO passwordreset ( email, token, timestamp ) VALUES ( '$email1' , '$token' , $timestamp );";
        mysql_query($query) or die(mysql_error());
		
		// Email Portion
		$reset_url = "***/forgot_pass.php?email=" . $rawemail . "&token=" . $token ;
		
		$to=$email;
		$subject="Project Jupiter Password Reset"; // Your subject
		// From
		$header = 'From: ***' . "\r\n" .
		'Reply-To: ***' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		//add code for selecting $userid and $pass for user table for the input $email_to.
		// Your message
		$messages.= "$greeting\r\n\r\n";
		$messages.="We got a request to reset the password for your account.\r\n\r\n";
		$messages.="-------------------------------------- \r\n";
		$messages.= "Please click on the link below to reset your password: \r\n";
		$messages.= "$reset_url \r\n";
		$messages.="-------------------------------------- \r\n\r\n";
		$messages.="If you don't want to reset your password, please ignore this message. Your password will not be reset. If you have any concerns, please contact us. \r\n\r\n";
		$messages.="Thanks,\r\n";
		$messages.="The Spheres Team \r\n";
		// send email
		$sentmail = mail($to,$subject,$messages,$header);
		
		if($sentmail) //if your email succesfully sent
		{
		    header('Location: ../forgot_pass.php?sit=5');
		}
		else // Cannot send password to your e-mail address
		{
		    header('Location: ../forgot_pass.php?sit=3');
		}
		
 }

?>