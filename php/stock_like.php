<?php
require 'connect_db.php';

session_start();
extract($_POST);
$id = $_POST['id'];
$likes = $_POST['like'];
if ($id)
{
	$query= $db->prepare('UPDATE image set likes=:likes WHERE id=:id');
	$query->execute(array(':likes' => $likes, ':id' => $id));
}
?>