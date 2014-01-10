<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 3, 2011
Last updated: November 13, 2011

*/

include("includes/db.php");
include("includes/session.php");

session_start();

$err = array("Incorrect email or password.");
$errcode = $_GET['err'];
$redirect = $_GET['redirect'];
$errmsg = $err[$errcode];

//if the user has not logged in
if(!isLoggedIn())
    $logged_in = 0;
else
	$logged_in = 1;

include("top-header.php");
?>
<title>Spheres</title>
</head>

<?php
include("top-nav.php");
include("sub-nav.php");

echo "<span class=\"error\" >". $errmsg . "</span>";

if ($logged_in == 0)
{

// Display login form
?>
<div id="main">
<div class="formarea">
<h3>Login</h3>

<form name="login" id="userProfile" action=<?php echo "\"includes/login.php?redirect=" . $redirect . "\""; ?> method="post">
    <div class="formLine"><div class="field"><label>Email address: </label></div>
    <div class="formField"><input tabindex=1 type="text" name="email" value=<?php if(!empty($_COOKIE["um"])) {echo "\"" .  rawurldecode($_COOKIE["um"]) . "\"";} else {echo "\"\"";} ?> class="formStyle" />
    </div></div>
    
    <div class="formLine"><div class="field"><label>Password: </label></div>
    <div class="formField"><input tabindex=2 type="password" name="password" class="formStyle" />
    </div></div>
	<br /><br />
    <input tabindex=3 class="reddButton leftButton" type="submit" value="Login" />
    
</form>
</div>
<br />
<span style="font-size: 0.75em"><a href="forgot_pass.php">Forgot Password</a></span>

<p>Spheres is currently is private Alpha.</p>
<img src="includes/logo_big.jpg" style="display: block; float: right; text-align: right;" />

</div>
<div id="endmain"></div>
<?php
}
else {
	
?>

<?php
	
	include("includes/sphere_maker.php");
}
?>

<?php
include("sub-footer.php");
include("footer.php");
?>