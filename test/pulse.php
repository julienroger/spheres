<?php  
/*

Julien Roger
http://www.julienroger.com
julienroger@gmail.com

November 16, 2011
Last updated: November 16, 2011

*/
include("../includes/db.php");

	$query = "SELECT * FROM `spheres`";
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
		echo "var circle_" . $sphereData['sphere_id'] . " = new google.maps.Circle({" .
			"center: new google.maps.LatLng(" . $sphereData['lat'] . "," . $sphereData['long'] . ")," .
     		"map: map," .
			"radius: " . $sphereData['rad']/100 . "," .
		    "fillColor: '#0000ff'," .
		    "fillOpacity: 0.25," . 
		    "strokeColor: '#0000ff'," .
		    "strokeOpacity: 1," .
		    "strokeWeight: 1" .
		   "});";
    	$sphere_num1 = $sphere_num1 + 1;
	}
}
?>
<html>
<head>
	<title>Jupiter Map Test</title>
	<meta name="viewport" content="width=800, initial-scale=1.0, user-scalable=no">
</head>
<body>
	<style>
	@-moz-keyframes pulsate {
		from {
			-moz-transform: scale(0.25);
			opacity: 1.0;
		}
		95% {
			-moz-transform: scale(1.3);
			opacity: 0;
		}
		to {
			-moz-transform: scale(0.3);
			opacity: 0;
		}
	}
	@-webkit-keyframes pulsate {
		from {
			-webkit-transform: scale(0.25);
			opacity: 1.0;
		}
		95% {
			-webkit-transform: scale(1.3);
			opacity: 0;
		}
		to {
			-webkit-transform: scale(0.3);
			opacity: 0;
		}
	}
	/* get the container that's just outside the marker image, 
		which just happens to have our Marker title in it */
	#map_canvas div.gmnoprint[title="I might be here"] {
		-moz-animation: pulsate 1.5s ease-in-out infinite;
		-webkit-animation: pulsate 1.5s ease-in-out infinite;
		border:1pt solid #fff;
		/* make a circle */
		-moz-border-radius:51px;
		-webkit-border-radius:51px;
		border-radius:51px;
		/* multiply the shadows, inside and outside the circle  Colours used to be #06f*/
		-moz-box-shadow:inset 0 0 5px #f00, inset 0 0 5px #f00, inset 0 0 5px #f00, 0 0 5px #f00, 0 0 5px #f00, 0 0 5px #f00;
		-webkit-box-shadow:inset 0 0 5px #f00, inset 0 0 5px #f00, inset 0 0 5px #f00, 0 0 5px #f00, 0 0 5px #f00, 0 0 5px #f00;
		box-shadow:inset 0 0 5px #f00, inset 0 0 5px #f00, inset 0 0 5px #f00, 0 0 5px #f00, 0 0 5px #f00, 0 0 5px #f00;
		/* set the ring's new dimension and re-center it */
		height:51px!important;
		margin:-18px 0 0 -18px;
		width:51px!important;
	}
	/* hide the superfluous marker image since it would expand and shrink with its containing element */
/*	#map_canvas div[style*="987654"][title] img {*/
	#map_canvas div.gmnoprint[title="I might be here"] img {
		display:none;
	}
	/* compensate for iPhone and Android devices with high DPI, add iPad media query */
	@media only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (device-width: 768px) {
		#map_canvas div.gmnoprint[title="I might be here"] {
			margin:-10px 0 0 -10px;
		}
	}
	</style>

    <script type="text/javascript" src="//www.google.com/jsapi?autoload={'modules':[{name:'maps',version:3,other_params:'sensor=false'}]}"></script>
    <script type="text/javascript" src="distancewidget.js"></script>
    <script type="text/javascript">
	       	
	function init() {
			var	mapCanvas = document.getElementById( 'map_canvas' );// get the page's canvas container 

				// define the Google Maps options
			var map_options = {
				    zoom: 16,
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
					
					if (typeof(myMarker)!= "undefined") {
											
					myMarker.setPosition(myLatLng);
					map.setCenter(myLatLng);
					map.panTo(myLatLng);
					console.log( "Map Pan" );	

					} else {
						myMarker = new google.maps.Marker();
						var image = new google.maps.MarkerImage(
							'../includes/RedDot.png',
							null, // size
							null, // origin
							new google.maps.Point( 8, 8 ), // anchor (move to center of marker)
							new google.maps.Size( 17, 17 ) // scaled size (required for Retina display icon)
						);
						
						//var distanceWidget = new DistanceWidget(map);
						
						myMarker.setOptions({
							flat: true,
							icon: image,
							map: map,
							optimized: false,
							position: myLatLng,
							//position: new google.maps.LatLng( 44.2256011963, -76.4957656860),
							title: 'I might be here',
							visible: true
						});
					
					map.setCenter(myLatLng);
					map.panTo(myLatLng);
					
							// Sphere Maker
					  distanceWidget = new DistanceWidget({
					    map: map,
					    distance: 50, // Starting distance in km.
					    maxDistance: 2500, // Twitter has a max distance of 2500km.
					    color: '#000000',
					    activeColor: '#5599bb',
					  });
					
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
					{timeout: 300, maximumAge: 200, enableHighAccuracy: true}	
					);
				}	
	

}
	
	
	function displayInfo(widget) {
		var info = document.getElementById('info');
		info.innerHTML = 'Position: ' + widget.get('position') + ', distance: ' +
		widget.get('distance') + " meters";
}
	
	
	
	
	google.maps.event.addDomListener(window, 'load', init);

	
	</script>

<style type="text/css">

#map_canvas {width: 800px; height: 400px;}

</style>
	<div id="map_canvas"><!-- map goes here --></div><br />
	<div id="info"></div>
</body>
</html>