<?php
header("Content-type: text/css");
/*

Julien Roger http://www.julienroger.com
November 6, 2011
Last updated: November 6, 2011

// TOP RIGHT BOTTOM LEFT

// cardinal: C41E3A
// Dark Cardinal: 7F0A1F
// Dark Dull Cardinal: 933646
// Light dull cardinal: E2788B
// Cardinal Scheme: http://colorschemedesigner.com/#5w11Tr6qew0w0
*/

$main = "#C41E3A";
$main_dark = "#7F0A1F";
$main_light = "";
$dull_dark = "#933646";
$dull_light = "#E2788B";

$black = "#000000";
$white = "#FFFFFF";


?>

html {
	height: 100%;
	}
	
body {
	padding: 0;
	margin: 0;
	height: 100%;
	background-color: #EEEEEE;
	font-family: Helvetica, Arial, sans-serif;
	color: #4D4D4D;
	font-size: 0.9em;
	}
	
a:link {
	text-decoration: none;
	color: #0000FF;
}

a:visited {
	text-decoration: none;
	color: #0000FF;
}

.error {
	font-weight: bold;
	color: <?=$main_dark?>;;
}

div#top-nav {
	width: 100%;
	height: 42px;
	text-align: left;
	position: fixed;
	top: 0;
	left: 0;
	font-size: 1.5em;
	background: <?=$main?>;
	background-image: url('header-bg.png');
	background-repeat: repeat-x;
	color: <?=$white?>;
	margin: 0;
	padding: 0 0 0 0;
	z-index: 12;
}

div#top-nav-end {
	width: 62%;
	margin: 0 auto;
	height: 100%;
	background-image: url('spheres_logo3.png');
	background-repeat: no-repeat;
	background-position: left bottom;
}

div#inner-nav {
	width: 62%;
	height: 62%;
	right: 0;
	bottom:0;
	position: absolute;
	text-align: center;
	font-size: 0.85em;
	background: <?=$dull_dark?>;
	color: <?=$white?>;
	margin: 0;
	padding: 0.1em 0 0 0;
	border-top: 1px solid;
	border-left: 1px solid;
	border-color: #E2788B;
	}

div#inner-nav a:link {
	color: <?=$white?>;
	text-decoration: none;
	}
	
div#inner-nav a:visited {
	color: <?=$white?>;
	text-decoration: none;
	}

div#container {
	min-height: 100%;
	position: relative;
	height: auto !important;
	height: 100%;
	}

div#wrapper {
	border: 1px solid #D9D9D9;
	border-bottom: 0;
	border-top: 0;
	margin: 42px auto 0 auto;
	padding: 0;
	font-size: 1em;
	width: 62%;
	background-color: #ffffff;
	-moz-box-shadow: rgba(0, 0, 0, 0.1) 0 0 2px 0px;
	-webkit-box-shadow: rgba(0, 0, 0, 0.1) 0 0 2px 0px;
	box-shadow: rgba(0, 0, 0, 0.1) 0 0 2px 0px;
	}
	
#wrapper p {

}
	
div#footer {
	margin-top: 0em;
	width: 100%;
	clear: both;
	border-top: 1px solid #D9D9D9;
	text-align: center;
	}

div#footer-end {
	width: 62%;
	background: #f9f9f9;
	color: #aaaaaa;
	border: 1px solid #D9D9D9;
	border-top: 0px;
	margin: 0 auto;
	padding: 1em 0 2em 0;
	-moz-box-shadow: rgba(0, 0, 0, 0.1) 0 0 2px 0px;
	-webkit-box-shadow: rgba(0, 0, 0, 0.1) 0 0 2px 0px;
	box-shadow: rgba(0, 0, 0, 0.1) 0 0 2px 0px;
	-moz-border-radius:  0 0 3px 3px / 0 0 3px 3px;
	-webkit-border-radius:  0 0 3px 3px / 0 0 3px 3px;
	border-radius: 0 0 3px 3px / 0 0 3px 3px;
	}
	
#footer ul {
	list-style-type: none;
	text-align: center;
	font-size: 0.85em;
}

#footer ul a:link {
	color: #666666;
}

#footer ul a:visited {
	color: #666666;
}

#footer ul a:hover {
	color: #444444;
}

#footer ul li {
	padding: 20px;
	display: inline;
}

#footer .copyright {
	font-size: .85em;
}

#map-canvas {
	width: 100%;
	height: 200px;
	z-index: 1;
	border: 0px solid;
	margin: 0;
}

#main {
	border: 0px solid;	
	float: left;
	margin: 5px 15px 5px 15px;
}

