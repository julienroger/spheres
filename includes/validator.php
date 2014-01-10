<?php

/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 3, 2011
Last updated: November 6, 2011

*/

/**
Validate an email address.
Provide email address (raw input)
Returns true if the email address has the email 
address format and the domain exists.
*/

function existingUser($email)
{
	$userExists = false;
	
	$email = mysql_real_escape_string($email);
	$query = "SELECT user_id FROM users WHERE email = '$email';";
	$result = mysql_query($query);
	
	if(mysql_num_rows($result) == 1) {
		$userExists = true;
	} else {
		$userExists = false;
	}
	
	return $userExists;
}

function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex) {
      $isValid = false;
   } else {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64) {
         // local part length exceeded
         $isValid = false;
      } elseif ($domainLen < 1 || $domainLen > 255) {
         // domain part length exceeded
         $isValid = false;
      } elseif ($local[0] == '.' || $local[$localLen-1] == '.') {
         // local part starts or ends with '.'
         $isValid = false;
      } elseif (preg_match('/\\.\\./', $local)) {
         // local part has two consecutive dots
         $isValid = false;
      } elseif (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
         // character not valid in domain part
         $isValid = false;
      } elseif (preg_match('/\\.\\./', $domain)) {
         // domain part has two consecutive dots
         $isValid = false;
      } elseif (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}
?>