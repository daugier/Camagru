<?php
require 'connect_db.php';

session_start();
extract($_POST);
$id = $_POST['id'];
$likes = $_POST['like'];
$user = $_POST['user'];
$user_likes = $_POST['user_likes'];
$add = $_POST['add'];
if ($id)
{
	if ($add > 0)
	{
		$user_likes = $user_likes.'/'.$user;
	}
	else if ($add < 0)
	{
		$user_likes = str_replace($user, '', $user_likes);
	}
	$query= $db->prepare('UPDATE image set likes=:likes WHERE id=:id');
	$query->execute(array(':likes' => $likes, ':id' => $id));

	$query= $db->prepare('UPDATE image set user_likes=:user_likes WHERE id=:id');
	$query->execute(array(':user_likes' => $user_likes, ':id' => $id));
}
?>