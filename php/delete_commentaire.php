<?php
include "../function/image.php";
include "../function/comment.php";

session_start();

if(isset($_POST['id']))
{
	$user = $_SESSION['user'];
	$id = $_POST['id'];

	if (!$user)
		echo 'no';
	$user_comment = get_user_by_id_com($id);
	if ($user === $user_comment || $user === 'root')
	{
		$res = sub_commentaire($id);
		if ($res)
		{
			echo "yes";
		}
	}
}
?>