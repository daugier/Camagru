<?php
	session_start();
	include '../function/user.php';

	$user = $_GET['user'];
	$code = $_GET['code'];
	$res = get_id_byuser_and_code($user, $code);
	if ($res && $code != NULL)
	{
		update_ok_user($user);
		update_code_user($user);
		$_SESSION['valid'] = 9;
	}
	header('Location:../index.php');
?>