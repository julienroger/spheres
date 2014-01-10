<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 3, 2011
Last updated: November 11, 2011

*/

include("includes/db.php");
include("includes/session.php");
include("includes/components.php");

session_start();
//if the user has not logged in
if(!isLoggedIn()) {
	$logged_in = 0;
}
else {
	$logged_in = 0;
	logout_user();
}

$errcode = $_GET['err'];
$regtoken = $_GET['token'];
$regemail = $_GET['email'];

if(empty($regemail)) {
	$regemail = "";
}

if(empty($regtoken)) {
	$regtoken = "";
}

$err = array("The ReCAPTCHA words you entered were incorrect. Please try again.", "The password you entered was not strong enough. Please use a stronger password.", "The passwords you entered did not match. Please try again.", "The email address you entered was too long. Please try again.", "The email address you entered was invalid. Please try again.", "The email address you entered had already been registered.", "The registration token is either invalid, or does not match the email address you entered. Please make sure that the email address you use is the same one to which the registration token was sent.");

if(empty($errcode)) {
	$errcode = 0;
	$err = array("");
}

include("top-header.php");
?>
<script type="text/javascript">
function showUser(str)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("POST","includes/validate_user.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("email="+str);
}
</script>
<script type="text/javascript" src="includes/passstr.js"></script>
 <script type="text/javascript">
 $(document).ready(function() {
   $("#recaptcha_reload_btn, #recaptcha_switch_audio_btn, #recaptcha_whatsthis_btn").attr("tabindex", 6);
}); 
 var RecaptchaOptions = {
 	lang : 'en',
    tabindex : 4,
    theme : 'clean'
 };
 </script>
<title>Spheres</title>
<?php
include("top-nav.php");
include("sub-nav.php");
?>
<script type="text/javascript" src="includes/colortip-1.0-jquery.js"></script>
<script type="text/javascript" src="includes/tooltipinit.js"></script>
<div id="main">
<h3>Register</h3>
<?php echo "<p><span class=\"error\" >" . $err[$errcode] . "</span></p>"; ?>
<form name="register" id="userProfile" action="includes/register_user.php" method="post">

    <div class="formLine"><div class="field"><label>Email address: </label><span class="tooltipspan" title="This is your login credential as well.">?</span></div>
    <div class="formField"><input tabindex=1 type="text" value =<?php echo "\"" . rawurldecode($regemail) . "\""; ?> name="email" maxlength="65" class="formStyle" onchange="showUser(this.value)" />
    </div></div>
   
    <div class="formLine"><div class="field"><label>Password: </label></div>
    <div class="formField"><input tabindex=2 type="password" value ="" name="pass1" class="formStyle" />
    
    <div id="iSM">
	<ul class="weak">
		<li id="iWeak"></li>
		<li id="iMedium"></li>
		<li id="iStrong""></li>
	</ul>
	Password Strength: <div id="StrengthIndicator">
	</div></div>
    </div></div>
    
    <div class="formLine"><div class="field"><label>Password Again: </label></div>
    <div class="formField"><input tabindex=3 type="password" name="pass2" class="formStyle" />
    </div></div>
    
<?php
// ReCAPTCHA

require_once('includes/recaptchalib.php');
$publickey = "6LdtvMkSAAAAAGOiDU6FWAGOxUFeS1_knaZvE0mT";
echo recaptcha_get_html($publickey);
?>
<input type="hidden" id="passstrength" name="passstrength" value='' />
<input type="hidden" id="regtoken" name="regtoken" value=<?php echo "\"" . $regtoken . "\""; ?> />
<br /><input tabindex=5 class="reddButton" type="submit" value="Register" />
</form>
</div>
<div id="endmain">
</div>
<?php
include("sub-footer.php");
include("footer.php");
?>