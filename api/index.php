<?php

session_start();

include '../database.php';

$_POST = json_decode(file_get_contents('php://input'), true);

if( !isset($_POST['op']) ) {
	exit('{"error":"You must choose an operation to perform"}');
}

if ( !isset($_POST['username']) || !isset($_POST['password']) ) {
	exit('{"error":"You must choose an username and a password!"}');
}

$operation = $_POST['op'];

$username = $_POST['username'];
$password = $_POST['password'];

$sql_user = $db->query('SELECT * FROM users WHERE username = "' . $username . '"');
$user = $sql_user->fetch();

if( $user !== false && password_verify($password, $user['password']) ) {
	$userid = $user['id'];
}
else {
	exit('{"error":"Username or password invalid"}');
}

if($operation === 'categorys') {
	$sql = $db->query('SELECT id, name FROM categorys WHERE parent_id IS NULL AND user_id = ' . $userid);
	$categorys = $sql->fetchAll();
	$json = json_encode($categorys);

	exit($json);
}

if($operation === 'bookmarks') {
	if( !isset($_POST['categoryid']) ) {
		exit('{"error":"No category ID provided"}');
	}

	$categoryid = $_POST['categoryid'];

	$sql = $db->query('SELECT b.name, b.url FROM bookmarks b join categorys c on b.category_id = c.id where b.category_id = ' . $categoryid . ' AND c.user_id = ' . $userid);
	$bookmarks = $sql->fetchAll();
	$json = json_encode($bookmarks);
	
	exit($json);

}

exit('{"error":"Operation not found"}');

?>
