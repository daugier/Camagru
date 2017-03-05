<?php
	session_start();
	require 'connect_db.php';

	$mail = $_GET['mail'];
	$code = $_GET['code'];
	$query = $db->prepare("SELECT id FROM user WHERE mail=:mail AND code=:code");
	$query->execute(array(':mail' => $mail, ':code' => $code));
	$res = $query->fetch();
	if ($res && $code != NULL)
		header('location:http://localhost:8080/camagru/php/reset_password.php?code='.$code);
	else
		header('location:http://localhost:8080/camagru/index.php');
?>