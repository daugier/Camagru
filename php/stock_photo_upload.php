<?php
require '../function/connect_db.php';
include '../function/photo.php';
include '../function/image.php';
include '../function/user.php';

$id = $_SESSION['logged_on_user'];
if(isset($_POST['source']) && isset($_POST['value']) && isset($_POST['name']))
{

	$source = $_POST['source'];
	$valide = $_POST['value'];
	$url_img = $_POST['name'];
	$x = $_POST['x'];
	$y = $_POST['y'];

	if ($valide == '3')
		unlink($url_img_tmp);
	$type = get_extention($url_img);
	$url_img_tmp = create_url($type);
	new_dir('../montage');
	redimension_image($url_img);
	copy($url_img, $url_img_tmp);
	if ($valide == '1')
	{
		$user = get_user_by_id($id);
		add_image($user, $url_img_tmp);
	}
	else
		write_png_to_photo($source, $url_img_tmp, $x, $y);
	echo $url_img_tmp;
}
?>