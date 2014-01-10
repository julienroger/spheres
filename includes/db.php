<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 3, 2011
Last updated: November 6, 2011

*/

$host = "localhost";
$db = "***";
$dbuser = "***";
$dbpass = "***";

$connection = mysql_connect($host, $dbuser, $dbpass) or die(mysql_error());
$database = mysql_select_db($db) or die(mysql_error());
?>