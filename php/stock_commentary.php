<?php
require 'connect_db.php';

session_start();
extract($_POST);
$id = $_SESSION['logged_on_user'];
$img = $_POST["img"];
$user = $_POST['user'];
$texte  = $_POST['texte'];
if ($texte)
{
	$query= $db->prepare('SELECT comment FROM image WHERE img=:img');
	$query->execute(array('img' => $img));
	$res = $query->fetch();
	$comment = $res['comment'];
	$comment = 'user='.$user.'&text='.$texte.'//'.$comment;
	$query= $db->prepare('UPDATE image set comment=:comment WHERE img=:img');
	$query->execute(array(':comment' => $comment, 'img' => $img));
}
?>