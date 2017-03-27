<?php
include('database.php');

/*echo("---------Creation base de donnees-----------\n");*/

try
{
	$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	die("Erreur ! : ".$e->getMessage() );
}

/*------------------------------------------------------------------------------------*/

$sql = 'DROP DATABASE IF EXISTS '.$DB_NAME.'CREATE DATABASE IF NOT EXISTS '.$DB_NAME;

try
{
	$pdo->exec($sql);
}
catch(PDOException $e)
{
	die("Erreur ! : ".$e->getMessage() );
}

/*-------------------------------------------------------------------------------------*/

$sql = 'USE '.$DB_NAME;

try
{
	$pdo->exec($sql);
}
catch(PDOException $e)
{
	die("Erreur ! : ".$e->getMessage() );
}

/*echo "-----------Base de donnees creee------------\n";*/

/*------------------------------------------------------------------------------------*/

/*echo("-----------Creation table users-------------\n");*/

$sql = 'CREATE TABLE user
		(
			id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
			user VARCHAR(255),
			mail VARCHAR(255),
			password VARCHAR(255),
			code INT,
			ok INT)';
try
{
	$pdo->exec($sql);
}
catch(PDOException $e)
{
	die("Erreur ! : ".$e->getMessage() );
}

/*echo("-------------Table users creee--------------\n");*/

/*------------------------------------------------------------------------------------*/

/*echo("-----------Creation table images------------\n");*/

$sql = 'CREATE TABLE image
		(
			id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
			img TEXT,
			user VARCHAR(255),
			likes INT(255),
			user_likes TEXT,
			img_date TEXT)';
try
{
	$pdo->exec($sql);
}
catch(PDOException $e)
{
	die("Erreur ! : ".$e->getMessage() );
}

$sql = 'CREATE TABLE comment
		(
			id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
			id_img INT,
			user VARCHAR(255),
			comments TEXT)';
try
{
	$pdo->exec($sql);
}
catch(PDOException $e)
{
	die("Erreur ! : ".$e->getMessage() );
}

/*echo("-------------Table images cree--------------\n");*/

/*------------------------------------------------------------------------------------*/

/*echo("---------ajout admin en root/root-----------\n");*/

$user = 'root';
$mail = 'daugier@student.42.fr';
$password = hash('whirlpool', 'root');
$sql = sprintf("INSERT INTO user (user, mail, password, ok)
				VALUES ('%s', '%s', '%s', '1')", $user, $mail, $password);
try
{
	$pdo->query($sql);
}
catch(PDOException $e)
{
	echo("l'ajout admin a echoue : ".$e->getMessage());
}

/*echo("------------ajout admin termine-------------\n");*/
?>