#leftmain {
	padding-left: 1%;
	border: 0px solid;	
	width: 61%;
	float: left;
	margin-top: 10px;
}

#rightmain {
	padding-left: 1%;
	border: 0px solid;
	width: 36%;
	float: right;
	margin-top: 10px;
}

#endmain {
	clear: both;
}

.formarea {
	margin-bottom: 40px;
	display: block;
	float: left;
	clear: both;
	width: 100%;
}

.rightfloater {
	float: right;	
	border: 0px solid;
	background: #f7f7f7;
	padding: 5px;
	font-size: 0.75em;
}

.rightfloater a:link {
	display: block;
	padding: 3px;
}

.formStyle {
background: #fcfcfc;
border: 1px solid #d9d9d9;
color: #4d4d4d;
font-family: inherit;
font-size: 12px;
outline: none;
padding: 3px;
-moz-box-shadow: inset rgba(0, 0, 0, 0.1) 0 0 3px;
-webkit-box-shadow: inset rgba(0, 0, 0, 0.1) 0 0 3px;
box-shadow: inset rgba(0, 0, 0, 0.1) 0 0 3px;
-moz-transition-duration: .33s;
-moz-transition-property: background,border,color,opacity,box-shadow;
-webkit-transition-duration: .33s;
-webkit-transition-property: background,border,color,opacity,box-shadow;
transition-duration: .33s;
transition-property: background,border,color,opacity,box-shadow;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
border-radius: 3px;
}

.formStyle:hover {
	border: 1px solid #bbb;
}

.importantField {
	background: #E2788B;
	color: #FFFFFF;
}

.tooltipspan {
	z-index: 3;
	text-align: bottom;
}

#multiDisplay {
	border: 0px solid;
	padding: 5px;
}

.mysphere, .memberdisplay {
	border: 0px solid #D9D9D9;
	padding: 0px;
	margin: 20px 5px 20px 5px;
	font-size: 0.95em;
	display: inline-block;
	text-align: center;
}

.mysphere img, .memberdisplay img {
	display: block;
}


#userProfile {
	margin: 10px;
}

#userProfile #iSM {
	display: inline-block;

}

#userProfile #StrengthIndicator {
	display: inline-block;
}

#userProfile .formLine {
	border: 0px solid #ff0000;
	margin: 10px;
	clear: both;
}

#userProfile .formField {
	border: 0px solid #00ff00;
	margin-left: 10px;
	float: left;
}

#userProfile .field {
	border: 0px solid #0000ff;
	width: 160px;
	margin: 10px;
	font-weight: bold;
	float: left;
	text-align: right;
}

#userProfile #bio {
	margin-bottom: 10px;
}

#userProfile .helpLabel {
	display: inline;
	margin-top: 10px;
	padding-top: 10px;
}

#userProfile label {
	border: 0px solid #000000;
	font-weight: bold;
	text-align: right;
}

#spherepost {
	margin: 0;
}

#spherepost .reddButton {
	float: left;
	margin: 3px;
}

#spherepost #post_box {
	float: left;
	border: 1px solid #999999;
	width: 40%;
	margin: 3px;

}

#sphereposts .topline {
	font-size: 0.65em;
	float: right;
	color: #888888;
}

#sphereposts .topline a:link {
	color: #6666ff;
}

#sphereposts .topline a:hover {
	color: #0000ff;
}

.postcomment {
	margin: 0;
}

.postcomment .reddButton {
	float: left;
	margin: 3px;
	height: 20px;
}

.postcomment .comment_box {
	float: left;
	width: 40%;
	margin: 3px;
	display:block;
}

.post_box {
	float: left;
	width: 40%;
	margin: 3px;
	display:block;
}

.pusher {
	clear: both;
}

