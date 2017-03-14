<?php
include('../config/database.php');

$db = new PDO($DB_DSNB, $DB_USER, $DB_PASSWORD);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "USE camagru_db;";
$db->exec($sql);
?>