<?php
require 'connect_db.php';

if (isset($_POST['user']) && isset($_POST['user_likes']) && isset($_POST['like']) && isset($_POST['add']) && isset($_POST['id']))
{
	$id = $_POST['id'];
	$likes = $_POST['like'];
	$user = $_POST['user'];
	$user_likes = $_POST['user_likes'];
	$add = $_POST['add'];
	if ($add == '1')
		$user_likes = $user_likes.';'.$user;
	else
	{
		$user_likes = str_replace(' ', '', $user_likes);
		$user_likes = str_replace(';'.$user, '', $user_likes);
	}
	$query= $db->prepare('UPDATE image set likes=:likes WHERE id=:id');
	$query->execute(array(':likes' => $likes, ':id' => $id));

	$query= $db->prepare('UPDATE image set user_likes=:user_likes WHERE id=:id');
	$query->execute(array(':user_likes' => $user_likes, ':id' => $id));
}
?>