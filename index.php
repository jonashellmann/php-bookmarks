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

if( isset($_POST["create-category"]) ) {
	try {
		$sql = $db->prepare("INSERT INTO category (name) VALUES (:name)");
		$sql->bindParam(":name", $name);
		$name = $_POST["category-name"];
		$sql->execute();
	}
	catch (Exception $e) {
		exit($e->getMessage());
	}
}

if( isset($_POST["create-bookmark"]) ) {
	try {
		$sql = $db->prepare("INSERT INTO bookmark (url, name, description, category_id) VALUES (:url, :name, :description, :category_id)");
		$sql->bindParam(":url", $url);
		$sql->bindParam(":name", $name);
		$sql->bindParam(":description", $description);
		$sql->bindParam(":category_id", $category_id);

		$url = $_POST["bookmark-url"];
		$name = $_POST["bookmark-name"];
		$description = $_POST["bookmark-description"];
		$category_id = $_POST["bookmark-category"];

		$sql->execute();
	}
	catch (Exception $e) {
		exit($e->getMessage());
	}
}

echo '<h1>Bookmarks</h1>';

$select_categorys = $db->query("SELECT id, name FROM category");
$categorys = $select_categorys->fetchAll();

echo "<div id='bookmarks'>";

foreach ($categorys as $category) {
	echo "<div class='category'>";
	echo "<h2>" . $category["name"] . "</h2>";

	$select_bookmarks = $db->query("SELECT url, name, description FROM bookmark");
	$bookmarks = $select_bookmarks->fetchAll();

	foreach ($bookmarks as $bookmark) {
		echo "<div class='bookmark'>";
		echo "<a href='" . $bookmark["url"] . "' target='_blank'>" . $bookmark["name"] . "</a>";
		echo "</div>";
	}

	echo "</div>";
}

echo "</div>";

?>

	<div id='creation'>
		<div id='creation-category'>
			<span class='toggle-button'>Create Category</span>
			<form method='post'>
				<input type='text' name='category-name' placeholder='Category Name' />
				<button type='submit' name='create-category'>Create Category</button>
			</form>
		</div>

		<div id='creation-bookmark'>
			<span class='toggle-button'>Create Bookmark</span>
			<form method='post'>
				<select name'bookmark-category'>
					<?php
					$select_categorys = $db->query("SELECT id, name FROM category");
					$categorys = $select_categorys->fetchAll();

					foreach ($categorys as $category) {
						echo "<option value='" . $category["id"] . "'>" . $category["name"] . "</option>";
					}
					?>
				</select>
				<input type='text' name='bookmark-name' placeholder="Bookmark Title" />
				<input type='text' name='bookmark-url' placeholder="Bookmark URL" />
				<input type='text' name='bookmark-description' placeholder="Bookmark Description" />
				<button type='submit' name='create-bookmark'>Create Bookmark</button>
		</div>
	</div>

</body>
</html>
