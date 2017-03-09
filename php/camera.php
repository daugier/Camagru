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
					<br/><button id="img1">Utiliser</button>
					<br/><img src="../img/arbre.png">
					<br/><button id="img2">Utiliser</button>
					<br/><img src="../img/lune.png">
					<br/><button id="img3">Utiliser</button>
					<br/><img src="../img/biere.png">
					<br/><button id="img4">Utiliser</button>
					<br/><img src="../img/fuck.png" id="imgg">
					<br/><button id="img5">Utiliser</button>
				</div>
				<div class="montage" id="placehere">
				<?php 
					require 'connect_db.php';

					$id = $_SESSION['logged_on_user'];
					$query= $db->prepare('SELECT user FROM user WHERE id=:id');
					$query->execute(array(':id' => $id));
					if ($res = $query->fetch())
						$user = $res['user'];
					$query= $db->prepare('SELECT img FROM image WHERE user=:user');
					$query->execute(array(':user' => $user));
					$res = $query->fetchall();
					$i = 0;
					while ($res[$i]['img'])
					{
						$i++;
					}
					$j = 0;
					while ($res[--$i]['img'] && $j++ < 10)
						echo '<img src="'.$res[$i]['img'].'">';
				?>
				</div>
				<div id="container" class="container">
					<div id="wrong">
					</div>
					<div class="cheat">
						<img id="superpose">
						<video  autoplay ></video>
					</div>
					<div classe="valide_photo">
						<br><br><br><br/><canvas id="canvas"></canvas>
						<br/><button href="javascript:ajax();" id="startbutton" name="photo" value="ok">Prendre une photo</button>
						<br><img id="photo" alt="photo">
						<br><button id="valide" >Valider</button>
						<button id="annule" >Supprimer</button>
					</div>
				</div>
				<script src="../js/cam.js"></script>
			</div>
			<div id="login" class="shadow">
				<div class="form">
					<form class="connexion" action="register.php" method="post" target="_self">
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
					<form class="Inscription" action="register.php" method="post" target="_self">
						<h3>Inscription</h3>
						<div>
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
