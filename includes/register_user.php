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
include("session.php");

$email = $_POST['email'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];
$passstrength = $_POST['passstrength'];

$regtoken = $_POST['regtoken'];

require_once('recaptchalib.php');
$privatekey = "***";
$resp = recaptcha_check_answer ($privatekey,
                              $_SERVER["REMOTE_ADDR"],
                              $_POST["recaptcha_challenge_field"],
                              $_POST["recaptcha_response_field"]);

if (!$resp->is_valid) {
  // What happens when the CAPTCHA was entered incorrectly
  header('Location: ../register.php?err=0&email=' . rawurlencode($email) . "&token=" . $regtoken);
  die();
} else {

// Retrieve data from POST

$regtoken = mysql_real_escape_string($regtoken);

$jointime = time();

function validInvite($email, $token) {
	$email = mysql_real_escape_string($email);
	$token = mysql_real_escape_string($token);
	$query = "SELECT * FROM invitations WHERE email = '$email' AND token = '$token' AND used = 0;";
	$result = mysql_query($query) or die(mysql_error());
	if(mysql_num_rows($result)>0) {
		return true;
	} else {
		return false;
	}
}

function invalidateInvite($email) {
	$email = mysql_real_escape_string($email);
	$query = "UPDATE invitations SET used = 1 WHERE email = '$email';";
	mysql_query($query) or die(mysql_error());
}

if($passstrength==0) {
    header('Location: ../register.php?err=1&email=' . rawurlencode($email) . "&token=" . $_POST['regtoken']);
    die();
} elseif($pass1 != $pass2) {
    header('Location: ../register.php?err=2&email=' . rawurlencode($email) . "&token=" . $_POST['regtoken']);
    die();
} elseif(strlen($email) > 64) {
    header('Location: ../register.php?err=3&email=' . rawurlencode($email) . "&token=" . $_POST['regtoken']);
    die();
} elseif(validEmail($email) != 'true') {
    header('Location: ../register.php?err=4&email=' . rawurlencode($email) . "&token=" . $_POST['regtoken']);
    die();
} elseif(empty($regtoken) || !validInvite($email, $regtoken)) { // Check invite
    header('Location: ../register.php?err=6&email=' . rawurlencode($email) . "&token=" . $_POST['regtoken']);
    die();
} elseif(existingUser($email) == 'true') { // Check to see if the username already exists
    header('Location: ../register.php?err=5&email=' . rawurlencode($email) . "&token=" . $_POST['regtoken']);
	die();
}

$hash = hash('sha256', $pass1);

//creates a 3 character sequence
function createSalty() {
    $string = md5(uniqid(rand(), true));
    return substr($string, 0, 3);
}
$salt = createSalty();

$hash = hash('sha256', $salt . $hash);

//sanitize username
$email1 = mysql_real_escape_string(htmlspecialchars($email));
$query = "INSERT INTO users ( email, password, salt, joindate ) VALUES ( '$email1' , '$hash' , '$salt' , '$jointime' );";
mysql_query($query) or die(mysql_error());

reValidateUser($email); //sets the session data for this user
ohhai($email);
cookieMonster($email);

invalidateInvite($email); // Remove invite

// Make user's asset directory
$email = urlencode(base64_encode($email));
mkdir("../assets/" . $email);

mysql_close($connection);

header('Location: ../profile.php?&p=55'); // Include a GET code to request a first name; also highlight the first name box

}
?>