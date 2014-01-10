<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 20, 2011
Last updated: November 20, 2011

*/

include("db.php");
include("validator.php");
include("session.php");

session_start();

// Retrieve our data from POST
$my_lat = round($_POST['my_lat'],10);
$my_lng = round($_POST['my_lng'],10);
$my_id = $_SESSION['user_id'];

// Sanatize non-hashed stuff
$my_lat = mysql_real_escape_string($my_lat);
$my_lng = mysql_real_escape_string($my_lng);
$my_id = mysql_real_escape_string($my_id);

$super_query = "(SELECT *, ( 6371*100000 * acos( cos( radians($my_lat) ) * cos( radians( `lat` ) ) * cos( radians( `long` ) - radians($my_lng) ) + sin( radians($my_lat) ) * sin( radians( `lat` ) ) ) ) AS distance, \n" . 
"1 AS in_it,\n" . 
"spheres.sphere_id AS sphereid\n" . 
"FROM `spheres`\n" . 
"LEFT OUTER JOIN sphere_memberships \n" . 
"ON $my_id = sphere_memberships.user_id AND spheres.sphere_id = sphere_memberships.sphere_id\n" . 
"HAVING distance < `rad`\n" . 
"ORDER BY distance ASC LIMIT 0 , 10)\n" . 
"\n" . 
"UNION\n" . 
"\n" . 
"(SELECT *, ( 6371*100000 * acos( cos( radians($my_lat) ) * cos( radians( `lat` ) ) * cos( radians( `long` ) - radians($my_lng) ) + sin( radians($my_lat) ) * sin( radians( `lat` ) ) ) ) AS distance,\n" . 
"0 AS in_it,\n" . 
"spheres.sphere_id AS sphereid\n" . 
"FROM `spheres`\n" . 
"LEFT OUTER JOIN sphere_memberships \n" . 
"ON $my_id = sphere_memberships.user_id AND spheres.sphere_id = sphere_memberships.sphere_id\n" . 
"HAVING distance > `rad`\n" . 
"ORDER BY distance ASC LIMIT 0 , 10)\n" . 
"\n" . 
"ORDER BY in_it DESC, distance ASC;\n";

$access_levels = array("<img src=\"includes/blue_traffic.png\" />","<img src=\"includes/green_traffic.png\" />","<img src=\"includes/red_traffic.png\" />");

$result = mysql_query($super_query) or die(mysql_error());
$sphere_num2 = 1;
$last_in = 2;

while ($spheres = mysql_fetch_array($result, MYSQL_ASSOC)) {
		if($spheres['type'] == 2 && empty($spheres['user_id'])) {
		} else {
						if($last_in == 2 && $spheres['in_it']==1) {
						echo "<div class=\"spherebox\">\n<h3>Current Spheres</h3>";	
						$last_in = 0;
						}
						
				$sphere_type = $access_levels[$spheres['type']];
				$is_member = (!empty($spheres['user_id'])) ? "<span class=\"tooltipspan\" title=\"You are a member of this sphere.\"><img src=\"includes/green_checkmark_16.png\" /></span>":"<span class=\"tooltipspan\" title=\"You are not a member of this sphere.\"><img src=\"includes/xmark_16.png\" /></span>";
				if($spheres['in_it']==1) { // Spheres the user is in
					echo "<div id=\"init_" . $spheres['in_it'] ."\"><a href=\"sphere.php?sid=" . $spheres['sphereid'] . "\">" . stripslashes($spheres['sphere_name']) . "</a>" . 
				" " . $sphere_type .
				" " . $is_member .
				"</div>";
				$last_in = 1;
				} else { // Spheres the user is not in
				
						if($last_in == 1 && $spheres['in_it']==0) {
						echo "</div>";	
						$last_in = 0;
						}
						
						if(($last_in == 0 || $last_in == 2) && $spheres['in_it']==0) {
						echo "<div class=\"spherebox\">\n<h3>Nearby Spheres</h3>";	
						$last_in = -1;
						}
												
					echo "<div id=\"init_" . $spheres['in_it'] ."\"><a href=\"sphere.php?sid=" . $spheres['sphereid'] . "\">" . stripslashes($spheres['sphere_name']) . "</a>" . 
				" " . $sphere_type .
				" " . $is_member .
				"</div>";
				}
		
		
		}
    	$sphere_num2 = $sphere_num2 + 1;
}
echo "</div>\n<div class=\"pusher\"></div>\n";
mysql_close($connection);

?>
