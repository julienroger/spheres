<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 20, 2011
Last updated: November 21, 2011

*/

include("includes/db.php");
include("includes/session.php");

session_start();

// Use GET to determine Sphere ID
$member_mid = $_GET['mid'];

// If the user has not logged in
if(!isLoggedIn())
{
	$logged_in = 0;
    header('Location: index.php?redirect='. basename($_SERVER['PHP_SELF']) . "?mid=" . $member_mid);
    die();
}
else
	$logged_in = 1;

// Use Session ID/User ID to determine access level
$my_id = $_SESSION['user_id'];

// Sanatize non-hashed stuff
$my_id = mysql_real_escape_string($my_id);
$member_mid = mysql_real_escape_string($member_mid);

// Query for content
$query = "SELECT *\n FROM `users`\n WHERE user_id = $member_mid\n";

// Query for all members
$members_query = "SELECT *\n FROM `users`\n WHERE 1 LIMIT 100";

// Query for a member's spheres
$membersspheres_query = "SELECT sphere_memberships.*, spheres.sphere_id, spheres.sphere_name\n" .
"FROM `sphere_memberships`\n" .
"LEFT OUTER JOIN `spheres` ON sphere_memberships.sphere_id = spheres.sphere_id\n" .
"WHERE user_id = $member_mid AND spheres.type < 2";

if(!empty($member_mid) && is_numeric($member_mid)) {

$result = mysql_query($query) or die(mysql_error());
$memberData = mysql_fetch_array($result);
}

// Build member variables
$member_firstname = stripslashes($memberData['firstname']);
$member_lastname = stripslashes($memberData['lastname']);
$member_joindate = stripslashes($memberData['joindate']);
$member_email = stripslashes($memberData['email']);
$member_birthday = stripslashes($memberData['birthday']);
$member_dir = base64_encode($member_email);
$member_profilepic = stripslashes($memberData['profilepic']);
$member_gender = stripslashes($memberData['gender']);
$member_bio = stripslashes($memberData['bio']);

$member_gendertype = array("Prefer not to say","Male","Female");
$member_pronoun = array("their","his","her");

// Page content follows

include("top-header.php");

?>
<title>Spheres</title>
</head>

<?php

include("top-nav.php");
include("sub-nav.php");



// Profile control



if(!empty($member_mid)) { // Displaying an actual profile

	if(empty($memberData)) {
		echo "Not a user.";
	} else {
?>
<!-- Sphere name -->
<div id="rightmain">
<p><?php echo $member_firstname ?> joined Spheres on <?php echo date("F j, Y", $member_joindate) . " at " . date("g:i a", $member_joindate)  ?></p>
<h4><?php echo $member_firstname ?>'s Spheres</h4>

	<div id="multiDisplay">
	<?php
	// Build MySpheres here
	$myresult = mysql_query($membersspheres_query);
	
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
<div id="leftmain">
<h3>Welcome to <?php echo $member_firstname ?>'s Profile!</h3>

<?php 
	if(!empty($memberData['profilepic'])) {
		$MemberProPic = urlencode(base64_encode($memberData['email'])) . "/" . $memberData['profilepic'];
	} else {
		$MemberProPic = "../includes/profile_def.png";
	}
echo "<img src=\"/slir/w150-h150-c1:1/assets/" . $MemberProPic . "\" />\n";

?>

<ul>
<li>Name: <?php echo "" . $member_firstname . " " . $member_lastname . ""; ?></li>
<li>Gender: <?php echo "" . $member_gendertype[$member_gender] . ""; ?></li>
<li><?php echo ucfirst($member_pronoun[$member_gender]) ; ?> bio: <?php echo "<p>" . $member_bio . "</p>"; ?></li>
</ul>

</div>
<?php
}
} else { // Displaying member landing page
?>
<div id="main">
<h3>Member page</h3>
<p>Discover members!</p>
<div id="multiDisplay">
<?php

	// Build All Members here
	$membersresult = mysql_query($members_query) or die(mysql_error());
	while ($MemberData = mysql_fetch_array($membersresult, MYSQL_ASSOC)) {
		if(!empty($MemberData['profilepic'])) {
			$MemberProPic = urlencode(base64_encode($MemberData['email'])) . "/" . $MemberData['profilepic'];
		} else {
			$MemberProPic = "../includes/profile_def.png";
		}
	echo "<a href=\"member.php?mid=" . $MemberData['user_id'] . "\" title=\"" . $MemberData['firstname'] . " " . $MemberData['lastname'] . "\">" . 
	"<span class=\"memberdisplay\">" . 
	"<img src=\"/slir/w100-h100-c1:1/assets/" . $MemberProPic . "\" />\n".
	stripslashes($MemberData['firstname']) . 
	"</span>" . 
	"</a>\n";
	
	}

?>
</div>
</div>


<?php
}
?>
<div id="endmain"></div>
<?php
include("sub-footer.php");
include("footer.php");

?>