.reddButton {
background:#e9444c;
background:-webkit-gradient(linear, left top, left bottom, from(#e9444c), to(#d1344a));
background:-moz-linear-gradient(top, #e9444c, #d1344a);
border:1px solid #d1344a;
color:#ffffff;
text-shadow:rgba(0, 0, 0, 0.1) 0 -1px 0;
cursor:pointer;
height:25px;
padding:0 5px;
text-align:center;
-moz-box-shadow:rgba(0, 0, 0, 0.1) 0 0 2px 0px;
-webkit-box-shadow:rgba(0, 0, 0, 0.1) 0 0 2px 0px;
box-shadow:rgba(0, 0, 0, 0.1) 0 0 2px 0px;	
}

.reddButton:hover {
text-decoration:none;
background:#e9444c;
background:-webkit-gradient(linear, left top, left bottom, from(#d1344a), to(#e9444c));
background:-moz-linear-gradient(top, #d1344a, #e9444c);
}

.reddButton:active {
background:#e9444c;
background:-webkit-gradient(linear, left top, left bottom, from(#d1344a), to(#d1344a));
background:-moz-linear-gradient(top, #d1344a, #d1344a);
-webkit-box-shadow:none;-moz-box-shadow:none;
box-shadow:none;
}

.link.reddButton,a.reddButton,.reddButton a{
color:#ffffff;
}

.greyButton {
background:#D9D9D9;
background:-webkit-gradient(linear, left top, left bottom, from(#E9E9E9), to(#D9D9D9));
background:-moz-linear-gradient(top, #E9E9E9, #D9D9D9);
border:1px solid #C9C9C9;
color:#000000;
text-shadow:rgba(0, 0, 0, 0.1) 0 -1px 0;
cursor:pointer;
display:block;
height:25px;
padding:0 5px;
text-align:center;
-moz-box-shadow:rgba(0, 0, 0, 0.1) 0 0 2px 0px;
-webkit-box-shadow:rgba(0, 0, 0, 0.1) 0 0 2px 0px;
box-shadow:rgba(0, 0, 0, 0.1) 0 0 2px 0px;	
}

.greyButton:hover {
text-decoration:none;
background:#D9D9D9;
background:-webkit-gradient(linear, left top, left bottom, from(#D9D9D9), to(#E9E9E9));
background:-moz-linear-gradient(top, #D9D9D9, #E9E9E9);
}


.greyButton:active {
background:#D9D9D9;
background:-webkit-gradient(linear, left top, left bottom, from(#D9D9D9), to(#D9D9D9));
background:-moz-linear-gradient(top, #D9D9D9, #D9D9D9);
-webkit-box-shadow:none;-moz-box-shadow:none;
box-shadow:none;
}

.link.greyButton,a.greyButton,.greyButton a{
color:#000000;
}

.rightButton {
	float: right;
}

.leftButton {
	float: left;
	margin-left: 12px;
}

.post {
	padding: 2px;
	margin: 5px;
	border-top: solid 1px #aaaaaa;
	background: #ffffff;
	width: 90%;
	font-size: 0.9em;

}

.comment {
	padding: 2px;
	margin: 5px;
	border-top: dotted 1px #cccccc;
	background: #ffffff;
	font-size: 0.9em;

}

#auto_spheres {
	padding: 5px;
	border: 0px solid #000000;
}

.spherebox {
	float: left;
	width: 30%;
	margin: 0 5px;
	padding: 5px;
	border: 1px solid #D9D9D9;
}

.tooltip {
	display: block;
    border-bottom: 0px dotted #333;
    position: relative;
}
.tooltip:hover:after {
    content: attr(title);
    position: absolute;
    white-space: nowrap;
    background: rgba(0, 0, 0, 0.85);
    padding: 3px 6px;
    color: #FFF;
    border-radius: 3px;
	-khtml-border-radius: 3px;
    -moz-border-radius: 3px;
	-o-border-radius: 3px;
    -webkit-border-radius: 3px;
    margin-left: 10px;
    margin-top: -10px;
}


/* Formatting for the registration password strength indicator */
.green {color: #00CC66;}
.red {color: #FF0000;}

#iSM {margin:0 0 0 0;padding:0;font-size: 0.2em;}
#iSM ul {border:0;margin:0px 0 0 0;padding:0;list-style-type:none;text-align:center;}
#iSM ul li {display:block;float:left;text-align:center;padding:1px 0 0 0;margin:0;height:5px;}
#iWeak,#iMedium,#iStrong {width:64px;font-size:.2em;color:#adadad;text-align:center;padding:2px;background-color:#F1F1F1;display:block;}
#iWeak,#iMedium {border-right:solid 1px #DEDEDE;}
#iMedium {width:64px;}
#iMedium,#iStrong {border-left-width:0;}

div.strong #iWeak, div.strong #iMedium, div.strong #iStrong  {
	background: #00CC66;
	color: #00CC66;
}

div.medium #iWeak, div.medium #iMedium {
	background: #FFFF99;
	color: #FFFF99;
}

div.medium #iWeak, div.medium #iMedium {
	background: #FFFF99;
	color: #FFFF99;
}

div.weak #iWeak {
	background: #FF0000;
	color: #FF0000;
}

div.strong #iStrong, div.medium #iMedium, div.weak #iWeak {
	color:#000;
}