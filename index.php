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
					<?php
						if ($_SESSION["logged_on_user"])
						{
							echo '<li><a href="logout.php">Deconnexion</a></li>';
							echo '<li><a href="photomaton.php">Photomaton</a></li>';
						}
						else
						{
							echo '<li><a href="#login">Connexion</a></li>';
							echo '<li><a href="#register">Inscription</a></li>';
							echo '<li><a href="#code">Code activation</a></li>';
						}
					?>
					<li><a href="galerie.php">Galerie</a></li>
				</ul>
			</div>
			<div id="login" class="shadow">
				<div class="form">
					<form class="connexion" action="register.php" method="get" target="_self">
						<h3>Connexion</h3>
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
			<div id="register" class="shadow">
				<div class="form">
					<form class="Inscription" action="register.php" method="get" target="_self">
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
					<form class="connexion" action="register.php" method="get" target="_self">
						<h3>code</h3>
						<div>
							<label>Mon code</label>
							<input type="text" placeholder="Entrez identifiant" name="login" required>
              				<a href="#" class="quit">Fermer</a>
						</div>
					</form>
				</div>
			</div>
			<footer>
				<p>Mon footer</p>
			</footer>
		</center>
	</body>
</html>