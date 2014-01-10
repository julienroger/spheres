<?php

include("db.php");
include("validator.php");
include("session.php");

session_start();

$my_id = mysql_real_escape_string($_SESSION['user_id']);

if(empty($_POST['sphere_id'])) {
	$sphere_sid = $_GET['sid'];
} else {
	$sphere_sid = $_POST['sphere_id'];
}

$post_delete = $_GET['dp'];
$comment_delete = $_GET['dc'];

$post_delete = mysql_real_escape_string($post_delete);
$comment_delete = mysql_real_escape_string($comment_delete);

function deletePost($post_id, $user_id) {
	$post_id = mysql_real_escape_string($post_id);
	$user_id = mysql_real_escape_string($user_id);
	$query = "DELETE FROM `posts` WHERE `author_id` = '$user_id' AND `post_id` = '$post_id'";
	mysql_query($query) or die(mysql_error());
}

function deleteComment($post_id, $comment_id, $user_id) {
	$post_id = mysql_real_escape_string($post_id);
	$comment_id = mysql_real_escape_string($comment_id);
	$user_id = mysql_real_escape_string($user_id);
	$query = "DELETE FROM `post_comments` WHERE `author_id` = '$user_id' AND `post_id` = '$post_id' AND `comment_id` = '$comment_id'";
	mysql_query($query) or die(mysql_error());
}


// Should probably validate whether or not the user can actually post to the sphere. Will do later



if(!empty($post_delete) && $comment_delete!=0) { // We're deleting a comment

	deleteComment($post_delete, $comment_delete, $my_id);
	
} elseif(!empty($post_delete) && empty($comment_delete)) { // We're deleting a post and its comments

	deletePost($post_delete, $my_id);
	
} elseif(!empty($_POST['submitpost']) && !empty($_POST['message'])) { // See if a post/comment was posted

	$message = $_POST['message'];
	$message_clean = mysql_real_escape_string(htmlspecialchars($message));
	$my_id = $_SESSION['user_id'];
	$my_id = mysql_real_escape_string($my_id);
	$sphere_sid = mysql_real_escape_string($sphere_sid);
	$posttimestamp = time();
	
	$postquery = "INSERT INTO posts (`author_id`, `sphere_id`, `post_timestamp`, `message`) VALUES ( $my_id, $sphere_sid, $posttimestamp, '$message_clean' )";
	mysql_query($postquery) or die(mysql_error());
	
} elseif(!empty($_POST['submitcomment']) && !empty($_POST['comment'])) { // See if a comment was posted 

	$message = $_POST['comment'];
	$message_clean = mysql_real_escape_string(htmlspecialchars($message));
	$my_id = $_SESSION['user_id'];
	$my_id = mysql_real_escape_string($my_id);
	$sphere_sid = mysql_real_escape_string($sphere_sid);
	$postid = mysql_real_escape_string($_POST['post_id']);
	$posttimestamp = time();
	
	$postquery = "INSERT INTO post_comments (`post_id`, `author_id`, `sphere_id`, `comment_timestamp`, `comment`) VALUES ( $postid, $my_id, $sphere_sid, $posttimestamp, '$message_clean' )";
	mysql_query($postquery) or die(mysql_error());
	
}

header('Location: ../sphere.php?sid=' . $sphere_sid);

?>