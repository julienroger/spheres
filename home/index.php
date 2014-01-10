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
include("includes/components.php");

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

echo $errmsg . "";

if ($logged_in == 0)
{

// Display login form
?>
<div id="main">

<h3>Login</h3>
<form name="login" action=<?php echo "\"includes/login.php?redirect=" . $redirect . "\""; ?> method="post">
    Email address: <input tabindex=1 type="text" name="email" value=<?php echo "\"" . rawurldecode($_COOKIE["um"]) . "\""; ?> /><br />
    Password: <input tabindex=2 type="password" name="password" /><br />
    <input tabindex=3 type="submit" value="Login" />
</form>

<?php

	echo $forgotpass_module;
	
?>
<p>Spheres is currently is private Alpha.</p>
<img src="includes/logo_big.jpg" align="right" />

</div>
<div id="endmain"></div>
<?php
}
else {
	
?>

<?php
	
	include("includes/sphere_maker.php");
}
include("sub-footer.php");
include("footer.php");
?>