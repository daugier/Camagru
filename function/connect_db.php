<?php
include('../config/database.php');

try {
	$db = new PDO($DB_DSNB, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	die("Erreur ! : ".$e->getMessage() );
}
$sql = "USE ".$DB_NAME;
try{
	$db->exec($sql);
}
catch(PDOException $e)
{
	die("Erreur ! : ".$e->getMessage() );
}
?>