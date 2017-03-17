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
			<div class="menu" draggable="false">
				<ul>
					<li><a  draggable="false" href="../index.php">Accueil</a></li>
					<?php
						if ($_SESSION["logged_on_user"])
						{
							echo '<li><a  draggable="false" href="disconnect.php">Deconnexion</a></li>';
							echo '<li><a  draggable="false" href="">Photomaton</a></li>';
						}
						else
						{
							echo '<li><a  draggable="false" href="#login">Connexion</a></li>';
							echo '<li><a  draggable="false" href="#register">Inscription</a></li>';
						}
					?>
					<li><a  draggable="false" href="galerie.php">Galerie</a></li>
				</ul>
			</div>
			<div class="all">
				<div class="image_montage">
					<div class="photo_bouton">
						<img src="../img/lapin.png" id="../img/lapin.png" draggable="true" ondragstart="drag(event)">
					</div>
					<div class="photo_bouton">
						<img src="../img/pomme.png" id="../img/pomme.png" draggable="true" ondragstart="drag(event)">
					</div>
					<div class="photo_bouton">
						<img src="../img/chat.png" id="../img/chat.png" draggable="true" ondragstart="drag(event)">
					</div>
					<div class="photo_bouton">
						<img src="../img/singe.png" id="../img/singe.png" draggable="true" ondragstart="drag(event)">
					</div>
					<div class="photo_bouton">
						<img src="../img/soleil.png" id="../img/soleil.png" draggable="true" ondragstart="drag(event)">
					</div>
					<div class="photo_bouton" >
						<img src="../img/kangourou.png" id="../img/kangourou.png" draggable="true" ondragstart="drag(event)">
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
						while ($res[--$i]['img'])
							echo '<img draggable="false" src="'.$res[$i]['img'].'">';
					?>
					</div>
					<!-- s'il y a une camera -->
					<div id="container" class="container">
						<div id="wrong">
						</div>
						<div class="cheat" id='cheat' ondrop="drop(event)" ondragover="allowDrop(event)">
							<div id="superpose">
								<img id="sup_img" class="sup_img_cur" draggable="true" ondragstart="drag(event)">
							</div>
							<video  autoplay ></video>
						</div>
						<div class="valide_photo">
							<canvas id="canvas"></canvas>
							<br/><button id="startbutton" name="photo" value="ok">Prendre une photo</button>
							<br><img id="photo">
							<br><button id="valide" >Publier</button>
						</div>
					</div>
					<!-- s'il n'y a pas de camera -->
					<div id="pas_de_cam">
						<div id="wrong2"></div>
						<div class="cheat2" id="cheat2" ondrop="drop2(event)" ondragover="allowDrop2(event)">
							<div id="superpose">
								<img class="sup_img_cur" id="sup_img_2"  draggable="true" ondragstart="drag2(event)">
							</div>
							<?php
								if ($_GET['fichier'])
								{
									$file = $_GET['fichier'];
									if (file_exists('../upload/'.$file))
									{
										echo '<img id="photo_up" src="../upload/'.$file.'">';
										chmod('../upload/'.$file, 0755);
									}
									else 
									echo '<img id="photo_up" alt="votre photo">';
								}
								else
									echo '<img id="photo_up" alt="votre photo">';
							?>
						</div>
						<div class="valide_photo2">
							<canvas id="canvas2"></canvas>
							<br/><button id="startbutton2" name="photo" value="ok">Prendre une photo</button>
							<button id="upload_photo">Telecharger une image</button>
							<br><img id="photo2">
							<br><button id="valide2" >Publier</button>
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
