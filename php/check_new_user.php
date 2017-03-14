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
	return true;
}
function wrong_user($user)
{
	require 'connect_db.php'; 
	$query= $db->prepare("SELECT id FROM user WHERE user=:user");
	$query->execute(array(':user' => $user));
	$res = $query->fetch();
	if ($res)
	{
		$_SESSION['error'] = 2;
		return false;
	}
	return true;
}
function wrong_mail($mail)
{
	require 'connect_db.php'; 
	$query= $db->prepare("SELECT id FROM user WHERE mail=:mail");
	$query->execute(array(':mail' => $mail));
	$res = $query->fetch();
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