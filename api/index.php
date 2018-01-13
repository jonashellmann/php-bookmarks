<?php

session_start();

include '../database.php';

if(!isset($_POST['op'])) {
	exit('You must choose an operation to perform');
}

$operation = $_POST['op'];

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

	exit('Test ------------');

}
else {
	if(!isset($_POST['sessionid'])) {
	        exit('{"error"="No session ID provided"}');
	}

	$userid = $_POST['sessionid'];	
}


if($operation === 'categorys') {
	try {
		$sql = $db->query('SELECT * FROM categorys WHERE parent_id IS NULL AND user_id = ' . $userid);
		$categorys = $sql->fetchAll();
		$json = json_encode($categorys);
	}
	catch (PDOException $e) {
		exit($e->getMessage());
	}

	exit($json);
}

if($operation === 'bookmarks') {
	$categoryid = $_POST['categoryid'];

	try {
		$sql = $db->query('SELECT b.* FROM bookmarks b join categorys c on b.category_id = c.id where b.category_id = ' . $categoryid . ' AND c.user_id = ' . $userid);
		$bookmarks = $sql->fetchAll();
		$json = json_encode($bookmarks);
	}
	catch (PDOException $e) {
		exit($e->getMessage());
	}

	exit($json);



}

exit('{"error"="Operation not found"}');

?>
