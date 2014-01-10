<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 3, 2011
Last updated: November 11, 2011

*/

include("db.php");
include("session.php");

session_start(); //must call session_start before using any $_SESSION variables

$redirect = $_GET['redirect'];
$email = $_POST['email'];
$password = $_POST['password'];
//connect to the database here
$email = mysql_real_escape_string($email);
$query = "SELECT password, salt FROM users WHERE email = '$email';";
$result = mysql_query($query);
if(mysql_num_rows($result) < 1) //no such user exists
{
    header('Location: ../index.php?err=0');
    die();
}
$userData = mysql_fetch_array($result, MYSQL_ASSOC);
$hash = hash('sha256', $userData['salt'] . hash('sha256', $password) );
if($hash != $userData['password']) //incorrect password
{
    header('Location: ../index.php?err=0');
    die();
}
else
{
	validateUser(); //sets the session data for this user
	ohhai($email);
	cookieMonster($email);
}
//redirect to another page or display "login success" message
    header('Location: ../' . $redirect);



mysql_close($connection);


?>