<?php  
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 16, 2011
Last updated: November 19, 2011

*/

if(preg_match("/".basename(__FILE__)."/i",$_SERVER['REQUEST_URI']))  
{  
 die("Direct access is not allowed");  
}

	$query = "SELECT * FROM `spheres` LIMIT 50"; // Include order by distance, set a reasonable limit, possibly make this an AJAX event to update when the user moves
	$result = mysql_query($query) or die(mysql_error());

function listSpheres($result) {
	$sphere_num = 1;
	while ($sphereData = mysql_fetch_array($result, MYSQL_ASSOC)) {
    	printf("<div id=\"sphere\"> %s. %s | %s | %s | %s | %s | %s </div><br />", $sphere_num, stripslashes($sphereData['sphere_name']), $sphereData['lat'], $sphereData['long'], $sphereData['rad'], date("F j, Y, g:i a", $sphereData['timestamp']), $sphereData['creator_id']);
    	$sphere_num = $sphere_num + 1;
	}
}	

function drawCircles($result) {
	$sphere_num1 = 1;
	while ($sphereData = mysql_fetch_array($result, MYSQL_ASSOC)) {
		if($sphereData['type']==0){
		echo "var circle_" . $sphereData['sphere_id'] . " = new google.maps.Circle({" .
			"center: new google.maps.LatLng(" . $sphereData['lat'] . "," . $sphereData['long'] . ")," .
     		"map: map," .
			"radius: " . $sphereData['rad']/100 . "," .
		    "fillColor: '#0000ff'," .
		    "fillOpacity: 0.2," . 
		    "strokeColor: '#0000ff'," .
		    "strokeOpacity: 1," .
		    "strokeWeight: 1" .
		   "});\n";
		echo "var marker_" . $sphereData['sphere_id'] . " = new google.maps.Marker({" .
			"position: new google.maps.LatLng(" . $sphereData['lat'] . "," . $sphereData['long'] . ")," .
     		"map: map," .
     		"icon: \"includes/blue_dot.png\"," .
     		"title: \"" . stripslashes($sphereData['sphere_name']) . "\"" .
		   "});\n";
		   } elseif($sphereData['type']==1) {
		echo "var circle_" . $sphereData['sphere_id'] . " = new google.maps.Circle({" .
			"center: new google.maps.LatLng(" . $sphereData['lat'] . "," . $sphereData['long'] . ")," .
     		"map: map," .
			"radius: " . $sphereData['rad']/100 . "," .
		    "fillColor: '#00ff00'," .
		    "fillOpacity: 0.2," . 
		    "strokeColor: '#00ff00'," .
		    "strokeOpacity: 1," .
		    "strokeWeight: 1" .
		   "});\n";	
		echo "var marker_" . $sphereData['sphere_id'] . " = new google.maps.Marker({" .
			"position: new google.maps.LatLng(" . $sphereData['lat'] . "," . $sphereData['long'] . ")," .
     		"map: map," .
     		"icon: \"includes/blue_dot.png\"," .
     		"title: \"" . stripslashes($sphereData['sphere_name']) . "\"" .
		   "});\n";		   }
    	$sphere_num1 = $sphere_num1 + 1;
	}
}
?>  
	<style type="text/css">
	@import url(includes/pulsingdot.css);
		</style>

    <script type="text/javascript" src="//www.google.com/jsapi?autoload={'modules':[{name:'maps',version:3,other_params:'sensor=false'}]}"></script>
    <script type="text/javascript" src="includes/distancewidget.js"></script>
	<script type="text/javascript">

	function init() {
			var	mapCanvas = document.getElementById( 'map-canvas' );// get the page's canvas container 

				// define the Google Maps options
			var map_options = {
				    zoom: 15,
				    //center: myLatLng,
				    center: new google.maps.LatLng( 44.2256011963, -76.4957656860),
				    mapTypeControl: false,
				    mapTypeId: google.maps.MapTypeId.ROADMAP,
				    mapTypeControl: 0,
					overviewMapControl: 0,
					panControl: 0,
					zoomControl: 1,
					streetViewControl: 0,
					scrollwheel: 0,
					disableDoubleClickZoom: 1
				};
				// then create the map
			map = new google.maps.Map( mapCanvas, map_options );
				
		// Circles
		<?php
		drawCircles($result);
		?>			

				function displayMarker( position ){
					
					var myLatLng = new google.maps.LatLng( position.coords.latitude, position.coords.longitude );
					
					showSpheres(position.coords.latitude,position.coords.longitude);
							
					if (typeof(myMarker)!= "undefined") {
											
					myMarker.setPosition(myLatLng);
					map.setCenter(myLatLng);
					map.panTo(myLatLng);
					console.log( "Map Pan" );	

					} else {
						myMarker = new google.maps.Marker();
						var image = new google.maps.MarkerImage(
							'includes/RedDot.png',
							null, // size
							null, // origin
							new google.maps.Point( 8, 8 ), // anchor (move to center of marker)
							new google.maps.Size( 17, 17 ) // scaled size (required for Retina display icon)
						);
												
						myMarker.setOptions({
							flat: true,
							icon: image,
							map: map,
							optimized: false,
							position: myLatLng,
							title: 'This is you!',
							visible: true
						});
					
					map.setCenter(myLatLng);
					map.panTo(myLatLng);
					<?php
					if(preg_match("/"."admin.php"."/i",$_SERVER['REQUEST_URI'])){
						echo "".
							"// Sphere Maker\n".
					 " distanceWidget = new DistanceWidget({\n".
					    "map: map,\n".
					    "distance: 50, // Starting distance in m.\n".
					    "maxDistance: 2500, // Max distance in m.\n".
					    "color: '#000000',\n".
					    "activeColor: '#5599bb',\n".
					    "sizerIcon: new google.maps.MarkerImage('includes/resize-off.png'),\n".
						"activeSizerIcon: new google.maps.MarkerImage('includes/resize.png')\n".
					  "});\n";
					  }
					?>
					google.maps.event.addListener(distanceWidget, 'distance_changed', function() {
					  displayInfo(distanceWidget);
					});
					
					google.maps.event.addListener(distanceWidget, 'position_changed', function() {
					  displayInfo(distanceWidget);
					});
					
					console.log( "Marker Created" );	
			}
		}
					
				// cache the userAgent
				useragent = navigator.userAgent;					
					
					if (navigator.geolocation) {
	
					navigator.geolocation.getCurrentPosition(function (position) {displayMarker(position); console.log( "Initial Position Found" );},
					function( error ){
						console.log( "Something went wrong: ", error );
					},
					{timeout: 3000, maximumAge: 2700, enableHighAccuracy: true}
					
					);
					
					navigator.geolocation.watchPosition(function (position) {displayMarker(position); console.log( "Newer Position Found" );},
					function( error ){
						console.log( "Something went wrong with watch: ", error );
					},
					{timeout: 20000, maximumAge: 10000, enableHighAccuracy: true}	
					);
					}
}


function showSpheres(lat,lng) {
	if (lat=="" && lng=="") {
	  document.getElementById("auto_spheres").innerHTML="";
	  return;
	  } 
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  } else {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange=function() {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	    document.getElementById("auto_spheres").innerHTML=xmlhttp.responseText;
	    }
	  }
	var mypos = "my_lat=" + lat + "&my_lng=" + lng;
	xmlhttp.open("POST","includes/get_spheres.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(mypos);
	console.log( "Auto spheres request" );
}
	
	function displayInfo(widget) {
		var la = document.getElementById('sphere_lat');
		var lo = document.getElementById('sphere_long');
		var ra = document.getElementById('sphere_rad');
		la.value = widget.get('position').lat();
		lo.value = widget.get('position').lng();
		ra.value = widget.get('distance');
}

	google.maps.event.addDomListener(window, 'load', init);

	
	</script>
	


	<div id="map-canvas"><!-- map goes here --></div><br />	
	<div id="auto_spheres"></div>
