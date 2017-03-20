<?php
require '../function/connect_db.php';
include '../function/user.php';
include 'mail.php';

session_start();
if(isset($_POST['img']) && isset($_POST['user']) && isset($_POST['texte']) && isset($_POST['user_img']))
{
	$img = $_POST["img"];
	$user = $_POST['user'];
	$texte  = $_POST['texte'];
	$id = $_SESSION['logged_on_user'];
	$user_img = $_POST['user_img'];
	$texte = str_replace(chr(10), '<br/>', $texte); 
	while (preg_match('/<br\/><br\/>/', $texte))
		$texte = str_replace('<br/><br/>', '<br/>', $texte);
	$texte_tmp = str_replace(' ', '', $texte);
	if ($texte_tmp)
	{
		try{
			$query= $db->prepare('SELECT comment FROM image WHERE img=:img');
			$query->execute(array('img' => $img));
			$res = $query->fetch();
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		$comment = $res['comment'];
		$uniq = uniqid();
		$comment = 'user='.$user.'&text='.$texte.'&uniq='.$uniq.'//'.$comment;
		try{
			$query= $db->prepare('UPDATE image set comment=:comment WHERE img=:img');
			$query->execute(array(':comment' => $comment, 'img' => $img));
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		$mail = get_mail_by_user($user_img);
		$message = 'Une de vos photos vient d\'etre commentee par '.$user.'!'." Message : ".$texte;
		$subject = "nouveau commentaire";
		send_mail($mail, $message, $subject);
		echo $uniq;
	}
	else
		echo "no";
}
?>