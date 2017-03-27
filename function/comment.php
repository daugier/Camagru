<?php
	function sub_commentaire($id)
	{
		require 'connect_db.php';

		try{
			$query= $db->prepare('DELETE FROM comment WHERE id=:id');
			$query->execute(array(':id' => $id));
			$res = $query->rowCount();
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		return ($res);
	}
?>