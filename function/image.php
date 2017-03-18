<?php
	function add_image($user, $image)
	{
		require 'connect_db.php';

		$likes = 0;
		$date = date("Y-m-d H:i:s");
		$query= $db->prepare('INSERT INTO image (img, user, likes, img_date) VALUES(:img, :user, :likes, :img_date)');
		$query->execute(array(':img' => $image, ':user' => $user, ':likes' => $likes, ':img_date' => $date));
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
	function get_comment_by_img($image)
	{
		require 'connect_db.php';

		try{
			$query= $db->prepare('SELECT comment FROM image WHERE img=:img');
			$query->execute(array(':img' => $image));
			$commentaires = $query->fetch();
		}
		catch(PDOException $e){
			echo("Erreur ! : ".$e->getMessage() );
		}
		$query->closeCursor();
		return ($commentaires);
	}
	function get_comment_by_id($id)
	{
		require 'connect_db.php';

		try{
			$query= $db->prepare('SELECT comment FROM image WHERE id=:id');
			$query->execute(array(':id' => $id));
			$commentaires = $query->fetch();
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

		$query= $db->prepare('SELECT img FROM image');
		$query->execute();
		$res = $query->fetchall();
		return ($res);
	}
	function get_date_by_img($img)
	{
		require 'connect_db.php';

		$query= $db->prepare('SELECT img_date FROM image WHERE img=:img');
		$query->execute(array(':img' => $img));
		$res = $query->fetch();
		return ($res);
	}
?>