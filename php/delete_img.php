<?php
include '../function/image.php';

session_start();

$user = $_SESSION['user'];
$id_user = $_SESSION['id'];
if(isset($_POST['img']))
{
	$img = $_POST['img'];
	$user_img = get_user_by_img($img);
	if ($user === $user_img || $user === 'root')
	{
		sub_img($img);
		unlink($img);
		echo 'yes';
	}
	else
		echo 'no';
}
?>
