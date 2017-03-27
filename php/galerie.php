<?php 
session_start();
$url = $_SERVER[REQUEST_URI];
$url_2 = explode('/', $_SERVER[REQUEST_URI]);
$_SESSION['url'] = 'http://localhost:8080/'.$url_2[1];
$t_url = $url_2[3].$url_2[4];
if (!file_exists($t_url))
{
	header('location:'.$_SESSION['url']);
}
?>
<html>
	<head>
		<meta charset="UTF-8" http-equiv="refresh" content="600" />
		<title>Camagru</title>
			<link href="https://fonts.googleapis.com/css?family=Cinzel" rel="stylesheet">
			<link type="text/css" href="../css/main.css" media="all" rel="stylesheet"/>
	</head>
	<body onload="setTimeout(cacherDiv,2000);">
	<script>
	function cacherDiv()
	{
		if(document.getElementById("connec_ok"))
    		document.getElementById("connec_ok").style.visibility = "hidden";
	}
	</script>
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
					<li><a id="on" href="#">Galerie</a></li>
				</ul>
				<p><i><?php 
					$user = $_SESSION['user'];
					if ($user)
						echo '<a href="moncompte.php">user : '.$user.'</a>';
				?></i></p>
			</div>
			<?php
				if ($_SESSION['valid'] == 1)
					echo '<div id="connec_ok">inscription enregistrer !<br> Allez voir vos mails pour confirmer l\'inscription</div>';
				if ($_SESSION['valid'] == 2)
					echo '<div id="connec_ok">connexion reussi !</div>';
				$_SESSION['valid'] = 0;
			?>
			<div class="galerie" id="galerie">
				<div id="need_connect"></div><br>
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

						while ($res[--$i]['img'] && ++$nbr && $i >= 0)
						{
							$img = $res[$i]['img'];
							$likes = get_likes_by_img($img);
							$user_likes = get_user_likes_by_img($img);
							$user_img = get_user_by_img($img);
							$id_img = get_id_img_by_img($img);
							if ($nbr > 2)
							{
								$pdf = 1;
								echo '<div class="shadow" id="ensemble_photo">';
							}
							else
								echo '<div class="ensemble_photo" id="ensemble_photo">';
							if ($user == 'root')
							{
								echo '<div class="button_supimg"><button type="submit" onclick="sub_img(this)">X</button></div>';
							}
							$date['img_date'] = get_date_by_img($img);
							echo '<div class=date>publie par <b>'.$user_img.'</b> le '.$date['img_date'][0].'</div>';
									echo '<img src="'.$img.'">
									<br/>
									<div class="commentaire"><br>';
									if (!strpos($user_likes, $user))
									{
										echo '<input id="likee" class="like" type="submit" onclick="add_like(this)" value="j\'aime"/>';
									}
									else
									{
										echo '<input id="dislikee" class="dislike" type="submit" onclick="sub_like(this)" value="j\'aime plus"/>';
									}
									echo '<br><div id="like">'.$likes.' Likes</div>
										<input class="text_write" type="text" id="texte" name="texte" onKeyPress="if(event.keyCode == 13) add_comment(this)";"/>
										<div id="comment" >';
							$j = 0;
							$nbr_com = 0;
							$comment = get_comment_by_id_img($id_img);
							if ($comment)
							{
								while ($comment[$j])
									$j++;
								while ($comment[--$j] && ++$nbr_com)
								{
									if ($nbr_com > 5)
									{
										echo '<div class="shadow" id="comentaire_photo">';
										if ($user == $comment[$j]['user'] || $user == 'root')
										{
											echo '<button id="'.$comment[$j]['id'].'" type="submit"  onclick="sub_commentaire(this)">X</button>';
										}
										echo '<b>'.$comment[$j]['user'].' :</b> '.$comment[$j]['comments'].'</div>';
									}
									else
									{
										echo '<div class="comentaire_photo" id="comentaire_photo">';
										if ($user == $comment[$j]['user'] || $user == 'root')
											echo '<button id="'.$comment[$j]['id'].'" type="submit" onclick="sub_commentaire(this)">X</button>';
										echo '<b>'.$comment[$j]['user'].' :</b> '.$comment[$j]['comments'].'</div>';
									}
								}
								if ($nbr_com > 5)
								{
									echo '<div class="comentaire_photo_2" ><a id="'.$i.'" onclick="plus_de_com(this)">plus de commentaires</a></div>';
								}
							}
							echo '			</div></div>
									<br></div>';
						}
						if ($pdf == 1)
						{
							echo '<a class="pdp" id="plus_de_photos" onclick="plus_de_photos(this)">Plus de photos</a>';
						}
					}
					else
						echo '<div class="no_public" >Aucune photo publiee pour le moment</div>';
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
							<label>Identidiant :&nbsp;</label>
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
			<div id="register" class="shadow">
				<div class="form">
					<form class="Inscription" action="register.php" method="post" target="_self">
						<h3>Inscription</h3>
						<div>
						<?php
							if ($_SESSION['error'] == 1)
								echo '<label id="wrong_login">Mot de passe trop court, 6 caracteres minimum</label><br>';
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
							<br><label>Identidiant : &nbsp;</label>
							<input type="text" placeholder="Entrez identifiant" name="user" required>
							<br><label>Mot de passe :&nbsp;</label>
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
							<label>Adresse Mail : </label>
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