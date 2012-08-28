CREATE TABLE posts (
	post_id INTEGER NOT NULL DEFAULT '0',
	post_title VARCHAR(255) NOT NULL,
	post_body TEXT NOT NULL,
	PRIMARY KEY (post_id)
);

CREATE TABLE comments (
	comment_id INTEGER NOT NULL DEFAULT '0',
	post_id	INTEGER NOT NULL,
	comment_full_name VARCHAR(255) NOT NULL,
	comment_email VARCHAR(255) NOT NULL,
	comment_body TEXT NOT NULL,
	PRIMARY KEY (comment_id)
);

CREATE TABLE tags (
	tag_id INTEGER NOT NULL DEFAULT '0',
	post_id INTEGER NOT NULL,
	tag_name VARCHAR(45) NOT NULL,
	PRIMARY KEY(tag_id)
);
