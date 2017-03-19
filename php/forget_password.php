<?php
require '../function/connect_db.php';
include 'mail.php';
include 'check_new_user.php';

session_start();

$mail = $_POST['mail'];
if ($mail)
{
	if (!wrong_mail($mail))
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
		$lien = 'http://localhost:8080/camagru/php/active_link_pass.php?code='.$code.'&mail='.$mail;
		$message = 'Bonjour, veuillez cliquez sur le lien ci-dessous pour reinitialiser votre mot de passe '.PHP_EOL.$lien.PHP_EOL.'    Cordialement Camagru_staff.';
		$subject = "nouveau mot de passe";
		send_mail($mail, $message, $subject);
	}
}
header('Location:http://localhost:8080/camagru/index.php');
?>