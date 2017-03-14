<?php
session_start();

require 'connect_db.php'; 

$user = $_POST["user"];
$password = hash('whirlpool', $_POST["password"]);
$_SESSION['logged_on_user'] = 0;
$url = $_POST['url'];
$_SESSION['error'] = 0;
$_SESSION['valid'] = 0;
if ($user && $password)
{
	$query = $db->prepare("SELECT id FROM user WHERE user=:user AND password=:password AND ok=:ok");
	$query->execute(array(':user' => $user, ':password' => $password, ':ok' => 1));
	$res = $query->fetch();
	if ($res)
	{
		$_SESSION['logged_on_user'] = $res['id'];
		$_SESSION['valid'] = 2;
		header('location:'.$url);
	}
	else
	{
		$_SESSION['error'] = 5;
		header('location:'.$url.'#login');
	}
}
else
	header('location:'.$url.'#login');
?>