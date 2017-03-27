<?php
	session_start(); 

	if (!$_SESSION['logged_on_user'])
		header('location:../index.php');
	$url = $_SERVER[REQUEST_URI];
	$url_2 = explode('/', $_SERVER[REQUEST_URI]);
	$t_url = $url_2[3].$url_2[4];
	if (!file_exists($t_url))
	{
		header('location:'.$_SESSION['url']);
	}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Camagru</title>
			<link href="https://fonts.googleapis.com/css?family=Cinzel" rel="stylesheet">
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
							echo '<li><a  id="on" draggable="false" href="">Photomaton</a></li>';
						}
						else
						{
							echo '<li><a  draggable="false" href="#login">Connexion</a></li>';
							echo '<li><a  draggable="false" href="#register">Inscription</a></li>';
						}
					?>
					<li><a  draggable="false" href="galerie.php">Galerie</a></li>
				</ul>
				<p><i><?php 
					$user = $_SESSION['user'];
					if ($user)
						echo '<a href="moncompte.php">user : '.$user.'</a>';
				?></i></p>
			</div>
			<div class="all" id="all">
				<div class="image_montage">
				<?php 
					$all_file = scandir('../img');
					$i = 3;
					while ($all_file[$i])
					{
						echo '<div class="photo_bouton">
						<img src="../img/'.$all_file[$i].'" draggable="false" id="../img/'.$all_file[$i].'" onclick="define_source(\'../img/'.$all_file[$i].'\')">
					</div>';
					$i += 3;
					}
				?>
				</div>
				<div class="shadow2" id="radio">
					<br><input type="radio" name="tail" value="100" onclick="get_size('100')">small
					<input type="radio" name="tail" value="150" onclick="get_size('150')">medium
					<input type="radio" name="tail" value="250" onclick="get_size('250')">large
				</div>
				<div class="cametphoto" id="cametphoto">
					<div class="montage" id="placehere">
					<?php 
						include '../function/image.php';
						include '../function/user.php';

						$id = $_SESSION['logged_on_user'];
						$user = get_user_by_id($id);
						$res = get_img_by_user($user);
						$i = 0;
						while ($res[$i]['img'])
						{
							$i++;
						}
						while ($res[--$i]['img'])
						{
							echo '<div class="button_supimg"><button type="submit" onclick="sub_img(this)">X</button>';
							echo '<img draggable="false" src="'.$res[$i]['img'].'"></div>';
						}
					?>
					</div>
					<!-- s'il y a une camera -->
					<div id="container" class="container" style="display:none;">
						<div id="wrong">
						</div>
						<?php
							if (strpos($_SERVER['HTTP_USER_AGENT'], "Android") || strpos($_SERVER['HTTP_USER_AGENT'], "iPod") || strpos($_SERVER['HTTP_USER_AGENT'], "iPhone") )
								echo '<div class="cheat" id="cheat" onmousedown="drop(event)">';
							else
								echo '<div class="cheat" id="cheat" ondrop="drop(event)" ondragover="allowDrop(event)">';
						?>
							<div id="superpose">
								<img id="sup_img" class="sup_img_cur" draggable="true">
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
						<?php
							if (strpos($_SERVER['HTTP_USER_AGENT'], "Android") || strpos($_SERVER['HTTP_USER_AGENT'], "iPod") || strpos($_SERVER['HTTP_USER_AGENT'], "iPhone") )
								echo '<div class="cheat2" id="cheat2" onmousedown="drop2(event)">';
							else
								echo '<div class="cheat2" id="cheat2" ondrop="drop2(event)" ondragover="allowDrop2(event)">';
						?>
							<div id="superpose">
								<img class="sup_img_cur" id="sup_img_2">
							</div>
							<?php
								if ($_SESSION['photo'])
								{
									$file = $_SESSION['photo'];
									$fileData = file_get_contents($file);
									if (file_exists('../upload/'.$file) && $fileData && strlen($fileData) != 0)
									{
										echo '<img id="photo_up" src="../upload/'.$file.'">';
										chmod('../upload/'.$file, 0755);
									}
									else 
									echo '<img id="photo_up" alt="votre photo">';
								}
								else
								{
									echo '<img id="photo_up" alt="votre photo">';
								}
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
			<div id="main">
				<footer>
	                <p>© Copyright daugier 2017</p>
				</footer>
           	</div>
		</center>
	</body>
</html>
