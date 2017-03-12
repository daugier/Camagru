<?php
	function get_user_by_id($id)
	{
		require 'connect_db.php';

		$query= $db->prepare('SELECT user FROM user WHERE id=:id');
		$query->execute(array(':id' => $id));
		if ($res = $query->fetch())
			$user = $res['user'];
		return ($user);
	}
?>