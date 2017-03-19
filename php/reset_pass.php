<?php
require '../function/connect_db.php';

session_start();

$password = $_POST['password'];
$password2 = $_POST['password2'];
$code = $_POST['code'];
$url = $_POST['url'];
if ($password === $password2 && $code)
{
	$password = hash('whirlpool', $password);
	try{
		$query= $db->prepare('UPDATE user set password=:password WHERE code=:code');
		$query->execute(array(':password' => $password, ':code' => $code));
	}
	catch(PDOException $e)
	{
		die("Erreur ! : ".$e->getMessage());
	}
	try{
		$query= $db->prepare('UPDATE user set code=:code WHERE password=:password');
		$query->execute(array(':code' => NULL, ':password' => $password));
	}
	catch(PDOException $e)
	{
		die("Erreur ! : ".$e->getMessage());
	}
}
header('Location:../index.php');
?>