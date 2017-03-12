<?php
	function add_image($user, $image)
	{
		require 'connect_db.php';

		$likes = 0;
		$query= $db->prepare('INSERT INTO image (img, user, likes) VALUES(:img, :user, 	:likes)');
		$query->execute(array(':img' => $image, ':user' => $user, ':likes' => $likes));
	}
	function sub_img($img)
	{
		require 'connect_db.php';

		$likes = 0;
		$query= $db->prepare('DELETE FROM image WHERE img=:img');
		$query->execute(array(':img' => $img));
	}
?>