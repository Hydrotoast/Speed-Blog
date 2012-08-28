<?php

define('IN_BLOG', true);
require('common.php');
include('models/Post.php');
include('models/Tag.php');
include('models/Comment.php');

include('header.php');

if (isset($_GET['post_id'])) {
	$post_id = filter_var($_GET['post_id'],
	FILTER_SANITIZE_NUMBER_INT);

	// Retrieve the post given the post id
	$query = 'SELECT * FROM ' . POSTS_TABLE . ' WHERE
	post_id=:post_id';
	$stmt = $db->prepare($query);
	$stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');
	$post = $stmt->fetch();

	// Retrieve the tags associated with this post if any
	$query = 'SELECT * FROM ' . TAGS_TABLE . ' WHERE
	post_id=:post_id';
	$stmt = $db->prepare($query);
	$stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
	$stmt->execute();
	$tags = $stmt->fetchAll(PDO::FETCH_CLASS, 'Tag');

	// Retrieve the comments associated with this post if any
	$query = 'SELECT * FROM ' . COMMENTS_TABLE . ' WHERE
	post_id=:post_id';
	$stmt = $db->prepare($query);
	$stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
	$stmt->execute();
	$comments = $stmt->fetchAll(PDO::FETCH_CLASS, 'Comment');
} else {
	echo 'Invalid post id.';
}
?>

<a href="index.php" class="nav-button">Return to Index</a>

<?php if (isset($post_id)): ?>
	<?php $post->printHTML(); ?>

	<?php if (!empty($tags)): ?>
		<strong>Tags:</strong>
		<?php foreach ($tags as $tag): ?>
			<?php $tag->printHTML(); ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<h2>Comments</h2>

	<form action="create_comment.php" method="POST">
	<input type="hidden" name="post_id" value="<?= $post_id ?>"
	/>
	<p>
		<label for="comment_full_name">Full name</label> <br
		/>
		<input name="comment_full_name" type="text" required/>
	</p>
	<p>
		<label for="comment_email">Email</label> <br />
		<input name="comment_email" type="email" required/>
	</p>
	<p>
		<label for="comment_body">Message</label> <br />
		<textarea name="comment_body" required></textarea>
	</p>
	<p>
		<input name="submit" type="submit" value="Comment" />
	</p>
	</form>

	<?php foreach ($comments as $comment): ?>
		<?php $comment->printHTML(); ?>
	<?php endforeach; ?>
<?php endif; ?>


<?php include('footer.php'); ?>
