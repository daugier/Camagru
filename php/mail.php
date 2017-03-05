<?php

function send_mail($mail, $code, $user, $message)
{
	$to = $mail;
	$subject = 'activation compte camagru';
	$headers = 'From: camagru@camagru.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
	mail($to, $subject, $message, $headers);
}

?>