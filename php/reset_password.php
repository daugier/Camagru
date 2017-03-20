<?php
session_start();
if (!$_GET['code'])
	header('location:../index.php');
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Camagru</title>
			<link type="text/css" href="../css/main.css" media="all" rel="stylesheet"/>
	</head>
	<body>
		<center>
			<div class="menu">
				<ul>
					<li><a href="../index.php">Accueil</a></li>
					<?php
						if ($_SESSION["logged_on_user"])
						{
							echo '<li><a href="disconnect.php">Deconnexion</a></li>';
							echo '<li><a href="camera.php">Photomaton</a></li>';
						}
						else
						{
							echo '<li><a href="#login">Connexion</a></li>';
							echo '<li><a href="#register">Inscription</a></li>';
						}
					?>
					<li><a href="galrie.php">Galerie</a></li>
				</ul>
			</div>
			<div>
			<?php
				if ($_SESSION['error_new_p'] == 1)
					echo '<br><div id="need_connect">Les deux mots de passes ne sont pas identiques</div>';
				if ($_SESSION['error_new_p'] == 2)
					echo '<br><div id="need_connect">Le mot de passe est trop court, minimum 6 caracteres</div>';
				if ($_SESSION['error_new_p'] == 3)
					echo '<br><div id="need_connect">Le mot de passe doit contenir que des chiffres et des lettres</div>';
				$_SESSION['error_new_p'] = 0;
			?>
				<div>
					<form class="reset_pass" action="reset_pass.php" method="post" target="_self">
						<h2>Reinitialiser mon mot de passe</h2>
						<div>
							<label>Mot de passe : </label>
							<input type="password" placeholder="Entrez mot de passe" name="password" required>
							<br><br><label>Repetez mot de passe : </label>
							<input type="password" placeholder="Entrez mot de passe" name="password2" required>
							<?php 
								$code = $_GET['code'];
								echo '<input style="display:none;" name="code" value="'.$code.'">';
							?>
							<br><br><button class="btn" type="submit" value="OK">Changer le mot de passe</button>
						</div>
					</form>
				</div>
			</div>
			<div id="login" class="shadow">
				<div class="form">
					<form class="connexion" action="login.php" method="post" target="_self">
						<h3>Connexion</h3>
						<div>
							<label>Identidiant</label>
							<input type="text" placeholder="Entrez identifiant" name="login" required>
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
					<form class="Inscription" action="register.php" method="post" target="_self">
						<h3>Inscription</h3>
						<div>
							<label>Identidiant</label>
							<input type="text" placeholder="Entrez identifiant" name="login" required>
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
					<form class="code" action="forget_password.php" method="post" target="_self">
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