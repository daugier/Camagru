<?php
	session_start(); 
	
	if (!$_SESSION['logged_on_user'])
		header('location:http://localhost:8080/camagru/index.php');
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
							echo '<li><a href="">Photomaton</a></li>';
						}
						else
						{
							echo '<li><a href="#login">Connexion</a></li>';
							echo '<li><a href="#register">Inscription</a></li>';
						}
					?>
					<li><a href="galerie.php">Galerie</a></li>
				</ul>
			</div>
			<div class="all">
				<div class="image_montage">
					<img src="../img/1.png">
					<br/><button>Utiliser</button>
					<br/><img src="../img/2.jpeg">
					<br/><button>Utiliser</button>
				</div>
				<div class="montage" id="placehere">
				</div>
				<div id="container">
					<br/><video  autoplay ></video>
					<br/><button href="javascript:ajax();" id="startbutton" name="photo" value="ok">Prendre une photo</button>
					<br/><canvas id="canvas"></canvas>
				</div>
			</div>
			<script src="../js/cam.js"></script>
			<div id="login" class="shadow">
				<div class="form">
					<form class="connexion" action="register.php" method="post" target="_self">
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
					<form class="connexion" action="register.php" method="post" target="_self">
						<h3>code</h3>
						<div>
							<label>Mon code</label>
							<input type="text" placeholder="Entrez identifiant" name="login" required>
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
