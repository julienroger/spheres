<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 7, 2011
Last updated: November 11, 2011

*/

include("includes/db.php");
include("includes/session.php");
include("includes/components.php");
include("includes/validator.php");


$errcode = $_GET['sit'];
$errcode = rawurlencode($errcode);
$rawemail = $_GET['email'];
$email = rawurldecode($rawemail);
$token = $_GET['token'];
$token = rawurlencode($token);

$email = mysql_real_escape_string($email);

session_start();
//if the user has not logged in
if(isLoggedIn())
{
	header('Location: includes/logout.php');
	die();
}

$err = array("The validation words you entered were incorrect. Please try again.", "The email address you entered was not found in our system.", "The email address you entered was not found in our system.", "We were not able to send an email to the address you provided. Please try again.","","The password you entered was not strong enough. Please try again.", "The passwords you entered did not match. Please try again.","You cannot change the password for this account.","This password reset link is no longer valid. Please <a href=\"forgot_pass.php\">try again.</a>");

include("top-header.php");
?>
<script type="text/javascript" src="includes/passstr.js"></script>
 <script type="text/javascript">
 $(document).ready(function() {
   $("#recaptcha_reload_btn, #recaptcha_switch_audio_btn, #recaptcha_whatsthis_btn").attr("tabindex", 6);
}); 
 var RecaptchaOptions = {
 	lang : 'en',
    tabindex : 2,
    theme : 'clean'

 };
 </script>
<title>Project Jupiter</title>
<?php
include("top-nav.php");
include("sub-nav.php");
?>
<br />
<?php echo $err[$errcode]; ?>
<br />

<?php
if (empty($email) || empty($token))
{
	// Not from email
	require_once('includes/recaptchalib.php');
	$publickey = "6LdtvMkSAAAAAGOiDU6FWAGOxUFeS1_knaZvE0mT";
	
	if($errcode == 5)
	{
		echo "<h3>Forgot Password</h3>";
		echo "<p>You have requested a password reset. A link will be sent to your email address where you can reset your password.</p>";
	}
	else
	{
		echo "
			<form name=\"forgot_password\" action=\"includes/password_reset.php\" method=\"post\">
			    Email address: <input tabindex=1 type=\"text\" name=\"email\" maxlength=\"75\" /><br />"
			. recaptcha_get_html($publickey) . 
			"<br /><input tabindex=3 type=\"submit\" value=\"Submit\" />
			</form>";
	}
}
else
{
	$token = mysql_real_escape_string($token);
	$query = "SELECT timestamp, used FROM passwordreset WHERE email = '$email' AND token = '$token';";

	// From email
	echo "<h3>Password Reset</h3>";
	
	// Validate email
	if(validEmail($email) != 1)
	{
		echo "This is not a valid email.";
	}
	else
	{
		// Validate token
		$result = mysql_query($query);

		if(mysql_num_rows($result) < 1)
		{
		echo "No token/email match";
		}
		else
		{
			$passRequestData = mysql_fetch_array($result, MYSQL_NUM);
			mysql_close($connection);
			$timestamp = $passRequestData[0];
			$tokenage = time() - $timestamp; // Seconds since the token was issued; must not be more than 1*60*60 seconds
			$used = $passRequestData[1];
			
			if($tokenage<3600 && $used == 0)
			{
				echo "
				<form name=\"password_change\" action=\"includes/change_password.php\" method=\"post\">
				    Password: <input tabindex=1 type=\"password\" name=\"newpass1\" />
				    <div id=\"iSM\">
					<ul class=\"weak\">
						<li id=\"iWeak\"></li>
						<li id=\"iMedium\"></li>
						<li id=\"iStrong\"></li>
					</ul></div>
					Password Strength: <div id=\"StrengthIndicator\">
					Password Strength
					</div>
				    <br />
				    Password Again: <input tabindex=2 type=\"password\" name=\"newpass2\" /><br />
				    <input type=\"hidden\" id=\"passstrength\" name=\"passstrength\" value=\'\' />
				    <input type=\"hidden\" id=\"token\" name=\"token\" value=" . $token . " />
				    <input type=\"hidden\" id=\"email\" name=\"email\" value=" . $email . " />
				<input tabindex=3 type=\"submit\" value=\"Reset Password\" />
				</form>";
			}
			else
			{
				echo "Invalid password reset link. Please <a href=\"forgot_pass.php\">try again.</a>";
			}
		}
	}	
}
include("sub-footer.php");
include("footer.php");

?>