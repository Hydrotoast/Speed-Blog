<?php

define('IN_BLOG', true);
require('common.php');

// Check for form submission before processing
if (isset($_POST['submit'])) {
	$errors = '';

	// Sanitize the post title
	if (!empty($_POST['post_title']))
		$post_title = filter_var($_POST['post_title'],
		FILTER_SANITIZE_STRING);
	else
		$errors .= '<p>Invalid post title.</p>';

	// Sanitize the post body
	if (!empty($_POST['post_body']))
		$post_body = filter_var($_POST['post_body'],
		FILTER_SANITIZE_STRING);
	else
		$errors .= '<p>Invalid post body.</p>';

	// Sanitize the post body
	if (!empty($_POST['tags']))
		$tags = filter_var($_POST['tags'],
		FILTER_SANITIZE_STRING);

	// Proceed submission only if there are no errors
	if (empty($errors)) {
		try {
			// Insert data into the database
			$query = 'INSERT INTO ' . POSTS_TABLE . ' (post_title,
			post_body) VALUES (:post_title, :post_body)';
			$stmt = $db->prepare($query);
			$stmt->bindParam(':post_title', $post_title);
			$stmt->bindParam(':post_body', $post_body);

			if (!$stmt->execute())
				throw new PDOException('PDO Statement Execution
				Exception');
		
			// Retrieve post id from the last insertion	
			$db_status = $db->query('SELECT last_insert_rowid() as
			last_insert_rowid')->fetch(PDO::FETCH_ASSOC);
			$post_id = $db_status['last_insert_rowid'];

			if (!empty($tags)) {
				$tags_arr = explode(',', $tags);
				$tags_arr = array_map('trim', $tags_arr);
				$query = 'INSERT INTO ' . TAGS_TABLE . '
				(post_id, tag_name) VALUES (:post_id,
				:tag_name)';
				$stmt = $db->prepare($query);
				$stmt->bindParam(':post_id', $post_id);
				$stmt->bindParam(':tag_name', $tag_name);

				foreach ($tags_arr as $tag) {
					$tag_name = $tag;
					$stmt->execute();
				}
			}

			$status = 'Successfully submitted form';
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	} else {
		$status = $errors;
	}
}

include_once('header.php');

?>

<a href="index.php" class="nav-button">Return to Index</a>

<?php if (!empty($status)): ?>
<?= $status ?>
<?php endif; ?>

<h2>Create New Post</h2>

<form action="create_post.php" method="POST">
<p>
	<label for="post_title">Post Title</label> <br />
	<input name="post_title" type="text" required />
</p>
<p>
	<label for="post_body">Post Body</label> <br />
	<textarea name="post_body" required></textarea>
</p>
<p>
	<label for="tags">Tags</label> <br />
	<input name="tags" type="text" />
</p>
<p>
	<input name="submit" type="submit" value="Create" />
</p>
</form>

<?php include_once('footer.php'); ?>
