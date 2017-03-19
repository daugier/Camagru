<?php
session_start();
require '../function/connect_db.php';

$user = $_SESSION['user'];
$_SESSION['error_ad'] = 0;
$_SESSION['succes_ad'] = 0;
if (isset($_POST['compte']) && $user == 'root')
{
	$compte = $_POST['compte'];
	if ($compte == 'root')
	{
		$_SESSION['error_ad'] = 1;
		header('location:moncompte.php');
	}
	else
	{
		try{
			$query = $db->prepare("SELECT id FROM user WHERE user=:user");
			$query->execute(array(':user' => $compte));
			$res = $query->fetch();
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		if ($res)
		{
			try{
				$query = $db->prepare("DELETE FROM user WHERE user=:user");
				$query->execute(array(':user' => $compte));
			}
			catch(PDOException $e)
			{
				die("Erreur ! : ".$e->getMessage() );
			}
			$_SESSION['succes_ad'] = 1;
		}
		else
			$_SESSION['error_ad'] = 2;
	}
}
header('location:moncompte.php');
?>