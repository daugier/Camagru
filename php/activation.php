<?php
	session_start();
	require 'connect_db.php';

	$user = $_GET['user'];
	$code = $_GET['code'];
	$query = $db->prepare("SELECT id FROM user WHERE user=:user AND code=:code");
	$query->execute(array(':user' => $user, ':code' => $code));
	$res = $query->fetch();
	if ($res)
	{
		$query= $db->prepare("UPDATE user set ok=1 WHERE user=:user");
		$query->execute(array(':user' => $user));
	}
	header('Location:http://localhost:8080/camagru/index.php');
?>