<?php
session_start();

require 'connect_db.php'; 

$user = $_POST["user"];
$password = hash('whirlpool', $_POST["password"]);
$_SESSION['logged_on_user'] = 0;
if ($user && $password)
{
	$query = $db->prepare("SELECT id FROM user WHERE user=:user AND password=:password AND ok=:ok");
	$query->execute(array(':user' => $user, ':password' => $password, ':ok' => 1));
	$res = $query->fetch();
	if ($res)
	{
		$_SESSION['logged_on_user'] = 1;
	}
}
header('Location:http://localhost:8080/camagru/index.php');
?>