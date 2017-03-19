<?php 
	session_start(); 
	if (file_exists('config/first_connection'))
	{
		include("config/setup.php");
		unlink('config/first_connection');
		header('location:localhost:8080/camagru/index.php');
	}
	$url = $_SERVER[REQUEST_URI];
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Camagru</title>
			<link type="text/css" href="css/main.css" media="all" rel="stylesheet"/>
	</head>
	<body onload="setTimeout(cacherDiv,2000);">
	<script>
		function cacherDiv()
		{
			if (document.getElementById('connec_ok'))
    			document.getElementById("connec_ok").style.visibility = "hidden";
		}
	</script>
		<center>
			<div class="menu">
				<ul>
					<li><a id="on" href="">Accueil</a></li>
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
				<p><i><?php 
					$user = $_SESSION['user'];
					if ($user)
						echo '<a href="php/moncompte.php">user : '.$user.'</a>';
				?></i></p>
			</div>
			<div id="login" class="shadow">
				<div class="form">
					<form class="connexion" action="php/login.php" method="post" target="_self">
						<h3>Connexion</h3>
						<div>
							<?php
								if ($_SESSION['error'] == 5)
									echo '<label id="wrong_login">Mauvais mot de passe ou identifiant</label><br>';
							?>
							<label>Identidiant : </label>
							<input type="text" placeholder="Entrez identifiant" name="user" required>
							<br><label>Mot de passe : </label>
							<input type="password" placeholder="Entrez mot de passe" name="password" required>
							<br><button class="btn" type="submit" value="OK">Me connecter</button>
							<br><a href="#code">Mot de passe oublie ?</a>
							<br><a href="" class="quit" align="right">Fermer</a>
              				<?php
              				echo '<input style="display:none;" name="url" value="'.$url.'"/>';
              				?>
						</div>
					</form>
				</div>
			</div>
			<?php
				if ($_SESSION['valid'] == 1)
					echo '<div id="connec_ok">inscription enregistrer !<br> Allez voir vos mails pour confirmer l\'inscription</div>';
				if ($_SESSION['valid'] == 2)
					echo '<div id="connec_ok">connexion reussi !</div>';
				if ($_SESSION['valid'] == 9)
					echo '<div id="connec_ok">Compte Camagru confirmer, felicitation !</div>';
				$_SESSION['valid'] = 0;
			?>
			<div id="contenu">
				<h1>Bienvenue sur CAMAGRU</h1>
				<p>Camagru est une application web qui permet de faire des montages photos directement de votre webcam</p>
				<p>Si vous n'avez pas de webcam, vous pouvez uploader les photos que vous souhaitez</p>
				<b>Pour avoir acces au photomaton, commenter et liker les photos vous devez etre connecter</b>
				<p>L'inscription a l'application est finalisee par un mail de validation</p>
				<p>Rejoignez nous pour faire de beaux montages photos !</p>
			</div>
			<div id="register" class="shadow">
				<div class="form">
					<form class="Inscription" action="php/register.php" method="post" target="_self">
						<h3>Inscription</h3>
						<div>
						<?php
							if ($_SESSION['error'] == 1)
								echo '<label id="wrong_login">Mot de passe trop court</label><br>';
							if ($_SESSION['error'] == 2)
								echo '<label id="wrong_login">identifiant deja utilise</label><br>';
							if ($_SESSION['error'] == 3)
								echo '<label id="wrong_login">Mail deja existant</label><br>';
							if ($_SESSION['error'] == 4)
								echo '<label id="wrong_login">Mail invalide</label><br>';
							if ($_SESSION['error'] == 5)
								echo '<label id="wrong_login">votre identifiant doit contenir que des lettres</label><br>';
							if ($_SESSION['error'] == 6)
								echo '<label id="wrong_login">votre identifiant doit contenir 10 caracteres maximum</label><br>';
							if ($_SESSION['error'] == 7)
								echo '<label id="wrong_login">Votre mot de passe doit contenir que des lettres et des chiffres</label><br>';
							$_SESSION['error'] = 0;
						?>
							<label>Adresse Mail : </label>
							<input type="text" placeholder="Entrez votre mail" name="mail" required>
							<br><label>Identidiant : </label>
							<input type="text" placeholder="Entrez identifiant" name="user" required>
							<br><label>Mot de passe : </label>
							<input type="password" placeholder="Entrez mot de passe" name="password" required>
							<br><button class="btn" type="submit" value="OK">m'inscrire</button>
              				<br><a href="" class="quit">Fermer</a>
              				<?php
              				echo '<input style="display:none;" name="url" value="'.$url.'"/>';
              				?>
						</div>
					</form>
				</div>
			</div>
			<div id="code" class="shadow">
				<div class="form">
					<form class="code" action="php/forget_password.php" method="post" target="_self">
						<h3>Mot de passe oublie ?</h3>
						<div>
							<label>Adresse Mail : </label>
							<input type="text" placeholder="Entrez votre mail" name="mail" required>
							<button class="btn" type="submit" value="OK">Envoyer un mail</button>
              				<a href="index.php" class="quit">Fermer</a>
              				<?php
              				echo '<input style="display:none;" name="url" value="'.$url.'"/>';
              				?>
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