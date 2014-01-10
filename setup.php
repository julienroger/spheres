<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xml:lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Project Jupiter</title>
</head>
<body>
<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 3, 2011
Last updated: November 16, 2011

*/

include("includes/db.php");


#######################
##   Create table    ##
#######################


$sql = "CREATE TABLE sphere_memberships (
	user_id INT(11) REFERENCES users (user_id),
	sphere_id INT(11) REFERENCES spheres (sphere_id),
	timestamp INT(12) NOT NULL,
	PRIMARY KEY (user_id, sphere_id)
)";



$sqlcm = "CREATE TABLE cookiemonster (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(64) NOT NULL,
    token VARCHAR(64) NOT NULL,
    timestamp INT(12) NOT NULL,
    used BOOLEAN NOT NULL DEFAULT 0,
    PRIMARY KEY(id)
)";

#######################
##  Insert Fields   ##
#######################

$sql1 = "ALTER TABLE users (
	ADD COLUMN `joindate` DATETIME NOT NULL AFTER `salt`

)";

/*	ADD COLUMN `firstname` VARCHAR(64) AFTER `joindate`,
	ADD COLUMN `lastname` VARCHAR(64) AFTER `firstname`,
	ADD COLUMN `displayname` VARCHAR(64) AFTER `lastname`,
	ADD COLUMN `birthday` DATE AFTER `displayname` */

echo time() . "<br />";

mysql_query($sql);
printf('<br /> Executing query... ' . mysql_error());

mysql_close($connection);

//$email = "julienroger@gmail.com";
//$email = base64_encode($email);
//mkdir("assets/". $email);




die("<br /><br />Done.");

?>

</body>
</html>