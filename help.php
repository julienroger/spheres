<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 24, 2011
Last updated: November 24, 2011

*/

include("includes/db.php");
include("includes/session.php");

session_start();

// If the user has not logged in
if(!isLoggedIn())
{
	$logged_in = 0;
    header('Location: index.php?redirect='. basename($_SERVER['PHP_SELF']) . "?mid=" . $member_mid);
    die();
}
else
	$logged_in = 1;

// Page content follows

include("top-header.php");

?>
<title>Spheres</title>
</head>

<?php

include("top-nav.php");
include("sub-nav.php");

?>
<div id="main">
<h3>Help & Support</h3>

<p>Since Spheres is still under development in its Private Alpha stage, there will certainly be bugs, glitches, and other errors. Please feel free to report these and help improve Spheres.</p>
<p>Thanks, <br />- Julien</p>
</div>
<div id="endmain">
</div>
<?php

include("sub-footer.php");
include("footer.php");

?>