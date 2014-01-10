<?php

include("db.php");

if(preg_match("/".basename(__FILE__)."/i",$_SERVER['REQUEST_URI']))  
{  
 header('Location: index.php?redirect='. basename($_SERVER['PHP_SELF']) . '?sid=' . $sphere_sid);
}

function ago($timeposted) {
	
	$currenttime = time();
	$seconds_diff = max(0,$currenttime - $timeposted);
	
	if($seconds_diff<60) {
		
		$td = "seconds ago";
		
	} elseif($seconds_diff<3600) {
		
		$td = round($seconds_diff/60, 1) . " minutes ago";
		
	} elseif($seconds_diff<86400) {
		
		$td = round($seconds_diff/3600, 1) . " hours ago";
		
	} elseif($seconds_diff<604800) {
		
		$td = round($seconds_diff/86400, 1) . " days ago";
		
	} elseif($seconds_diff<2592000) {
		
		$td = round($seconds_diff/604800, 1) . " weeks ago";
		
	} elseif($seconds_diff<30758400) {
		
		$td = round($seconds_diff/2592000, 1) . " months ago";
		
	} else {
		
		$td = "a long, long time ago (in a galaxy far away...)";
	}
	
	return $td;
}

function getposts($sid, $mem) {
	
	$sid =mysql_real_escape_string($sid);
	$mem = mysql_real_escape_string($mem);

	$postquery = "(SELECT 0 AS comment_id, posts.*, users.displayname\n" .
	"FROM `posts`\n" .
	"LEFT JOIN `users`\n" .
	"ON posts.author_id = users.user_id\n" .
	"WHERE sphere_id = $sid\n" .
	"ORDER BY post_id DESC LIMIT 20)\n\n" .
	"UNION\n\n" .
	"(SELECT post_comments.*, users.displayname\n" .
	"FROM `post_comments`\n" .
	"LEFT JOIN `users`\n" .
	"ON post_comments.author_id = users.user_id\n" .
	"WHERE sphere_id = $sid\n" .
	"ORDER BY comment_id ASC LIMIT 200)\n\n" .
	"ORDER BY post_id DESC\n";
	
	$postresult = mysql_query($postquery) or die(mysql_error());
	$my_id = $_SESSION['user_id'];
	
	while ($spherePosts = mysql_fetch_array($postresult)) {
		
		$postnum = $spherePosts['post_id'];
		$commentnum = $spherePosts['comment_id'];
		
		if ($my_id == $spherePosts['author_id']) {
			
			$author = "you,";
			$wallpostc = $spherePosts[0] % 2;
			$deletepost = " | <a href=\"includes/postcomment.php?sid=" . $spherePosts['sphere_id'] ."&dp=" . $postnum . "&dc=" . $commentnum . "\">X</a>";
			
		}
		else {
			
			$author = "<a href=\"member.php?mid=" . $spherePosts['author_id'] . "\">" . $spherePosts['displayname'] .  "</a>";
			$wallpostc = $spherePosts[0] % 2;
			$deletepost = "";
		}
		
		if ($spherePosts['comment_id']==0) { //Post
		
		echo "</div>\n<div class=\"post\" >\n" .
		"<span class=\"topline\">". $author . " " . ago($spherePosts['post_timestamp']) . $deletepost . "</span>\n" .
		"<br />" . stripslashes($spherePosts['message']) . "\n";
		
			if($mem == 1) {
				
				echo "<div class=\"postcomment\">\n" .
				"<form enctype=\"\" action=\"includes/postcomment.php\" method=\"POST\">\n" .
				"<textarea rows=\"1\" class=\"formStyle comment_box\" id=\"box\" value=\"Post a reply\" name=\"comment\" /></textarea>\n" .
				"<input type=\"hidden\" name=\"post_id\" value=\"" . $spherePosts['post_id'] . "\">\n" .
				"<input type=\"hidden\" name=\"sphere_id\" value=\"" . $sid . "\">\n" .
				"<input class=\"reddButton\" type=\"submit\" name=\"submitcomment\" value=\"Reply\" />\n" .
				"</form>\n" .
				"<div class=\"pusher\"></div>\n";
				
			}
			
			echo "</div>\n\n";
			
		} elseif($spherePosts['comment_id']>0) { //Comment
		
		echo "<div class=\"comment\">\n" .
		"<span class=\"topline\">" . $author . " " . ago($spherePosts['post_timestamp']) . $deletepost ."\n</span>\n" .
		"<br />" . stripslashes($spherePosts['message']) . "</div>\n";
		
		}
	}
}

?>