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
						$tmp = $i;
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
							
							if ($user == $user_img)
							{
								echo '<div class="button_supimg"><button type="submit" onclick="sub_img(\''.$img.'\', '.$i.')">X</button></div>';
							}
							$date['img_date'] = get_date_by_img($img);
							echo $date['img_date'][0];
									echo '<br><img src="'.$img.'">
									<br/>
									<div class="commentaire"><br>';
									if (!strpos($user_likes, $user))
									{
										echo '<input id="likee'.$i.'" class="like" type="submit" onclick="add_like('.$id.', '.$i.',\' '.$user.'\', \' '.$user_likes.'\')" value="j\'aime"/>';
									}
									else
									{
										echo '<input id="dislikee'.$i.'" class="dislike" type="submit" onclick="sub_like('.$id.', '.$i.', \''.$user.'\', \''.$user_likes.'\')" value="j\'aime plus"/>';
									}
									echo '<br><div id="like'.$i.'">'.$likes.' likes</div>
										<input class="text_write" type="text" id="texte'.$i.'" name="texte"/>
										<br><input class="commenter" type="submit" onclick="add_comment('.$i.',\''.$user.'\')" id="add_comment" value="commenter"/>
										<input style="display:none;" id="user'.$i.'" value="'.$user.'"/>
										<input style="display:none;" id="img'.$i.'" value="'.$img.'"/>
										<input style="display:none;" id="id_img'.$i.'" value="'.$id.'"/>
										<div id="comment'.$i.'" >';
							$j = -1;
							$com = get_comment_by_img($img);
							$nbr_com = 6;
							if ($com)
							{
								$comment = $com['comment'];
								preg_match_all("/user=(.*?)&/", $comment, $person);
								preg_match_all("/text=(.*?)&/", $comment, $text);
								preg_match_all("/uniq=(.*?)\/\//", $comment, $uniq);
								while ($person[1][++$j])
								{
									if ($j > 5)
									{
										echo '<div class="shadow" id="comentaire_photo'.$i.$j.'">';
										if ($user == $person[1][$j])
											echo '<button type="submit"  onclick="sub_commentaire('.$i.','.$j.',\''.$uniq[1][$j].'\',\' '.$person[1][$j].'\',\' '.$text[1][$j].'\', '.$id.')">X</button>';
										echo '<b>'.$person[1][$j].' :</b> '.$text[1][$j].'</div>';
									}
									else
									{
										echo '<div class="comentaire_photo" id="comentaire_photo'.$i.$j.'">';
										if ($user == $person[1][$j])
											echo '<button type="submit" onclick="sub_commentaire('.$i.','.$j.',\' '.$uniq[1][$j].'\',\' '.$person[1][$j].'\',\' '.$text[1][$j].'\', '.$id.')">X</button>';
										echo '<b>'.$person[1][$j].' :</b> '.$text[1][$j].'</div>';
									}
								}
								if ($j > 5)
								{
									echo '<div class="comentaire_photo_2" id="comentaire_photo_plus'.$i.'"><a onclick="plus_de_com('.$i.','.$j.')">plus de commentaires</a></div>';
								}
							}
							echo '			</div></div>
									<br></div>
								</div>';
						}
						if ($pdf == 1)
						{
							echo '<a class="pdp" id="plus_de_photos" onclick="plus_de_photos('.$tmp.')">Plus de photos</a>';
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
							<br><br><button class="btn" type="submit" value="OK">Me connecter</button>
							<br><br><a href="#code">Mot de passe oublie ?</a>
							<br><a href="galerie.php" class="quit" align="right">Fermer</a>
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
							<br><br><label>Mot de passe</label>
							<input type="password" placeholder="Entrez mot de passe" name="password" required>
							<br><button class="btn" type="submit" value="OK">m'inscrire</button>
              				<br><a href="galerie.php" class="quit">Fermer</a>
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