<?php

define('IN_BLOG', true);
require('common.php');
include('models/Post.php');

include_once('header.php');

$query = 'SELECT * FROM posts';
$posts = $db->query($query);

?>

<a href="create_post.php" class="nav-button">Create New Post</a>

<?php
if ($posts) {
	$posts->setFetchMode(PDO::FETCH_CLASS, 'Post');
	while ($post = $posts->fetch()) {
		$post->printHTML();
	}
} else {
	echo "No posts.";
}

include('footer.php');
?>
