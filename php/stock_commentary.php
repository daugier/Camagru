<?php
require 'connect_db.php';
include '../function/user.php';
include 'mail.php';

session_start();
if(isset($_POST['img']) && isset($_POST['user']) && isset($_POST['texte']))
{
	$img = $_POST["img"];
	$user = $_POST['user'];
	$texte  = $_POST['texte'];
	$id = $_SESSION['logged_on_user'];
	$texte = str_replace(chr(10), '<br/>', $texte); 
	while (preg_match('/<br\/><br\/>/', $texte))
		$texte = str_replace('<br/><br/>', '<br/>', $texte);
	if ($texte)
	{
		$query= $db->prepare('SELECT comment FROM image WHERE img=:img');
		$query->execute(array('img' => $img));
		$res = $query->fetch();
		$comment = $res['comment'];
		$comment = 'user='.$user.'&text='.$texte.'//'.$comment;
		$query= $db->prepare('UPDATE image set comment=:comment WHERE img=:img');
		$query->execute(array(':comment' => $comment, 'img' => $img));
		$mail = get_usermail_by_id($id);
		$message = "une de vos photos vient d'etre commentee ! \n\nmessage : ".$texte;
		$subject = "nouveau commentaire";
		send_mail($mail, $message, $subject);
	}
}
?>