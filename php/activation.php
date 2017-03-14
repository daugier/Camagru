<?php
	session_start();
	require 'connect_db.php';

	$user = $_GET['user'];
	$code = $_GET['code'];
	$query = $db->prepare("SELECT id FROM user WHERE user=:user AND code=:code");
	$query->execute(array(':user' => $user, ':code' => $code));
	$res = $query->fetch();
	if ($res && $code != NULL)
	{
		$query= $db->prepare("UPDATE user set ok=1 WHERE user=:user");
		$query->execute(array(':user' => $user));
		$query= $db->prepare('UPDATE user set code=:code WHERE user=:user');
		$query->execute(array(':code' => NULL, ':user' => $user));
	}
	$_SESSION['valid'] = 9;
	header('Location:http://localhost:8080/camagru/index.php');
?>