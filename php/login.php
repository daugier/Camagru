<?php
session_start();

require '../function/connect_db.php'; 

$user = $_POST["user"];
$password = hash('whirlpool', $_POST["password"]);
$_SESSION['logged_on_user'] = 0;
$url = $_POST['url'];
$_SESSION['error'] = 0;
$_SESSION['valid'] = 0;
if ($user && $password)
{
	try{
		$query = $db->prepare("SELECT * FROM user WHERE user=:user AND password=:password AND ok=:ok");
		$query->execute(array(':user' => $user, ':password' => $password, ':ok' => 1));
		$res = $query->fetch();
	}
	catch(PDOException $e)
	{
		die("Erreur ! : ".$e->getMessage() );
	}
	if ($res)
	{
		$_SESSION['logged_on_user'] = $res['id'];
		$_SESSION['valid'] = 2;
		$_SESSION['user'] = $res['user'];
		$_SESSION['mail'] = $res['mail'];
		$_SESSION['url'] = $url;
		$_SESSION['id'] = $res['id'];
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