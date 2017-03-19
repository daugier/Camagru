<?php
session_start();
require '../function/connect_db.php';

function wrong_password($password)
{
	if (strlen($password) < 6)
	{	
		$_SESSION['error_np'] = 3;
		return false;
	}
	if (preg_match('/^[a-zA-Z0-9]*$/', $password) == false)
	{
		$_SESSION['error_np'] = 4;
		return false;
	}
	return true;
}

$user = $_SESSION['user'];
$_SESSION['error_np'] = 0;
$_SESSION['succes'] = 0;
if (isset($_POST['ancien_pass']) && isset($_POST['new_pass']) && isset($_POST['new_pass_2']) && $user)
{
	$ancien_pass = hash('whirlpool', $_POST['ancien_pass']);
	$new_pass = $_POST['new_pass'];
	$new_pass_2 = $_POST['new_pass_2'];
	try{
		$query= $db->prepare('SELECT password FROM user WHERE user=:user');
		$query->execute(array(':user' => $user));
		$res = $query->fetch();
	}
	catch(PDOException $e){
		die("Erreur ! : ".$e->getMessage() );
	}
	if ($res['password'] != $ancien_pass)
	{
		$_SESSION['error_np'] = 1;
		header('location:moncompte.php');
	}
	else if ($new_pass != $new_pass_2)
	{
		$_SESSION['error_np'] = 2;
		header('location:moncompte.php');
	}
	else if (wrong_password($new_pass))
	{
		$new_pass = hash('whirlpool', $_POST['new_pass']);
		try{
			$query= $db->prepare('UPDATE user SET password=:password WHERE user=:user');
			$query->execute(array(':password' => $new_pass, ':user' => $user));
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		$_SESSION['succes'] = 1;
	}
}
header('location:moncompte.php');
?>