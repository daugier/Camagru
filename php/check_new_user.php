<?php
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
function wrong_pass($password)
{
	if (strlen($password) < 6)
	{
		$_SESSION['error'] = 1;
		return false;
	}
	if (preg_match('/^[a-zA-Z0-9]*$/', $password) == false)
	{
		$_SESSION['error'] = 7;
		return false;
	}
	return true;
}
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
		$_SESSION['error'] = 2;
		return false;
	}
	if (preg_match('/^[a-zA-Z]*$/', $user) == false)
	{
		$_SESSION['error'] = 5;
		return false;
	}
	if (strlen($user) > 10)
	{
		$_SESSION['error'] = 6;
		return false;
	}
	return true;
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
		$_SESSION['error'] = 3;
		return false;
	}
	if  (!validate_email($mail))
	{
		$_SESSION['error'] = 4;
		return false;
	}
	return true;
}
?>