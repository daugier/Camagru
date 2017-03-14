<?php
include '../function/image.php';

if(isset($_POST['img']))
{
	$img = $_POST['img'];
	sub_img($img);
	unlink($img);
}
?>
