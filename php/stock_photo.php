<?php
require 'connect_db.php';

session_start();
extract($_POST);
$id = $_SESSION['logged_on_user'];
if(isset($_POST['data']) && isset($_POST['name']) && isset($_POST['source']) && isset($_POST['value']))
{
	$img = $_POST["data"];
	$name = $_POST['name'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$img = base64_decode($img);
	$source = $_POST['source'];
	$valide = $_POST['value'];
	if (!file_exists('../montage'))
		mkdir('../montage');
	$handle = fopen($name, 'x');
	fwrite($handle, $img);
	fclose($handle);

	///////////////////ajout///////////////////
	header ("Content-type: image/png");
 
	// Traitement de l'image source
	$source = imagecreatefrompng($source);
	$largeur_source = imagesx($source);
	$hauteur_source = imagesy($source);
	imagealphablending($source, true);
	imagesavealpha($source, true);
	 
	// Traitement de l'image destination
	$destination = imagecreatefrompng($name);
	$largeur_destination = imagesx($destination);
	$hauteur_destination = imagesy($destination);
	  
	// Calcul des coordonnées pour placer l'image source dans l'image de destination
	$destination_x = ($largeur_destination - $largeur_source)/8;
	$destination_y =  ($hauteur_destination - $hauteur_source)/3;
	  
	// On place l'image source dans l'image de destination
	//imagecopymerge($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source, 100);

	imagecopy($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source);
	// On affiche l'image de destination
	
	imagepng($destination, $name);
	imagedestroy($source);
	imagedestroy($destination);

	/////////////////////////fin ajout//////////////////
	if ($valide == '1')
	{
		$likes = 0;
		$query= $db->prepare('SELECT user FROM user WHERE id=:id');
		$query->execute(array(':id' => $id));
		if ($res = $query->fetch())
			$user = $res['user'];
		$query= $db->prepare('INSERT INTO image (img, user, likes) VALUES(:img, :user, 	:likes)');
		$query->execute(array(':img' => $name, ':user' => $user, ':likes' => $likes));
	}
	if ($valide == '3')
	{
		unlink($name);
	}
}
?>