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
<h3>Spheres Privacy Policy</h3>

<h4>Our Commitment To Privacy</h4>

<p>Your privacy is important to us. To better protect your privacy we provide this notice explaining our online information practices and the choices you can make about the way your information is collected and used. To make this notice easy to find, we make it available on our homepage and at every point where personally identifiable information may be requested.</p>

<h4>The Information We Collect</h4>

<p>This notice applies to all information collected or submitted on the Spheres website. On some pages, you can share information, update your profile, and register to receive materials. The types of personal information collected at these pages are:</p>

<p>
<ul>
<li>Name</li>
<li>Email address</li>
<li>Geographic latitute and longitudinal coordinates</li>
<li>Gender</li>
<li>Birthday</li>
<li>Profile Picture</li>
<li>Any other information knowingly volunteered</li>
</ul>
</p>

<h4>The Way We Use Information</h4>

<p>We use the information we receive about you in connection with the services and features we provide to you and other users. For example, we may use the information we receive about you:</p>

<p>
<ul>
<li>as part of our efforts to keep Spheres safe and secure;</li>
<li>to provide you with location features and services, like telling you when something is going on nearby;</li>
<li>and to measure or understand the effectiveness of new features.</li>
</ul>
</p>

<p>Granting us this permission not only allows us to provide Spheres as it exists today, but it also allows us to provide you with innovative features and services we develop in the future that use the information we receive about you in new ways.</p>

<h4>Our Commitment To Data Security</h4>

<p>Your Spheres account is protected by a password for your privacy and security. You need to prevent unauthorized access to your account and personal information by selecting and protecting your password appropriately, and limiting access to your computer and browser by signing off after you have finished accessing your account.</p>

<p>Spheres stirves to safeguard user information to ensure that user account information is kept private. However, Spheres cannot guarantee the security of user account information. Unauthorized entry or use, hardware or software failure, and other factors, may compromise the security of user information at any time.</p>

<p>The Website may contain links to other sites. Spheres is not responsible for the privacy policies and/or practices on other sites. When linking to another site, you should read the privacy policy stated on that site. This Privacy Policy only governs information collected on the Website.</p>

<h4>How You Can Access Or Correct Your Information</h4>

<p>Spheres allows you to access the following information about you for the purpose of viewing, and in certain situations, updating that information and ensuring that it is accurate and complete. You can access this information on the Spheres website by visiting the user settings page. This list will change as Spheres continues to grow.</p>

<p>
<ul>
<li>Name</li>
<li>Email address</li>
<li>Gender</li>
<li>Birthday</li>
<li>Profile Picture</li>
</ul>
</p>

<p>To protect your privacy and security, we will also take reasonable steps to verify your identity before granting access or making corrections.</p>

<h4>How To Contact Us</h4>

<p>Should you have other questions or concerns about these privacy policies, please send us an email at <a href="mailto:julienroger@gmail.com">julienroger@gmail.com</a>.</p>
</div>
<div id="endmain">
</div>
<?php

include("sub-footer.php");
include("footer.php");

?>