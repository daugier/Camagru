<?php
require '../function/connect_db.php';
include '../function/photo.php';
include '../function/image.php';
include '../function/user.php';

$id = $_SESSION['logged_on_user'];
if(isset($_POST['data']) && isset($_POST['source']) && isset($_POST['value']) && isset($_POST['name']))
{

	$data= $_POST["data"];
	$source = $_POST['source'];
	$valide = $_POST['value'];
	$url_img = $_POST['name'];

	if ($valide == '0')
	{
		$url_img = create_url('.png');
		$img = decode_data($data);
		new_dir('../montage');
		write_to_file($url_img, $img);
	}
	if ($valide == '1')
	{
		$user = get_user_by_id($id);
		add_image($user, $url_img);
	}
	else
		write_png_to_photo($source, $url_img);
	if ($valide == '3')
		unlink($url_img);
	echo $url_img;
}
?>