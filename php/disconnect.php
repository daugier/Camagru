<?php
	session_start();
	$_SESSION["logged_on_user"] = 0;
	header('Location:http://localhost:8080/camagru/index.php');
?>