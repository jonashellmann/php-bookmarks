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
include "tables.php";

echo '<h1>Bookmarks</h1>';

$select_categorys = $db->query("SELECT 'id', 'name' FROM 'category'");
$categorys = $select_categorys->fetchAll();

foreach ($categorys as $category) {
	echo "<div class='category'>";
	echo "<h2>" . $nachricht["name"] . "</h2>";

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
