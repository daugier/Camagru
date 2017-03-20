<?php
require '../function/connect_db.php';
include 'mail.php';

session_start();

$mail = $_POST['mail'];
$_SESSION['error_mail'] = 0;
$_SESSION['succes_mail'] = 0;
if ($mail)
{
	try{
		$query= $db->prepare("SELECT id FROM user WHERE mail=:mail");
		$query->execute(array(':mail' => $mail));
		$res = $query->fetch();
	}
	catch(PDOException $e)
	{
		die("Erreur ! : ".$e->getMessage() );
	}
	if ($res)
	{
		$code = rand(100000000, 600000000);
		try{
			$query= $db->prepare('UPDATE user set code='.$code.' WHERE mail=:mail');
			$query->execute(array(':mail' => $mail));
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		$lien = $_SESSION['url'].'/php/active_link_pass.php?code='.$code.'&mail='.$mail;
		$message = 'Bonjour, veuillez cliquez sur le lien ci-dessous pour reinitialiser votre mot de passe '.PHP_EOL.$lien.PHP_EOL.'    Cordialement Camagru_staff.';
		$subject = "nouveau mot de passe";
		$_SESSION['succes_mail'] = 1;
		send_mail($mail, $message, $subject);
	}
	else
		$_SESSION['error_mail'] = 1;
}
header('Location:../index.php');
?>