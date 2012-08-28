<?php

class Comment {
	public $comment_id;
	public $post_id;
	public $comment_full_name;
	public $comment_email;
	public $comment_body;

	public function printHTML() {
		echo '<div>';
		echo "<h4>$this->comment_full_name
		&lt;$this->comment_email&gt;</h4>";
		echo "<p>$this->comment_body</p>";
		echo '</div>';
	}
}

?>
