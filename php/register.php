<?php
require 'connect_db.php';
include 'mail.php';
include 'check_new_user.php';

session_start();

$user = $_POST["user"];
$password = $_POST["password"];
$mail = $_POST['mail'];
$_SESSION['error'] = 0;
if ($user && $password && $mail)
{
	if (wrong_pass($password) && wrong_user($user) && wrong_mail($mail))
	{
		$password = hash('whirlpool', $_POST['password']);
		$query= $db->prepare("INSERT INTO user (user, mail, password, code, ok) VALUES (:user, :mail, :password, :code, :ok)");
		$code = rand(100000000, 600000000);
		$query->execute(array(':user' => $user, ':mail' => $mail, ':password' => $password, ':code' => $code, ':ok' => 0));
		$lien = 'http://localhost:8080/camagru/php/activation.php?code='.$code.'&user='.$user;
		$message = 'Bonjour, veuillez cliquez sur ce lien ci-dessous pour activer votre compte '.PHP_EOL.$lien.PHP_EOL.'    Cordialement Camagru_staff.';
		send_mail($mail, $code, $user, $message);
	}
}
header('Location:http://localhost:8080/camagru/index.php');
?>