<?php
	session_start();
	$url = $_SESSION['url'];
	session_destroy();
	header('Location:'.$url.'/index.php');
?>