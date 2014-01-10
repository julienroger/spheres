<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 20, 2011
Last updated: November 20, 2011

*/

include("includes/db.php");
include("includes/session.php");
include("includes/postfunction.php");

session_start();

// Get Sphere variables
$sphere_sid = $_GET['sid']; // Use GET to determine Sphere ID
$sphere_sid = mysql_real_escape_string($sphere_sid); // Sanatize non-hashed stuff
$my_id = $_SESSION['user_id']; // Use Session ID/User ID to determine access level
$my_id = mysql_real_escape_string($my_id);

// If the user has not logged in
if(!isLoggedIn()) {
	$logged_in = 0;
    header('Location: index.php?redirect='. basename($_SERVER['PHP_SELF']) . '?sid=' . $sphere_sid);
    die();
} else {
	$logged_in = 1;
}

// Get Sphere content
$query = "SELECT *\n".
"FROM `spheres`\n".
"LEFT OUTER JOIN sphere_memberships ON $my_id = sphere_memberships.user_id\n".
"AND $sphere_sid = sphere_memberships.sphere_id\n".
"WHERE spheres.sphere_id = $sphere_sid\n"; // Query for content

$myspheres_query = "SELECT sphere_memberships.*, spheres.sphere_id, spheres.sphere_name\n" .
"FROM `sphere_memberships`\n" .
"LEFT OUTER JOIN `spheres` ON sphere_memberships.sphere_id = spheres.sphere_id\n" .
"WHERE user_id = $my_id";

$spheremembers_query = "SELECT sphere_memberships.*, users.firstname, users.profilepic, users.email\n" .
"FROM `sphere_memberships`\n" .
"LEFT OUTER JOIN `users` ON sphere_memberships.user_id = users.user_id\n" .
"WHERE sphere_id = $sphere_sid";


if(!empty($sphere_sid) && is_numeric($sphere_sid)) {
$result = mysql_query($query);
$sphereData = mysql_fetch_array($result);
}

// Build sphere variables
$sphere_name = stripslashes($sphereData['sphere_name']);
$sphere_timestamp = $sphereData[3];
$sphere_lat = stripslashes($sphereData['lat']);
$sphere_lng = stripslashes($sphereData['long']);
$sphere_rad = stripslashes($sphereData['rad']);
$sphere_access = stripslashes($sphereData['type']);
$user_membership = $sphereData['user_id'];

if(empty($user_membership)) {
	$isMember = 0;
} else {
	$isMember = 1;
}

// Page content follows

include("top-header.php");

?>
<title>Spheres</title>
</head>

<?php

include("top-nav.php");
include("sub-nav.php");

