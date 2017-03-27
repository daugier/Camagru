<?php
require '../function/connect_db.php';
include '../function/user.php';
include '../function/image.php';
include 'mail.php';

session_start();

if(isset($_POST['img']) && isset($_POST['text']))
{
	$img = $_POST["img"];
	$text  = $_POST['text'];

	$user = $_SESSION['user'];
	$id_img = get_id_img_by_img($img);
	$user_img = get_user_by_img($img);
	$comments = htmlspecialchars($text);
	if (!$user)
		echo 'no';
	else if ($comments && $user)
	{
		try{
			$query = $db->prepare("INSERT INTO comment (id_img, user, comments) VALUES (:id_img, :user, :comments)");
			$query->execute(array(':id_img' => $id_img, ':user' => $user, ':comments' => $comments));
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		try{
			$query = $db->prepare("SELECT MAX(id) AS max FROM comment");
			$query->execute();
			$id = $query->fetch();
			$id = $id['max'];
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		if ($user != $user_img)
		{
			$mail = get_mail_by_user($user_img);
			$message = 'Une de vos photos vient d\'etre commentee par '.$user.'!'." Message : ".$comments;
			$subject = "nouveau commentaire";
			send_mail($mail, $message, $subject);
		}
		$response = ["$user :  $comments","$id"];
		echo json_encode($response);
	}
}
?>