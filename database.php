<?php

$DB_HOST = "localhost";
$DB_NAME = "phpbookmarks";
$DB_USER = "phpbookmarks";
$DB_PASSWORD = "";

$OPTIONS = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
  $db = new PDO("mysql:host=" . $DB_HOST . ";dbname=" . $DB_NAME, $DB_USER, $DB_PASSWORD, $OPTIONS);
}
catch (PDOException $e) {
  exit("Database connection failed! " . $e->getMessage());
}

?>
