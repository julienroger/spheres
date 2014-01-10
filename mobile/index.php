<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 3, 2011
Last updated: November 13, 2011

*/

include("../includes/db.php");
include("../includes/session.php");

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

//include("top-header.php");
?>
<title>Spheres - Mobile</title>
</head>

<?php
//include("top-nav.php");
//include("sub-nav.php");

echo $errmsg . "";

if ($logged_in == 0)
{

// Display login form
?>
<h3>Mobile Spheres</h3>
<?php

	echo $forgotpass_module;
	
?>

<?php
}
else {
	
?>
<h3>Mobile Spheres</h3>

<?php
	
}
//include("sub-footer.php");
//include("footer.php");
?>