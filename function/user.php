<?php
	function get_user_by_id($id)
	{
		require 'connect_db.php';

		try {
			$query= $db->prepare('SELECT user FROM user WHERE id=:id');
			$query->execute(array(':id' => $id));
			if ($res = $query->fetch())
				$user = $res['user'];
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		return ($user);
	}
	function get_usermail_by_id($id)
	{
		require 'connect_db.php';

		try{
			$query= $db->prepare('SELECT mail FROM user WHERE id=:id');
			$query->execute(array(':id' => $id));
			if ($res = $query->fetch())
				$mail = $res['mail'];
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		return ($mail);
	}
	function get_id_byuser_and_code($user, $code)
	{
		require 'connect_db.php';

		try {
			$query = $db->prepare("SELECT id FROM user WHERE user=:user AND code=:code");
			$query->execute(array(':user' => $user, ':code' => $code));
			$res = $query->fetch();
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		return ($res);
	}
	function update_ok_user($user)
	{
		require 'connect_db.php';

		try {
			$query= $db->prepare("UPDATE user set ok=1 WHERE user=:user");
			$query->execute(array(':user' => $user));
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
	}
	function update_code_user($user)
	{
		require 'connect_db.php';

		try {
			$query= $db->prepare('UPDATE user set code=:code WHERE user=:user');
			$query->execute(array(':code' => NULL, ':user' => $user));
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
	}
	function select_id_user_from_mailandcode($mail, $code)
	{
		require 'connect_db.php';

		try {
			$query = $db->prepare("SELECT id FROM user WHERE mail=:mail AND code=:code");
			$query->execute(array(':mail' => $mail, ':code' => $code));
			$res = $query->fetch();
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		return ($res);
	}
?>