<?php
	session_start();
	include '../function/user.php';

	$mail = $_GET['mail'];
	$code = $_GET['code'];
	$_SESSION['code'] = $code;
	$res = select_id_user_from_mailandcode($mail, $code);
	if ($res['id'] && $code != NULL)
		header('location:reset_password.php');
	else
		header('location:../index.php');
?>