<?php

$DB_HOST = "localhost";
$DB_NAME = "phpbookmarks";
$DB_USER = "php-bookmarks";
$DB_PASSWORD = "x4bN2NUb285043fpsHF2";

$OPTIONS = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
  $db = new PDO("mysql:host=" . $DB_HOST . ";dbname=" . $DB_NAME, $DB_USER, $DB_PASSWORD, $OPTIONS);
}
catch (PDOException $e) {
  exit("Verbindung fehlgeschlagen! " . $e->getMessage());
}

?>
