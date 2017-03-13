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
					<div class="photo_bouton">
						<img src="../img/1.png">
						<br/><button id="img1">Utiliser</button>
					</div>
					<div class="photo_bouton">
						<img src="../img/arbre.png">
						<br/><button id="img2">Utiliser</button>
					</div>
					<div class="photo_bouton">
						<img src="../img/lune.png">
						<br/><button id="img3">Utiliser</button>
					</div>
					<div class="photo_bouton">
						<img src="../img/biere.png">
						<br/><button id="img4">Utiliser</button>
					</div>
				</div>
				<div class="cametphoto">
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
						while ($res[--$i]['img'] && $j++ < 4)
							echo '<img src="'.$res[$i]['img'].'">';
					?>
					</div>
					<!-- s'il y a une camera -->
					<div id="container" class="container">
						<div id="wrong">
						</div>
						<div class="cheat">
							<img id="superpose">
							<video  autoplay ></video>
						</div>
						<div class="valide_photo">
							<canvas id="canvas"></canvas>
							<br/><button id="startbutton" name="photo" value="ok">Prendre une photo</button>
							<br><img id="photo">
							<br><button id="valide" >Valider</button>
						</div>
					</div>
					<!-- s'il n'y a pas de camera -->
					<div id="pas_de_cam">
						<div id="wrong2"></div>
						<div class="cheat2">
							<?php
								if ($_GET['fichier'])
								{
									$file = $_GET['fichier'];
									echo '<img id="photo_up" src="../upload/'.$file.'">';
									chmod('../upload/'.$file, 0755); 
								}
								else
									echo '<img id="photo_up">';
							?>
							<img id="superpose2">
						</div>
						<div class="valide_photo2">
							<canvas id="canvas2"></canvas>
							<br/><button id="startbutton2" name="photo" value="ok">Prendre une photo</button>
							<br><button id="upload_photo">Telecharger une image</button>
							<br><img id="photo2">
							<br><button id="valide2" >Valider</button>
						</div>
						<div id="up_form" class="shadow">
							<div class="form">
								<form method="POST" action="upload.php" enctype="multipart/form-data" class="up_form" name="form_nocam">	
									<h3>telecharger une image</h3>
							  		<input type="file" name="up_photo">
							   		<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
							   		<button type="submit" id="send_photo" name="envoyer">Envoyer l'image</button>
							   		<a href="" class="quit">Fermer</a>
								</form> 
							</div>
						</div>
					</div>
				</div>
				<script src="../js/no_cam.js"></script>
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
