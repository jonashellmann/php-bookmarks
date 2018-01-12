<?php

try {
	$db->exec(
		"CREATE TABLE IF NOT EXISTS categorys (
			id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			parent_id INT(11),
			name VARCHAR(30) NOT NULL
		) ENGINE=InnoDB");

	$db->exec("ALTER TABLE categorys
			ADD CONSTRAINT FOREIGN KEY (parent_id) REFERENCES categorys(id)");

	$db->exec(
		"CREATE TABLE IF NOT EXISTS bookmarks (
			id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			url VARCHAR(80) NOT NULL,
			name VARCHAR(80) NOT NULL,
			description VARCHAR(100),
			category_id INT(11)
		) ENGINE=InnoDB");
	
	$db->exec(
		"ALTER TABLE bookmarks
			ADD CONSTRAINT FOREIGN KEY (category_id) REFERENCES categorys(id)");
}
catch (PDOException $e) {
	exit($e->getMessage());
}

?>
