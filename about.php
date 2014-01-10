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
<h3>About Spheres</h3>

<h4>About the Project</h4>
<p>Currently in private alpha,  Spheres is a websote that models real-world geographic networks. Being in alpha stage, there are probably tons of bugs, speling mistakes, security vulnerabilities, coding inefficiencies, stylistic blunders, and who knows what else. Please <a href="mailto:julienroger@gmail.com">let me know</a> if you find any - feedback and continued improvement is what makes good things great.</p>

<h4>About the Name</h4>
<p>Spheres? The idea was that the website would model places as informational spheres (like a 'sphere' of influence). The website needs a name change (spheres.com and thespheres.com are both taken), so feedback on naming/branding would be great too.</p>

<h4>About the Reason</h4>
<p>Pretty much just to learn MySQL/PHP/JavaScript. How's that been going? Great! I've learned a ton about web development, and stuff that I didn't expect to learn about, like <a href="http://en.wikipedia.org/wiki/Vincenty%27s_formulae">sweet ways to calculate distance</a>.</p>

<h4>About the Creator</h4>
<p>It was <a href="http://www.julienroger.com">me</a>.</p>
</div>
<div id="endmain">
</div>
<?php

include("sub-footer.php");
include("footer.php");

?>