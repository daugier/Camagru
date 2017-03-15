<?php 
session_start();
$url = $_SERVER[REQUEST_URI];
?>
<html>
	<head>
		<meta charset="UTF-8" http-equiv="refresh" content="600" />
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
					<li><a href="#">Galerie</a></li>
				</ul>
			</div>
			<?php
				if ($_SESSION['valid'] == 1)
					echo '<div id="connec_ok">inscription enregistrer !<br> Allez voir vos mails pour confirmer l\'inscription</div>';
				if ($_SESSION['valid'] == 2)
					echo '<div id="connec_ok">connexion reussi !</div>';
				$_SESSION['valid'] = 0;
			?>
			<div class="galerie" id="galerie">
				<div id="need_connect"></div>
				<?php
					include '../function/image.php';
					include '../function/user.php';

					$id = $_SESSION['logged_on_user'];
					$user = get_user_by_id($id);
					$res = list_image();
					$pdf = 0;
					$i = 0;
					if ($res)
					{
						while ($res[$i]['img'])
							$i++;
						$nbr = 0;
						while ($res[--$i]['img'] && ++$nbr)
						{
							$img = $res[$i]['img'];
							$likes = get_likes_by_img($img);
							$user_likes = get_user_likes_by_img($img);
							$id = get_id_img_by_img($img);
							$user_img = get_user_by_img($img);
							if ($nbr > 2)
							{
								$pdf = 1;
								echo '<div class="shadow" id="ensemble_photo'.$i.'">';
							}
							else
								echo '<div class="ensemble_photo" id="ensemble_photo'.$i.'">';
							$date['img_date'] = get_date_by_img($img);
							echo '<p>'.$date['img_date'][0].'</p>';
							if ($user == $user_img)
							{
								echo '<button type="submit" onclick="sub_img(\''.$img.'\', '.$i.')">supprimer</button>';
							}
									echo '<br><img src="'.$img.'">
									<br/>
									<div class="commentaire">
									
									<input class="like" type="submit" onclick="add_like('.$id.', '.$i.',\' '.$user.'\', \' '.$user_likes.'\', '.$likes.' )" value="j\'aime"/>
										<input class="dislike" type="submit" onclick="sub_like('.$id.', '.$i.', \' '.$user.'\', \' '.$user_likes.'\', '.$likes.' )" value="j\'aime plus"/>
										<div id="like'.$i.'">'.$likes.' likes</div>
										<textarea maxlength="45" type="text" id="texte'.$i.'" name="texte"></textarea>
										<br><input type="submit" onclick="add_comment('.$i.',\''.$user.'\')" id="add_comment" value="commenter"/>
										<input style="display:none;" id="user'.$i.'" value="'.$user.'"/>
										<input style="display:none;" id="img'.$i.'" value="'.$img.'"/>
										<div id="comment'.$i.'" >';
							$j = -1;
							$com = get_comment_by_img($img);
							$nbr_com = 6;
							if ($com)
							{
								$comment = $com['comment'];
								preg_match_all("/user=(.*?)&/", $comment, $person);
								preg_match_all("/text=(.*?)\/\//", $comment, $text);
								while ($person[1][++$j] && $j < $nbr_com)
								{
									echo '<div class="comentaire_photo" id="comentaire_photo'.$i.'"><b>'.$person[1][$j].' :</b> ',$text[1][$j].'</div>';
								}
								if ($person[1][$j])
								{
									echo '<input style="display:none;" id="user_com'.$i.'" value=""/>
										<input style="display:none;" id="text_com'.$i.'" value=""/>';
									?>
									<script>
										var i = <?php echo json_encode($i);?>;
										var text = <?php echo json_encode($text[1]);?>;
										document.getElementById('text_com'+i).value = text;
										var user = <?php echo json_encode($person[1]);?>;
										document.getElementById('user_com'+i).value = user;
									</script>
									<?php
									echo '<div class="comentaire_photo" id="comentaire_photo_plus'.$i.'"><a onclick="plus_de_com('.$i.',\' '.$img.'\')">plus de commentaires</a></div>';

								}
							}
							echo '			</div></div>
									</div>
								</div>';
						}
						if ($pdf == 1)
						{
							echo '<a id="plus_de_photos" onclick="plus_de_photos(\' '.$img.'\')">Plus de photos</a>';
						}
					}
				?>
			</div>
			<script src="../js/commentary.js"></script>

			<div id="login" class="shadow">
				<div class="form">
					<form class="connexion" action="login.php" method="post" target="_self">
						<h3>Connexion</h3>
						<div>
							<?php
								if ($_SESSION['error'] == 5)
									echo '<label id="wrong_login">Mauvais mot de passe ou identifiant</label><br>';
							?>
							<label>Identidiant</label>
							<input type="text" placeholder="Entrez identifiant" name="user" required>
							<label>Mot de passe</label>
							<input type="password" placeholder="Entrez mot de passe" name="password" required>
							<button class="btn" type="submit" value="OK">Go</button>
							<a href="#code">Mot de passe oublie ?</a>
              				<a href="galerie.php" class="quit">Fermer</a>
              				<?php
              				echo '<input style="display:none;" name="url" value="'.$url.'"/>';
              				?>
						</div>
					</form>
				</div>
			</div>
			<div id="register" class="shadow">
				<div class="form">
					<form class="Inscription" action="register.php" method="post" target="_self">
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
							$_SESSION['error'] = 0;
						?>
							<label>Adresse Mail</label>
							<input type="text" placeholder="Entrez votre mail" name="mail" required>
							<label>Identidiant</label>
							<input type="text" placeholder="Entrez identifiant" name="user" required>
							<label>Mot de passe</label>
							<input type="password" placeholder="Entrez mot de passe" name="password" required>
							<button class="btn" type="submit" value="OK">Go</button>
              				<a href="galerie.php" class="quit">Fermer</a>
              				<?php
              				echo '<input style="display:none;" name="url" value="'.$url.'"/>';
              				?>
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
              				<a href="galerie.php" class="quit">Fermer</a>
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