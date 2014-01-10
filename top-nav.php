</head>
<body>

<div id="container">

<div id="top-nav">
<div id="top-nav-end">



<?php

if($logged_in == 1) {
	
	echo "<div id=\"inner-nav\">\n";
	
	echo "<a href=\"" . "index.php" . "\">" . "Home" . "</a>" . " | \n";
		
	echo "<a href=\"" . "sphere.php" . "\">" . "Spheres" . "</a>" . " | \n";
	
	echo "<a href=\"" . "member.php" . "\">" . "Members" . "</a>" . " | \n";
	
	echo "<a href=\"" . "profile.php" . "\">" . "My Profile" . "</a>" . " | \n";
	
	if($_SESSION['user_id'] == 1) echo "<a href=\"" . "admin.php" . "\">" . "Admin" . "</a>" . " | \n";
	
	echo "<a href=\"" . "includes/logout.php" . "\">" . "Logout" . "</a>\n";
	
	echo "</div>\n";


}
?>

</div>
</div>