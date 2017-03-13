<?php
require 'connect_db.php';

session_start();

$password = $_POST['password'];
$password2 = $_POST['password2'];
$code = $_POST['code'];
$url = $_POST['url'];
if ($password === $password2 && $code)
{
	$password = hash('whirlpool', $password);
	$query= $db->prepare('UPDATE user set password=:password WHERE code=:code');
	$query->execute(array(':password' => $password, ':code' => $code));
	$query= $db->prepare('UPDATE user set code=:code WHERE password=:password');
	$query->execute(array(':code' => NULL, ':password' => $password));
}
header('Location:'$url);
?>