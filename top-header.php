<?php
include_once 'includes/wurfl-config.inc';
$requestingDevice = $wurflManager->getDeviceForHttpRequest($_SERVER);
if($requestingDevice->getCapability("is_wireless_device")=='true') {
	header('Location: http://m.inthespheres.com');
	die();
} else {
	// Not mobile
}

//session_start();
$pathin = pathinfo($_SERVER["REQUEST_URI"]);
if(empty($_SESSION['user_firstname']) && !empty($_SESSION['user_id']) && basename($_SERVER["REQUEST_URI"],"." . $pathin['extension'])!="profile") {
	header('Location: profile.php?p=55');
	die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xml:lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- <link href="includes/style.css" rel="stylesheet" type="text/css"> -->
<link rel="SHORTCUT ICON" href="includes/icon.ico"/>
<link rel="stylesheet" type="text/css" media="screen" href="includes/style.php">
<link rel="stylesheet" type="text/css" href="includes/colortip-1.0-jquery.css"/>
<script type="text/javascript" src="includes/jquery.js"></script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-91059-11']);
  _gaq.push(['_setDomainName', 'inthespheres.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>