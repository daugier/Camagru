<?php
	function add_image($user, $image)
	{
		require 'connect_db.php';

		$likes = 0;
		$date = date("Y-m-d H:i:s");
		try{
			$query= $db->prepare('INSERT INTO image (img, user, likes, img_date) VALUES(:img, :user, :likes, :img_date)');
			$query->execute(array(':img' => $image, ':user' => $user, ':likes' => $likes, ':img_date' => $date));
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
	}
	function sub_img($img)
	{
		require 'connect_db.php';

		$likes = 0;
		try{
		$query= $db->prepare('DELETE FROM image WHERE img=:img');
		$query->execute(array(':img' => $img));
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
	}
	function get_likes_by_img($img)
	{
		require 'connect_db.php';

		try{
			$query= $db->prepare('SELECT likes FROM image WHERE img=:img');
			$query->execute(array(':img' => $img));
			$likes = $query->fetch();
			$likes = $likes['likes'];
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		return ($likes);	
	}
	function get_user_likes_by_img($img)
	{
		require 'connect_db.php';

		try{
			$query= $db->prepare('SELECT user_likes FROM image WHERE img=:img');
			$query->execute(array(':img' => $img));
			$user_likes = $query->fetch();
			$user_likes = $user_likes['user_likes'];
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		return ($user_likes);
	}
	function get_id_img_by_img($img)
	{
		require 'connect_db.php';

		try{
			$query= $db->prepare('SELECT id FROM image WHERE img=:img');
			$query->execute(array(':img' => $img));
			$id = $query->fetch();
			$id = $id['id'];
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		return ($id);
	}
	function get_user_by_img($img)
	{
		require 'connect_db.php';

		try {
			$query= $db->prepare('SELECT user FROM image WHERE img=:img');
			$query->execute(array(':img' => $img));
			$user_img = $query->fetch();
			$user_img = $user_img['user'];
		}
		catch(PDOException $e)
		{
			echo("Erreur ! : ".$e->getMessage() );
		}
		return ($user_img);
	}
	function get_user_by_id_com($id)
	{
		require 'connect_db.php';

		try{
			$query= $db->prepare('SELECT user FROM comment WHERE id=:id');
			$query->execute(array(':id' => $id));
			$user = $query->fetch();
		}
		catch(PDOException $e){
			die("Erreur ! : ".$e->getMessage() );
		}
		$query->closeCursor();
		return ($user['user']);
	}
	function get_comment_by_id_img($id)
	{
		require 'connect_db.php';

		try{
			$query= $db->prepare('SELECT * FROM comment WHERE id_img=:id_img');
			$query->execute(array(':id_img' => $id));
			$commentaires = $query->fetchall();
		}
		catch(PDOException $e){
			echo("Erreur ! : ".$e->getMessage() );
		}
		$query->closeCursor();
		return ($commentaires);
	}
	function list_image()
	{
		require 'connect_db.php';

		try{
			$query= $db->prepare('SELECT img FROM image');
			$query->execute();
			$res = $query->fetchall();
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		return ($res);
	}
	function get_date_by_img($img)
	{
		require 'connect_db.php';

		try{
			$query= $db->prepare('SELECT img_date FROM image WHERE img=:img');
			$query->execute(array(':img' => $img));
			$res = $query->fetch();
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		return ($res);
	}
	function get_img_by_user($user)
	{
		require 'connect_db.php';

		try{
			$query= $db->prepare('SELECT img FROM image WHERE user=:user');
			$query->execute(array(':user' => $user));
			$res = $query->fetchall();
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		return ($res);
	}
?>