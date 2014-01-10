<?php
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 21, 2011
Last updated: November 21, 2011

*/

include("includes/db.php");
include("includes/session.php");
include("includes/components.php");

$profile_situaiton = $_GET['p'];
if(empty($profile_situaiton)) {
	$profile_situaiton = 0;
}

session_start();
//if the user has not logged in
if(!isLoggedIn())
{
	$logged_in = 0;
    header('Location: index.php?redirect='. basename($_SERVER['PHP_SELF']));
    die();
}
else
	$logged_in = 1;
	
	
// Need a way to detect whether a first name is set or not. If not, ask them!
	
	
// Gender default selector
if($_SESSION['user_gender'] == 1) { // user is male
	$opt_pns = "";
	$opt_m = "selected='selected'";
	$opt_f = "";
} elseif($_SESSION['user_gender'] == 2) { // user is female
	$opt_pns = "";
	$opt_m = "";
	$opt_f = "selected='selected'";
} else {
	$opt_pns = "selected='selected'";
	$opt_m = "";
	$opt_f = "";
}
	
//page content follows

include("top-header.php");

?>
<script type="text/javascript" src="includes/passstr.js"></script>

<title>Spheres</title>

<?php

include("top-nav.php");
include("sub-nav.php");

?>

<!-- <div class="rightfloater">
<a href="#profile">Change your Profile</a>
<a href="#email">Change your Email Address</a>
<a href="#password">Change your Password</a>
</div> -->

<div id="main">

<h3>Profile</h3>

<div id="Profile pic">

<?php

if(is_file("assets/" . urlencode(base64_encode($_SESSION['user_email'])) . "/" . $_SESSION['user_profilepic']))
{
	$profile_pic = "/slir/w150-h150-c1:1/assets/" . urlencode(base64_encode($_SESSION['user_email'])) . "/" . $_SESSION['user_profilepic'];
	echo "<img src=\"$profile_pic\" />";
}
else
echo "No profile pic.";


?>
</div>
<?php if($profile_situaiton == 55) {echo "<h3>Please enter a name to use Spheres.</h3>";}
 ?>
<div class="formarea">
<a name="profile"><h3>Change your profile</h3></a>
<form id="userProfile" name="changeprofile" enctype="multipart/form-data" action="includes/change_profile.php" method="post">

	<div class="formLine"><div class="field"><label>Profile Picture: </label></div>
	<div class="formField"><input id="file" type="file" name="profile_picture" class="formStyle" />
	</div></div>
	

    
    <div class="formLine">
    <?php if($profile_situaiton == 55) {echo "<span class=\"bubbletipspan\" title=\"You must enter a first and last name before using Spheres.\">" ;} ?>
    <div class="field">
    <label>Name: </label></div>
    <div class="formField"><input value=<?php echo "\"" . $_SESSION['user_firstname'] . "\"" ?> type="text" name="new_firstname" class="formStyle <?php if($profile_situaiton == 55) {echo "importantField";} ?>"/>  
    <input value=<?php echo "\"" . $_SESSION['user_lastname'] . "\"" ?> type="text" name="new_lastname"  class="formStyle <?php if($profile_situaiton == 55) {echo "importantField";} ?>"/>
    </div>
     <?php if($profile_situaiton == 55) {echo "</span>" ;} ?>
    </div>
    
    
    <div class="formLine"><div class="field"><label>Gender: </label></div>
    <div class="formField">
    <select name="new_gender">
    <option value=0 <?php echo $opt_pns; ?>> Prefer not to say</option>
    <option value=1 <?php echo $opt_m; ?>> Male</option>
    <option value=2 <?php echo $opt_f; ?>> Female</option>
    </select>
    </div></div>
    
    <div class="formLine"><div class="field"><label>About Me: </label></div>
    <div class="formField">
    <textarea class="formStyle" cols="42" rows="12" id="bio" name="new_bio" /><?php if(empty($_SESSION['user_bio'])) {
    echo "Write a bit about yourself...";
    } else { echo $_SESSION['user_bio'];
    } ?></textarea>
    </div></div>    
    
    <input type="hidden" name="old_email" value=<?php echo "\"" . $_SESSION['user_email'] . "\"" ?> />
    <input type="hidden" name="profiletype" value="profile" />
    <input class="reddButton rightButton" type="submit" value="Update Profile" />

</form>
</div>

<div class="formarea">
<a name="email"><h3>Change your Email Address</h3></a>
<form id="userProfile" name="changeemail" enctype="multipart/form-data" action="includes/change_profile.php" method="post">   
    
    <div class="formLine"><div class="field"><label>Email address:  </label><span class="tooltipspan" title="This is your login credential as well.">?</span></div>
    <div class="formField"><input value=<?php echo "\"" . $_SESSION['user_email'] . "\"" ?> type="text" name="new_email"  class="formStyle"/>
    </div></div>

    
    <div class="formLine"><div class="field"><label>Password: </label></div>
    <div class="formField"><input type="password" name="password"  class="formStyle"/>
    </div></div>
    
    <input type="hidden" name="old_email" value=<?php echo "\"" . $_SESSION['user_email'] . "\"" ?> />
    <input type="hidden" name="profiletype" value="email" />
    <input class="reddButton rightButton" type="submit" value="Change Email Address" />

</form>
</div>

<div class="formarea">
<a name="password"><h3>Change your Password</h3></a>
<form id="userProfile" name="changepass" enctype="multipart/form-data" action="includes/change_profile.php" method="post">
    
    <div class="formLine"><div class="field"><label>New Password: </label></div>
    <div class="formField"><input type="password" value="" name="pass1" class="formStyle" />
    <div id="iSM">
	<ul class="weak">
		<li id="iWeak"></li>
		<li id="iMedium"></li>
		<li id="iStrong""></li>
	</ul>
	Password Strength: <div id="StrengthIndicator">
	</div></div>
    </div></div>
        
    <div class="formLine"><div class="field"><label>New Password again: </label></div>
    <div class="formField"><input type="password" name="pass2"  class="formStyle"/>
    </div></div>
    
    <div class="formLine"><div class="field"><label>Old Password: </label></div>
    <div class="formField"><input type="password" name="password"  class="formStyle"/>
    </div></div>
    
    <input type="hidden" name="old_email" value=<?php echo "\"" . $_SESSION['user_email'] . "\"" ?> />
    <input type="hidden" id="passstrength" name="passstrength" value='' />
    <input type="hidden" name="profiletype" value="password" />
    <input class="reddButton rightButton" type="submit" value="Change Password" />

</form>
</div>

</div>
<div id="endmain">

<br /><br />
</div>
<?php
include("sub-footer.php");
include("footer.php");

?>