<?php

define('IN_BLOG', true);
require('common.php');

// Exit if a form has not been submitted or if the post id has
// not been specified; possible hacking attempt
if (!isset($_POST['submit']) || !isset($_POST['post_id']))
	exit;

$errors = '';

// Sanitize the comment full name
if (!empty($_POST['post_id']))
	$post_id = filter_var($_POST['post_id'],
	FILTER_SANITIZE_NUMBER_INT);

// Sanitize the comment full name
if (!empty($_POST['comment_full_name']))
	$comment_full_name = filter_var($_POST['comment_full_name'],
	FILTER_SANITIZE_STRING);
else
	$errors .= '<p>Invalid full name.</p>';

// Sanitize the comment email
if (!empty($_POST['comment_email']))
	$comment_email = filter_var($_POST['comment_email'],
	FILTER_SANITIZE_EMAIL);
else
	$errors .= '<p>Invalid email.</p>';

// Sanitize the comment body
if (!empty($_POST['comment_body']))
	$comment_body = filter_var($_POST['comment_body'],
	FILTER_SANITIZE_STRING);
else
	$errors .= '<p>Invalid message.</p>';


if (empty($errors)) {
	$query = 'INSERT INTO ' . COMMENTS_TABLE . ' (post_id,
	comment_full_name, comment_email, comment_body) VALUES
	(:post_id, :comment_full_name, :comment_email,
	:comment_body)';
	$stmt = $db->prepare($query);
	$stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
	$stmt->bindParam(':comment_full_name', $comment_full_name);
	$stmt->bindParam(':comment_email', $comment_email);
	$stmt->bindParam(':comment_body', $comment_body);
	$stmt->execute();
	
	header("Location: post.php?post_id=$post_id");
	exit;
} else {
	echo $errors;
}

?>
