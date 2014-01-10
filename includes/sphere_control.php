<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 16, 2011
Last updated: November 19, 2011

*/

include("db.php");
include("validator.php");
include("session.php");

session_start();

// Retrieve our data from POST
$sphere_name = $_POST['sphere_name'];
$sphere_lat = round($_POST['sphere_lat'],10);
$sphere_long = round($_POST['sphere_long'],10);
$sphere_rad = round($_POST['sphere_rad']*100);
$sphere_id = $_POST['sphere_id'];
$creator_id = $_SESSION['user_id'];
$sphere_access = $_POST['sphere_access'];
$timestamp = time();

// Sanatize non-hashed stuff
$sphere_name = htmlspecialchars(mysql_real_escape_string($sphere_name));
$sphere_lat = htmlspecialchars(mysql_real_escape_string($sphere_lat));
$sphere_long = htmlspecialchars(mysql_real_escape_string($sphere_long));
$sphere_rad = htmlspecialchars(mysql_real_escape_string($sphere_rad));
$sphere_id = htmlspecialchars(mysql_real_escape_string($sphere_id));

function makesphere($cid, $name, $timest, $lat, $long, $rad, $type) {
	$query = "INSERT INTO `spheres` ( `creator_id`, `sphere_name`, `timestamp`, `lat`, `long`, `rad`, `type` ) VALUES ( '$cid', '$name', '$timest', '$lat', '$long', '$rad', '$type' )";
	mysql_query($query) or die(mysql_error());
}

function deletesphere($id) {
	$query = "DELETE FROM `spheres` WHERE `sphere_id` = '$id'";
	mysql_query($query) or die(mysql_error());
}

function joinsphere($mid, $sid) {
	$timenow = time();
	$query = "INSERT INTO `sphere_memberships` ( `user_id`, `sphere_id`, `timestamp` ) VALUES ( '$mid', '$sid', '$timenow' )";	
	mysql_query($query) or die(mysql_error());
}

function leavesphere($mid, $sid) {
	$query = "DELETE FROM `sphere_memberships` WHERE `user_id` = '$mid' AND `sphere_id` = '$sid'";
	mysql_query($query) or die(mysql_error());
}

if(!empty($_POST['joinsphere'])) {
	joinsphere($creator_id, $sphere_id);
} elseif(!empty($_POST['leavesphere'])) {
	leavesphere($creator_id, $sphere_id);
} elseif(!empty($_POST['delete_sphere'])) {
	if (!empty($sphere_id)) { // Delete a sphere
		deletesphere($sphere_id);
	}	
} elseif(!empty($_POST['make_sphere'])) {
	// Make a new sphere
	if(!empty($creator_id) && !empty($sphere_name) && !empty($sphere_lat) && !empty($sphere_long) && !empty($sphere_rad)) {
		makesphere($creator_id, $sphere_name, $timestamp, $sphere_lat, $sphere_long, $sphere_rad, $sphere_access);
	} else {
	$errmsg = "?e=NotEnoughInfoMake"; // Insufficient info
	}
}


// End for all

mysql_close($connection);
		
header('Location: ../'. basename($_SERVER['HTTP_REFERER']) . $errmsg);
			
?>