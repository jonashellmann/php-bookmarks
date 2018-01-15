<?php

session_start();

include '../database.php';

if( !isset($_POST['op']) && ! isset($_GET['op']) ) {
	exit('You must choose an operation to perform');
}

if( isset($_POST['op']) ) {
	$operation = $_POST['op'];
}
else {
	$operation = $_GET['op'];
}

if($operation === 'login') {

	$username = $_POST['user'];
	$password = $_POST['password'];

	try {
		$sql = $db->query('SELECT * FROM users WHERE username = "' . $username . '"');
		$user = $sql->fetch();

		if( $user !== false && password_verify($password, $user['password']) ) {
			exit('{"sessionid"="' . $user['id'] . '"}');
		}
		else {
			exit('{"error"="Username or password invalid"}');
		}
	}
	catch (PDOException $e){
		  exit($e->getMessage());
	}

}
else {
	if( !isset($_POST['sessionid']) && !isset($_GET['sessionid']) ) {
	        exit('{"error"="No session ID provided"}');
	}

	if( isset($_POST['sessionid']) ) {
		$userid = $_POST['sessionid'];
	}
	else {
		$userid = $_GET['sessionid'];
	}
}


if($operation === 'categorys') {
	try {
		$sql = $db->query('SELECT id, name FROM categorys WHERE parent_id IS NULL AND user_id = ' . $userid);
		$categorys = $sql->fetchAll();
		$json = json_encode($categorys);
	}
	catch (PDOException $e) {
		exit($e->getMessage());
	}

	if( isset($_GET['callback']) ) {
		exit($_GET['callback'] . "('" . $json . "');");
	}

	exit($json);
}

if($operation === 'bookmarks') {
	if( !isset($_POST['categoryid']) && !isset($_GET['categoryid']) ) {
		exit('{"error"="No category ID provided"}');
	}

	if( isset($_POST['categoryid']) ) {
		$categoryid = $_POST['categoryid'];
	}
	else {
		$categoryid = $_GET['categoryid'];
	}

	try {
		$sql = $db->query('SELECT b.name, b.url FROM bookmarks b join categorys c on b.category_id = c.id where b.category_id = ' . $categoryid . ' AND c.user_id = ' . $userid);
		$bookmarks = $sql->fetchAll();
		$json = json_encode($bookmarks);
	}
	catch (PDOException $e) {
		exit($e->getMessage());
	}

	if( isset($_GET['callback']) ) {
		exit($_GET['callback'] . "('" . $json . "');");
	}

	exit($json);

}

exit('{"error"="Operation not found"}');

?>
