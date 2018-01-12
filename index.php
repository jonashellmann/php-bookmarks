 <!DOCTYPE html>
<html lang="de">
<head>

	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title>Bookmarks</title>

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" />
	<link rel="stylesheet" href="styles.css" />

</head>

<body>

<?php

include "database.php";
include "tables.php";

if( isset($_POST["create-category"]) ) {
	try {
		if ($_POST["category-parent"] === "-") {
			$sql = $db->prepare("INSERT INTO categorys (name) VALUES (:name)");
			$sql->bindParam(":name", $name);

			$name = $_POST["category-name"];

			$sql->execute();
		}
		else {
			$sql = $db->prepare("INSERT INTO categorys (name, parent_id) VALUES (:name, :parent_id)");
			$sql->bindParam(":name", $name);
			$sql->bindParam(":parent_id", $parent_id);
		
			$name = $_POST["category-name"];
			$parent_id = $_POST["category-parent"];
		
			$sql->execute();
		}
	}
	catch (Exception $e) {
		exit($e->getMessage());
	}
}

if( isset($_POST["create-bookmark"]) ) {
	try {
		$sql = $db->prepare("INSERT INTO bookmarks (url, name, description, category_id) VALUES (:url, :name, :description, :category_id)");
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

if( isset($_POST["delete-bookmark"]) ) {
	try {
		$sql = $db->prepare("DELETE FROM bookmarks WHERE id = :id");
		$sql->bindParam(':id', $_POST['bookmark-id'], PDO::PARAM_INT);
		$sql->execute();

	}
	catch (Exception $e) {
		exit($e->getMessage());
	}
}

echo '<h1>Bookmarks</h1>';

$select_categorys = $db->query("SELECT id, name FROM categorys WHERE parent_id IS NULL");
$categorys = $select_categorys->fetchAll();

echo "<div id='bookmarks'>";

foreach ($categorys as $category) {
	echo "<div class='category'>";
	echo "<h2>" . $category["name"] . "</h2>";

	$select_bookmarks = $db->query("SELECT id, url, name, description FROM bookmarks WHERE category_id = " . $category["id"]);
	$bookmarks = $select_bookmarks->fetchAll();

	foreach ($bookmarks as $bookmark) {
		echo "<div class='bookmark'>";
		echo "<a href='" . $bookmark["url"] . "' target='_blank'>" . $bookmark["name"] . "</a>";
		echo "<form method='post'>";
		echo "<button type='submit' name='delete-bookmark'>X</button>";
		echo "<input type='text' name='bookmark-id' value='" . $bookmark["id"] . "' style='display: none;' />";
		echo "</form>";
		echo "<p>" . $bookmark["description"] . "<p>";
		echo "</div>";
	}

	$select_subcategorys = $db->query("SELECT id, name FROM categorys WHERE parent_id = " . $category["id"]);
	$subcategorys = $select_subcategorys->fetchAll();

	foreach ($subcategorys as $subcategory) {
		echo "<div class='subcategory'>";
		echo "<h3>" . $subcategory["name"] . "</h3>";

		$select_bookmarks = $db->query("SELECT id, url, name, description FROM bookmarks WHERE category_id = " . $subcategory["id"]);
		$bookmarks = $select_bookmarks->fetchAll();

		 foreach ($bookmarks as $bookmark) {
			 echo "<div class='bookmark'>";
			 echo "<a href='" . $bookmark["url"] . "' target='_blank'>" . $bookmark["name"] . "</a>";
			 echo "<form method='post'>";
			 echo "<button type='submit' name='delete-bookmark'>X</button>";
			 echo "<input type='text' name='bookmark-id' value='" . $bookmark["id"] . "' style='display: none;' />";
			 echo "</form>";
			 echo "<p>" . $bookmark["description"] . "<p>";
			 echo "</div>";
		 }

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
				<select name="category-parent">
					<option value="-">None</option>
					<?php
					$select_categorys = $db->query("SELECT id, name FROM categorys WHERE parent_id IS NULL");
					$categorys = $select_categorys->fetchAll();

					foreach ($categorys as $category) {
						echo "<option value='" . $category["id"] . "'>" . $category["name"] . "</option>";
					}
					?>
				</select>
				<input type='text' name='category-name' placeholder='Category Name' />
				<button type='submit' name='create-category'>Create Category</button>
			</form>
		</div>

		<div id='creation-bookmark'>
			<span class='toggle-button'>Create Bookmark</span>
			<form method='post'>
				<select name='bookmark-category'>
					<?php
					$select_categorys = $db->query("SELECT id, name FROM categorys");
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