// Sphere control
if(empty($sphere_sid)) {
	?>
<div id="main">
<h3>Welcome to Spheres!</h3>
<p>Here are a list of your spheres:</p>	
	
	<div id="multiDisplay">
	<?php
	// Build MySpheres here
	$myresult = mysql_query($myspheres_query);
	
	if(mysql_num_rows($myresult)!=0) {
	while ($mySphereData = mysql_fetch_array($myresult, MYSQL_ASSOC)) {
	echo "<a href=\"sphere.php?sid=" . $mySphereData['sphere_id'] . "\"><span class=\"mysphere\" title=\"" . stripslashes($mySphereData['sphere_name']) . "\">" . stripslashes($mySphereData['sphere_name']) . "</span></a>\n";
	}
	} else {
		echo "You are not a member of any spheres!";	
	}
	
	?>
	</div>
	</div>
	
	<?php
} elseif(empty($sphereData)) {
	echo "\nThis is not a sphere.\n";
} elseif($sphere_access == 2 && empty($user_membership)) {
	echo "\nYou do not have access to this sphere.\n";
} elseif($sphere_access == 1 && empty($user_membership)) {
?>
<h3>Private Sphere: You must first join the sphere!</h3>
<form enctype="" action="includes/sphere_control.php" method="POST">
<input type="hidden" name="sphere_id" value=<?php echo "\"" . $sphere_sid . "\""; ?> />
<input class="reddButton" type="submit" name="joinsphere" value="Join Sphere" />
</form>
<?php
} else {

?>

<!-- Sphere name -->
<div id="rightmain">
<div id="membership_control">
<?php
if($isMember == 0) {
?>
<form enctype="" action="includes/sphere_control.php" method="POST">
<input type="hidden" name="sphere_id" value=<?php echo "\"" . $sphere_sid . "\""; ?> />
<input class="Button reddButton" type="submit" name="joinsphere" value="Join Sphere" />
</form>
<?php
} else {
?>
<form enctype="" action="includes/sphere_control.php" method="POST">
<input type="hidden" name="sphere_id" value=<?php echo "\"" . $sphere_sid . "\"" ?> />
<input class="greyButton" type="submit" name="leavesphere" value="Leave Sphere" />
</form>
<?php
}
?>
</div>
<p>This sphere was created on <?php echo date("F j, Y", $sphere_timestamp) . " at " . date("g:i a", $sphere_timestamp)  ?></p>
<p>Sweet, sweet Sphere content to go here.</p>

<h4>Sphere Members:</h4>
<div id="spheremembers">
<?php

	// Build Sphere Members here
	$sphereresult = mysql_query($spheremembers_query) or die(mysql_error());
	if(mysql_num_rows($sphereresult)>0) {
	while ($SphereMembers = mysql_fetch_array($sphereresult, MYSQL_ASSOC)) {
		if(!empty($SphereMembers['profilepic'])) {
			$MemberProPic = urlencode(base64_encode($SphereMembers['email'])) . "/" . $SphereMembers['profilepic'];
		} else {
			$MemberProPic = "../includes/profile_def.png";
		}
		// We can insert code to suppress the display of one's self. Implement with more users: if($SphereMembers['user_id']==$my_id) { } else {	
	echo "<a href=\"member.php?mid=" . $SphereMembers['user_id'] . "\" title=\"" . $SphereMembers['firstname'] . "\">" . 
	"<span class=\"memberdisplay\">" . 
	//"<img src=\"/slir/w80-h80-c1:1/assets/" . urlencode(base64_encode($SphereMembers['email'])) . "/" . $SphereMembers['profilepic'] . "\" />\n".
	"<img src=\"/slir/w80-h80-c1:1/assets/" . $MemberProPic . "\" />\n".
	stripslashes($SphereMembers['firstname']) . 
	"</span>" . 
	"</a>\n";
	
	}
	} else {
		echo "This sphere has no members!";	
	}

?>
</div>

</div>

<div id="leftmain">
<h3>Welcome to the <?php echo $sphere_name ?> Sphere!</h3>

<img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $sphere_lat . "," . $sphere_lng; ?>&zoom=15&size=450x200&&markers=size:mid%7C<?php echo $sphere_lat . "," . $sphere_lng; ?>&sensor=false" />
<!-- Replace this with a javascript map --->



<br />
<?php
if($isMember == 1) {
?>
<div id="spherepost">
<form enctype="" action="includes/postcomment.php" method="POST">
<textarea class="formStyle post_box" id="box" value="" name="message" /></textarea>
<input type="hidden" name="sphere_id" value=<?php echo "\"" . $sphere_sid . "\"" ?> />
<input class="reddButton" type="submit" name="submitpost" value="Post" />
</form>
<div class="pusher"></div>
</div>
<?php
}
?>
<!-- End of form -->

<?php
// Display Sphere info
?>
<div id="sphereposts">
<div id="wallpost3">
<?php
// Display Sphere posts and comments
getposts($sphere_sid, $isMember);

?>
</div>
</div>
<br />
</div>

<?php
}
?>
<div id="endmain">
<script type="text/javascript" src="includes/autoresize.jquery.min.js"></script>
<script>

$('textarea#box').autoResize();

</script>
</div>
<?php
include("sub-footer.php");
include("footer.php");

?>