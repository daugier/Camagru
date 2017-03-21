<?php
session_start();
require '../function/connect_db.php';

function wrong_user($user)
{
	require '../function/connect_db.php'; 

	try{
		$query= $db->prepare("SELECT id FROM user WHERE user=:user");
		$query->execute(array(':user' => $user));
		$res = $query->fetch();
	}
	catch(PDOException $e)
	{
		die("Erreur ! : ".$e->getMessage() );
	}
	if ($res)
	{
		$_SESSION['error_ni'] = 1;
		return false;
	}
	if (preg_match('/^[a-zA-Z]*$/', $user) == false)
	{
		$_SESSION['error_ni'] = 2;
		return false;
	}
	if (strlen($user) > 10)
	{
		$_SESSION['error_ni'] = 3;
		return false;
	}
	return true;
}
$user = $_SESSION['user'];
$_SESSION['error_ni'] = 0;
$_SESSION['succes_ni'] = 0;
$id = $_SESSION['logged_on_user'];
$_SESSION['error_ni_ad'] = 0;
if (isset($_POST['new_ident']) && $user)
{
	$new_ident = $_POST['new_ident'];
	if ($_SESSION['user'] == 'root')
	{
		$_SESSION['error_ni_ad'] = 1;
	}
	else if (wrong_user($new_ident))
	{
		try{
			$query= $db->prepare("UPDATE user SET user=:user WHERE id=:id");
			$query->execute(array(':user' => $new_ident, ':id' => $id));
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		$_SESSION['succes_ni'] = 1;
		$_SESSION['user'] = $new_ident;
	}
}
header('location:moncompte.php');
?>