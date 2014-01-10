<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 3, 2011
Last updated: November 6, 2011

*/

include("session.php");

session_start();
logout_user();

header('Location: ../index.php');

die();

?>