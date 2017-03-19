<?php
session_start();
require '../function/connect_db.php';

$user = $_SESSION['user'];
$id = $_SESSION['logged_on_user'];

try{
	$query = $db->prepare("DELETE FROM user WHERE id=:id");
	$query->execute(array(':id' => $id));
}
catch(PDOException $e)
{
	die("Erreur ! : ".$e->getMessage() );
}
header('location:disconnect.php');
?>