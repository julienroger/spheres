<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 3, 2011
Last updated: November 13, 2011

*/

include("db.php");

function cookieMonster($email)
{
	$email = mysql_real_escape_string($email);

	// Creates cookie token
	$hash = hash('sha256', $email);
	function createSalt()
	{
	    $string = md5(uniqid(rand(), true));
	    return substr($string, 0, 4);
	}
	$salt = createSalt();
	$cookietoken = hash('sha256', $salt . $hash);
	
	$issuedate = time();
	
	// Updates token database
	$query = "INSERT INTO cookiemonster ( email, token, timestamp ) VALUES ( '$email' , '$cookietoken' , '$issuedate');";
	mysql_query($query) or die(mysql_error());
	
	$expiretime = time()+3600*24*7;
	
	// Sets the cookie
	setcookie("cm", $cookietoken, $expiretime, "/", "***.com" , 0, 1) or die("Could not send cm cookie.");
}

function destroyCM($email, $cookietoken)
{
	$email = mysql_real_escape_string($email);
	$cookietoken = mysql_real_escape_string($cookietoken);
	$query = "DELETE FROM cookiemonster WHERE email = '$email' AND token  = '$cookietoken';";
	mysql_query($query) or die(mysql_error());
}

function ohhai($email)
{
	$email = rawurlencode($email);
	$expiretime = time()+3600*24*7*52;
	// Sets the cookie
	setcookie("um", $email, $expiretime, "/", "***.com" , 0, 1) or die("Could not send um cookie.");
}

function validCookie($email, $cookietoken)
{
	$email = mysql_real_escape_string($email);
	$cookietoken = mysql_real_escape_string($cookietoken);
	$query = "SELECT timestamp, valid FROM cookiemonster WHERE email = '$email' AND token = '$cookietoken';";
	$result = mysql_query($query);
	if(mysql_num_rows($result) != 1) // No token exists (or there are too many - that's bad)
		return false;
	else
	{
		$cookiedata = mysql_fetch_array($result, MYSQL_ASSOC);
		$timestamp = $cookiedata['timestamp'];
		$valid = $cookiedata['valid'];
		
		$timeleft = $timestamp - time() + 3600*24*7;
		
		if($valid == 1 && $timeleft>0)
			return true;
		else
			return false;
	}
}

function validateUser()
{
    session_regenerate_id(); // this is a security measure    
    $_SESSION['valid'] = 1;
    $_SESSION['user_email'] = $_POST['email'];
    $email = mysql_real_escape_string($_SESSION['user_email']);
    $query = "SELECT user_id, birthday, displayname, lastname, firstname, joindate, profilepic, gender, bio FROM users WHERE email = '$email';";
    $result = mysql_query($query);
    $userdata = mysql_fetch_array($result, MYSQL_NUM);
    $_SESSION['user_id'] = $userdata[0];
    $_SESSION['user_birthday'] = $userdata[1];
    $_SESSION['user_display'] = $userdata[2];
    $_SESSION['user_lastname'] = $userdata[3];
    $_SESSION['user_firstname'] = $userdata[4];
    $_SESSION['user_joindate'] = $userdata[5];
    $_SESSION['user_profilepic'] = $userdata[6];
    $_SESSION['user_gender'] = $userdata[7];
    $_SESSION['user_bio'] = $userdata[8];
}

function reValidateUser($email)
{
	session_regenerate_id(); // this is a security measure    
    $_SESSION['valid'] = 1;
    $email = mysql_real_escape_string($email);
    $query = "SELECT user_id, email, birthday, displayname, lastname, firstname, joindate, profilepic, gender, bio FROM users WHERE email = '$email';";
    $result = mysql_query($query);
    $userdata = mysql_fetch_array($result, MYSQL_NUM);
    $_SESSION['user_id'] = $userdata[0];
    $_SESSION['user_email'] = $userdata[1];
    $_SESSION['user_birthday'] = $userdata[2];
    $_SESSION['user_display'] = $userdata[3];
    $_SESSION['user_lastname'] = $userdata[4];
    $_SESSION['user_firstname'] = $userdata[5];
    $_SESSION['user_joindate'] = $userdata[6];
    $_SESSION['user_profilepic'] = $userdata[7];
	$_SESSION['user_gender'] = $userdata[8];
	$_SESSION['user_bio'] = $userdata[9];

}

function isLoggedIn()
{
    if(isset($_SESSION['valid']) && $_SESSION['valid'])
        return true;
    elseif(isset($_COOKIE["um"]) && isset($_COOKIE["cm"]))
    {
    		if(validCookie(urldecode($_COOKIE["um"]), $_COOKIE["cm"]) == 1)
    		{
    			reValidateUser(urldecode($_COOKIE["um"]));
    			destroyCM($_COOKIE["um"], $_COOKIE["cm"]); // Destroy CM of cookie just used
    			cookieMonster(urldecode($_COOKIE["um"])); // Issue new cookiemonster
    			return true;
    		}
    		else
    			return false;
    }
    else
    	return false;
}

function validSession()
{
	if(isset($_SESSION['valid']) && $_SESSION['valid'])
	return true;
	else
	return false;
}

function logout_user()
{
	$email = $_SESSION['user_email'];
	$email = mysql_real_escape_string($email);
	$query = "UPDATE cookiemonster SET valid = 0 WHERE email = '$email';";
	mysql_query($query);
	
	$_SESSION = array(); // Destroy all of the session variables
	session_destroy();
	// Invalidate cookie token
	setcookie("cm", "0", time()-3600*24*7, "/", "***.com" , 0, 1) or die("Could not destroy logout cookie.");
}


?>