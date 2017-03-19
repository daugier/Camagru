<?php
session_start();
require '../function/connect_db.php';

function validate_email($email)
{
	$testmail = filter_var($email, FILTER_VALIDATE_EMAIL); 
	if($testmail == TRUE)
	{ 
    	if(checkdnsrr(array_pop(explode("@",$email)),"MX"))
      		return (true);
	}
   	return false;
}
function wrong_mail($mail)
{
	require '../function/connect_db.php'; 

	try{
		$query= $db->prepare("SELECT id FROM user WHERE mail=:mail");
		$query->execute(array(':mail' => $mail));
		$res = $query->fetch();
	}
	catch(PDOException $e)
	{
		die("Erreur ! : ".$e->getMessage() );
	}
	if ($res)
	{
		$_SESSION['error_nm'] = 1;
		return false;
	}
	if  (!validate_email($mail))
	{
		$_SESSION['error_nm'] = 2;
		return false;
	}
	return true;
}
$user = $_SESSION['user'];
$_SESSION['error_nm'] = 0;
$_SESSION['succes_nm'] = 0;
if (isset($_POST['new_mail']) && $user)
{
	$new_mail = $_POST['new_mail'];
	if (wrong_mail($new_mail))
	{
		try{
			$query= $db->prepare("UPDATE user SET mail=:mail WHERE user=:user");
			$query->execute(array(':mail' => $new_mail, ':user' => $user));
		}
		catch(PDOException $e)
		{
			die("Erreur ! : ".$e->getMessage() );
		}
		$_SESSION['succes_nm'] = 1;
		$_SESSION['mail'] = $new_mail;
	}
}
header('location:moncompte.php');
?>