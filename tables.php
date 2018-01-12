<?php

try {
	$db->exec(
		"CREATE TABLE IF NOT EXISTS category (
			id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(30) NOT NULL
		) ENGINE=InnoDB");
	
	$db->exec(
		"CREATE TABLE IF NOT EXISTS bookmark (
			id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			url VARCHAR(80) NOT NULL,
			name VARCHAR(80) NOT NULL,
			description VARCHAR(100),
			category_id INT(11)
		) ENGINE=InnoDB");
	
	$db->exec(
		"ALTER TABLE bookmark
			ADD CONSTRAINT FOREIGN KEY (category_id) REFERENCES category (id)");
}
catch (PDOException $e) {
	exit($e->getMessage());
}

?>
