<?php
include('database.php');
try
{
	echo("---------Creation base de donnees----------\n\n\n");
	$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = 'CREATE DATABASE IF NOT EXISTS camagru_db';
	$pdo->exec($sql);

	
}
catch(PDOException $e)
{
	die("Erreur ! : ".$e->getMessage() );
}
try
{
	echo("-----------Creation table users------------\n");
	$pdo = new PDO($DB_DSNB, $DB_USER, $DB_PASSWORD);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "USE camagru_db;";
	$pdo->exec($sql);
	$sql = "CREATE TABLE IF NOT EXISTS user
		(
			id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
			user VARCHAR(255),
			mail VARCHAR(255),
			password VARCHAR(255),
			code INT,
			ok INT
		)";
	$pdo->exec($sql);
	$sql = "TRUNCATE TABLE user";
	$pdo->exec($sql);
	echo("--------------Table users cree-------------\n");
}
catch(PDOException $e)
{
	die("Erreur ! : ".$e->getMessage() );
}
try
{
	echo("-----------Creation table image------------\n");
	$pdo = new PDO($DB_DSNB, $DB_USER, $DB_PASSWORD);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "USE camagru_db;";
	$pdo->exec($sql);
	$sql = "CREATE TABLE IF NOT EXISTS image
		(
			id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
			img VARCHAR(255),
			user VARCHAR(255),
			likes INT(255)
		)";
	$pdo->exec($sql);
	$sql = "TRUNCATE TABLE image";
	$pdo->exec($sql);
	echo("--------------Table image cree-------------\n");
	echo("\n\n-----------Base de donnes creee------------\n");
}
catch(PDOException $e)
{
	die("Erreur ! : ".$e->getMessage() );
}
?>
