<?php
require 'connect_db.php';

session_start();
header("Content-Type: text");
$data = (isset($_POST["data"])) ? $_GET["data"] : NULL;

if ($data) {
	echo "Bonjour  ! Je vois que votre pseudo est ";
} else {
	echo "FAIL";
}
?>