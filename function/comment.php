<?php
	function sub_commentaire($comment, $id)
	{
		require 'connect_db.php';

		$query= $db->prepare('UPDATE image set comment=:comment WHERE id=:id');
		$query->execute(array(':comment' => $comment, ':id' => $id));
	}
?>