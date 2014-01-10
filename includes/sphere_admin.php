<?php  
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 16, 2011
Last updated: November 19, 2011

*/
?>
<br /><br />

<h3>Admin</h3>

<div id="">
<b>Spheres List</b>
<?php

listSpheres($result);

?>
</div>



<div id="">
<b>Make Sphere</b>

<form name="make_sphere" action="includes/sphere_control.php" method="post">
   Sphere Name: <input value="" type="text" name="sphere_name" /><br />
   Sphere Latitude: <input value="" id="sphere_lat" type="text" name="sphere_lat" /><br />
   Sphere Longitude: <input value="" id="sphere_long" type="text" name="sphere_long" /><br />
   Sphere Radius (in Meters): <input value="" id="sphere_rad" type="text" name="sphere_rad" /><br />
   Sphere access type:<br />
	<input type="radio" name="sphere_access" value=0 checked> Public<br />
	<input type="radio" name="sphere_access" value=1> Private<br />
	<input type="radio" name="sphere_access" value=2> Secret<br />
    <input type="submit" name="make_sphere" value="Make Sphere" />
</form>
</div>

<div id="">
<b>Delete Sphere</b>

<form name="delete_sphere" action="includes/sphere_control.php" method="post">
   Sphere ID: <input value="" type="text" name="sphere_id" /><br />
    <input type="submit" name="delete_sphere" value="Delete Sphere" />
</form>

</div>