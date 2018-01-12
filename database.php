<?php

$DB_HOST = ""
$DB_NAME = ""
$DB_USER = ""
$DB_PASSWORD = ""

$OPTION = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
  $db = new PDO("mysql:host=" . $DB_HOST . ";dbname=" . $DB_NAME, $DB_BENUTZER, $DB_PASSWORT, $OPTION);
}
catch (PDOException $e) {
  exit("Verbindung fehlgeschlagen! " . $e->getMessage());
} 

?>
