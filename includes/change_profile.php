<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 3, 2011
Last updated: November 13, 2011

*/

include("db.php");
include("validator.php");
include("session.php");

$MAX_SIZE = 1024*1024*5; // Max file size for pictures: 5MB

// Retrieve our data from POST
$form_type = $_POST['profiletype'];

$old_email = $_POST['old_email'];
$new_email = $_POST['new_email'];

$old_pass = $_POST['password'];

$new_firstname = $_POST['new_firstname'];
$new_lastname = $_POST['new_lastname'];

$new_gender = $_POST['new_gender'];
$new_bio = $_POST['new_bio'];

$new_pass1 = $_POST['pass1'];
$new_pass2 = $_POST['pass2'];

// Picture stuff

$profilepic_tmp = $_FILES['profile_picture']['tmp_name'];
$profilepic_name = $_FILES['profile_picture']['name'];
$profilepic_size = $_FILES['profile_picture']['size'];
$profilepic_type = $_FILES["profile_picture"]["type"];

$piclookup = array( "image/gif" => ".gif", "image/jpeg" => ".jpg", "image/pjpeg" => ".jpg", "image/png" => ".png" );

// Sanatize non-hashed stuff
$form_type = mysql_real_escape_string(htmlspecialchars($form_type));

$old_email = mysql_real_escape_string(htmlspecialchars($old_email));
$new_email = mysql_real_escape_string(htmlspecialchars($new_email));

$new_firstname = mysql_real_escape_string(htmlspecialchars($new_firstname));
$new_lastname = mysql_real_escape_string(htmlspecialchars($new_lastname));

$new_gender = mysql_real_escape_string(htmlspecialchars($new_gender));
$new_bio = mysql_real_escape_string(htmlspecialchars($new_bio));




// Validate password function
function validOldPass($password, $email) {
	
	$query = "SELECT password, salt FROM users WHERE email = '$email';";
	$result = mysql_query($query);
	
	if(mysql_num_rows($result) < 1) { //no such user exists
		return false;
	} else {
	
		$userData = mysql_fetch_array($result, MYSQL_ASSOC);
		$hash = hash('sha256', $userData['salt'] . hash('sha256', $password) );
		
		if($hash != $userData['password']) { //incorrect password
			return false;
		} else { // Password Good
			return true;
		}
	}
}


if($form_type == "profile") { // We're changing the profile - no password necessary

	if(strlen($new_firstname) > 65 || empty($new_firstname)) {
    header('Location: ../profile.php?err=4');
    die();
	} elseif(strlen($new_lastname) > 65) {
    header('Location: ../profile.php?err=5');
    die();
	} elseif($profilepic_size > $MAX_SIZE) {
	header('Location: ../profile.php?err=10');
    die();
	} elseif(strlen($new_bio) > 1000) {
	header('Location: ../profile.php?err=11');
    die();
	} elseif($new_gender!=0 && $new_gender!=1 && $new_gender!=2) {
	header('Location: ../profile.php?err=12');
    die();
	} else {
		
		if(!empty($profilepic_name)) {
			
			if ((($profilepic_type == "image/gif") || ($profilepic_type == "image/jpeg") || ($profilepic_type == "image/png") || ($profilepic_type == "image/pjpeg"))) {				
				$string = md5(uniqid(rand(), true));
				$profilepic_newname = substr($string, 0, rand(5,15)) . $piclookup[$profilepic_type];
				
				$profilepic_locaiton = "../assets/" . base64_encode($old_email) . "/" . $profilepic_newname;
				move_uploaded_file($profilepic_tmp, $profilepic_locaiton);
				
				$query = "UPDATE users SET profilepic = '$profilepic_newname' WHERE email = '$old_email';";
				mysql_query($query) or die(mysql_error());
			} else {
				header('Location: ../profile.php?err=11');
				die();
			}			
		}	
		
		$query = "UPDATE users SET lastname = '$new_lastname', firstname = '$new_firstname', gender = '$new_gender', bio = '$new_bio' WHERE email = '$old_email';";
		mysql_query($query) or die(mysql_error());
		
		session_start();
		reValidateUser($_POST['old_email']);
		
		mysql_close($connection);
	
		header('Location: ../profile.php');
	
	}

	
} elseif($form_type == "email") { // We're changing the email address

	if(strlen($new_email) > 65) { // Password too long
    header('Location: ../profile.php?err=2');
    die();
	} elseif(validEmail($new_email) != 'true') { // Email address is not valid
    header('Location: ../profile.php?err=7');
    die();
	} elseif(validOldPass($old_pass, $old_email) != 'true') { // Password is not correct
    header('Location: ../profile.php?err=7');
    die();
	} else {

			$query = "UPDATE users SET email = '$new_email' WHERE email = '$old_email';";
			mysql_query($query) or die(mysql_error());
			
			session_start();
			reValidateUser($new_email);
			
			// Update cookies
			ohhai($new_email);
			destroyCM($old_email, $_COOKIE["cm"]);
			cookieMonster($new_email);
			
			// Update user's asset directory
			$new_email = urlencode(base64_encode($new_email));
			$old_email = urlencode(base64_encode($old_email));
			rename("../assets/". $old_email, "../assets/". $new_email);
			
			mysql_close($connection);
			
			// Email old_email to let them know about the email change
		
			header('Location: ../profile.php');

	}

	
} elseif($form_type == "password") { // We're changing the password

	if($new_pass1 != $new_pass2) { // Passwords do not match
    header('Location: ../profile.php?err=1');
    die();
	} elseif(strlen($new_pass1) < 5 && !empty($new_pass1)) {
    header('Location: ../profile.php?err=6');
    die();
	} elseif(validOldPass($old_pass, $old_email) != 'true') { // Password is not correct
    header('Location: ../profile.php?err=7');
    die();
	} else {

		$hash = hash('sha256', $new_pass1);
				
			function createSalt() {
			    $string = md5(uniqid(rand(), true));
			    return substr($string, 0, 3);
			}
			$salt = createSalt();
			
			$hash = hash('sha256', $salt . $hash);
			
			$query = "UPDATE users SET salt = '$salt', password = '$hash' WHERE email = '$old_email';";
			
			mysql_query($query) or die(mysql_error());
			
			mysql_close($connection);
			
			header('Location: logout.php');

	}
	
	
} else { // Why the hell are we here??
	
	header('Location: ../profile.php');
    die();
	
}
?>