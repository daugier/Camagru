<?php
	session_start();
	include '../function/user.php';

	$mail = $_GET['mail'];
	$code = $_GET['code'];
	$res = select_id_user_from_mailandcode($mail, $code);
	if ($res && $code != NULL)
		header('location:reset_password.php?code='.$code);
	else
		header('location:../index.php');
?>