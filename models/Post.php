<?php

class Post {
	public $post_id;
	public $post_title;
	public $post_body;
	
	public function printHTML() {
		echo '<article>';
		echo "<h2><a
		href=\"post.php?post_id=$this->post_id\">$this->post_title</a></h2>";
		echo "<p>$this->post_body</p>";
		echo '</article>';
	}
}

?>
