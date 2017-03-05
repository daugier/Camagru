<?php
	session_start();
	require 'connect_db.php';

	$mail = $_GET['mail'];
	$code = $_GET['code'];
	$query = $db->prepare("SELECT id FROM user WHERE mail=:mail AND code=:code");
	$query->execute(array(':mail' => $mail, ':code' => $code));
	$res = $query->fetch();
	if ($res)
		header('location:http://localhost:8080/camagru/index.php#accueil');
	else
		header('location:http://localhost:8080/camagru/index.php');
?>
	<html>
	<head>
		<meta charset="UTF-8">
		<title>Camagru</title>
			<link type="text/css" href="css/main.css" media="all" rel="stylesheet"/>
	</head>
	<body>
		<center>
			<div class="menu">
				<ul>
					<li><a href="">Accueil</a></li>
					<?php
						if ($_SESSION["logged_on_user"])
						{
							echo '<li><a href="php/disconnect.php">Deconnexion</a></li>';
							echo '<li><a href="php/camera.php">Photomaton</a></li>';
						}
						else
						{
							echo '<li><a href="#login">Connexion</a></li>';
							echo '<li><a href="#register">Inscription</a></li>';
						}
					?>
					<li><a href="php/galerie.php">Galerie</a></li>
				</ul>
			</div>
			<div id="login" class="shadow">
				<div class="form">
					<form class="connexion" action="php/login.php" method="post" target="_self">
						<h3>Connexion</h3>
						<div>
							<label>Identidiant</label>
							<input type="text" placeholder="Entrez identifiant" name="user" required>
							<label>Mot de passe</label>
							<input type="password" placeholder="Entrez mot de passe" name="password" required>
							<button class="btn" type="submit" value="OK">Go</button>
							<a href="#code">Mot de passe oublie ?</a>
              				<a href="#" class="quit">Fermer</a>
						</div>
					</form>
				</div>
			</div>
			<div id="register" class="shadow">
				<div class="form">
					<form class="Inscription" action="php/register.php" method="post" target="_self">
						<h3>Inscription</h3>
						<div>
							<label>Adresse Mail</label>
							<input type="text" placeholder="Entrez votre mail" name="mail" required>
							<label>Identidiant</label>
							<input type="text" placeholder="Entrez identifiant" name="user" required>
							<label>Mot de passe</label>
							<input type="password" placeholder="Entrez mot de passe" name="password" required>
							<button class="btn" type="submit" value="OK">Go</button>
              				<a href="#" class="quit">Fermer</a>
						</div>
					</form>
				</div>
			</div>
			<div id="code" class="shadow">
				<div class="form">
					<form class="code" action="php/forget_password.php" method="post" target="_self">
						<h3>Mot de passe oublie ?</h3>
						<div>
							<label>Adresse Mail</label>
							<input type="text" placeholder="Entrez votre mail" name="mail" required>
							<button class="btn" type="submit" value="OK">Envoyer un mail</button>
              				<a href="#" class="quit">Fermer</a>
						</div>
					</form>
				</div>
			</div>
			<div id="main">
				<footer>
	                <p>© Copyright daugier 2017</p>
				</footer>
           	</div>
		</center>
	</body>
</html>
?>