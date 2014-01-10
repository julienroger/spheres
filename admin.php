<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 3, 2011
Last updated: November 21, 2011

*/

include("includes/db.php");
include("includes/session.php");
include("includes/validator.php");

session_start();
//if the user has not logged in
if(!isLoggedIn())
{
	$logged_in = 0;
    header('Location: index.php?redirect='. basename($_SERVER['PHP_SELF']));
    die();
}
else
	$logged_in = 1;
	
$invite_status = $_GET['inv'];
if(empty($invite_status)) {
	$invite_status = 0;
}

$invites = array("", "Not a valid email address.", "User already exists.", "Could not send the invite.", "", "Invite sent successfully!");

//page content follows

include("top-header.php");

?>
<title>Spheres</title>
</head>

<?php

include("top-nav.php");
include("sub-nav.php");

?>

<?php
/*
if(isset($_COOKIE["um"]))
{
	$myemail = $_COOKIE["um"];
	$myname = $_SESSION['user_firstname'];
	echo "Hello, " . rawurldecode($myname) . "!";
}
else
{
	echo "<p>No cookie set...</p>";
}
*/
?>

<?php
// Admin Module
if($_SESSION['user_id'] == 1) {

	include("includes/sphere_maker.php");
	
?>
<div id="main">
<?php

	include("includes/sphere_admin.php");

	echo "<p>" . $invites[$invite_status] . "</p>";
	
?>
<h4>Invite users</h4>

<form name="invite" id="userProfile" action="includes/inviter.php" method="post">
    <div class="formLine"><div class="field"><label>Email address: </label></div>
    <div class="formField"><input tabindex=1 type="text" value ="" name="email" maxlength="65" class="formStyle" />
    </div></div>
<br /><input tabindex=2 class="reddButton" type="submit" value="Invite!" />
</form>


</div>
<div id="endmain">
</div>
	
<?php
	
}

include("sub-footer.php");
include("footer.php");

?>