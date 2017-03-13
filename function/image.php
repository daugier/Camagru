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
	function get_likes_by_img($img)
	{
		require 'connect_db.php';

		$query= $db->prepare('SELECT likes FROM image WHERE img=:img');
		$query->execute(array(':img' => $img));
		$likes = $query->fetch();
		$likes = $likes['likes'];
		return ($likes);	
	}
	function get_user_likes_by_img($img)
	{
		require 'connect_db.php';

		$query= $db->prepare('SELECT user_likes FROM image WHERE img=:img');
		$query->execute(array(':img' => $img));
		$user_likes = $query->fetch();
		$user_likes = $user_likes['user_likes'];
		return ($user_likes);
	}
	function get_id_img_by_img($img)
	{
		require 'connect_db.php';

		$query= $db->prepare('SELECT id FROM image WHERE img=:img');
		$query->execute(array(':img' => $img));
		$id = $query->fetch();
		$id = $id['id'];
		return ($id);
	}
	function get_user_by_img($img)
	{
		require 'connect_db.php';

		$query= $db->prepare('SELECT user FROM image WHERE img=:img');
		$query->execute(array(':img' => $img));
		$user_img = $query->fetch();
		$user_img = $user_img['user'];
		return ($user_img);
	}
	function get_comment_by_img($img)
	{
		require 'connect_db.php';

		$query= $db->prepare('SELECT comment FROM image WHERE img=:img');
		$query->execute(array(':img' => $img));
		$commentaires = $query->fetch();
		return ($commentaires);
	}
	function list_image()
	{
		require 'connect_db.php';

		$query= $db->prepare('SELECT img FROM image');
		$query->execute();
		$res = $query->fetchall();
		return ($res);
	}
?>