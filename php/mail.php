#!/usr/bin/php
<?php
$to = 'robin.patoux@hotmail.fr';
$subject = 'trolol';
$message = 'Bonjour !';
$headers = 'From: webmaster@example.com' . "\r\n" .
	 'Reply-To: augier5@hotmail.fr' . "\r\n" .
	  'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);
?>
