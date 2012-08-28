<?php

class Tag {
	public $tag_id;
	public $post_id;
	public $tag_name;

	public function printHTML() {
		echo $this->tag_name;
	}
}

?>
