 <!DOCTYPE html>
<html lang="de">
<head>

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Bookmarks</title>

</head>

<body>

<?php

include "database.php";

try {
	$db->exec(
		"CREATE TABLE IF NOT EXISTS 'category' (
			'id' INT(11) NOT NULL,
			'name' VARCHAR(30) NOTNULL,
			PRIMARY KEY ('id')
		) ENGINE=InnoDB");
	$db->exec(
		"CREATE TABLE IF NOT EXISTS 'bookmark' (
			'id' INT NOT NULL,
			'url' VARCHAR(80) NOT NULL,
			'name' VARCHAR(80) NOT NULL,
			'description' VARCHAR(100),
			PRIMARY KEY ('id') 
		) ENGINE=InnoDB");
	$db->exec(
		"ALTER TABLE bookmark 
		ADD CONSTRAINT FOREIGN KEY (category) REFERENCES category (id)");
}
catch (PDOException $e) {
	exit("<p>&#9655; Database tables could not be created!</p>" . $e->getMessage()); 
}

echo "<h1>Bookmarks</h1>";

$select_categorys = $db->query("SELECT 'id', 'name' FROM 'category'");
$categorys = $select_categorys->fetchAll();

foreach ($categorys as $category) {
	echo "<div class='category'>";
	echo "<h2>" . $nachricht["name"] "</h2>";

	$select_bookmarks = $db->query("SELECT 'url', 'name', 'description' FROM bookmark");
	$bookmarks = $select_bookmarks->fetchAll();

	foreach ($bookmarks as $bookmark) {
		echo "<div class='bookmark'";
		echo "<a href='" . $bookmark["url"] . "' target='_blank'>" . $bookmark["name"] . "</a>";
		echo "</div>";
	}

	echo "</div>";
}

?>

</body>
</html>
