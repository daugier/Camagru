<?php 
session_start();
$url = $_SERVER[REQUEST_URI];
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
					<li><a href="#">Galerie</a></li>
				</ul>
			</div>
			<div class="galerie" id="galerie">
				<div id="need_connect"></div>
				<?php
					include '../function/image.php';
					include '../function/user.php';

					$id = $_SESSION['logged_on_user'];
					$user = get_user_by_id($id);
					$res = list_image();
					$i = 0;
					if ($res)
					{
						while ($res[$i]['img'])
							$i++;
						$total = $i;
						$messagesParPage = 3;
						$nombreDePages = ceil($total / $messagesParPage);
						if(isset($_GET['page']))
						{
						     $pageActuelle = intval($_GET['page']);
						 
						     if($pageActuelle > $nombreDePages)
						     {
						          $pageActuelle = $nombreDePages;
						     }
						}
						else
						{
						     $pageActuelle = 1; 
						}
						$premiereEntree = ($pageActuelle - 1) * $messagesParPage;
						$nbr = 0;
						if ($_GET['i'])
						{
							$i = $_GET['i'];
							if ($i > $total - 1 || $i < 0)
								$i = $total;
						}
						echo '<p id="page" align="center">Page : ';
						for($l=1; $l<=$nombreDePages; $l++)
						{
						     if($l == $pageActuelle)
						         echo ' [ '.$l.' ] '; 
						     else
						     {
						    	$tmp_i = $total - (3 * ($l - 1));
						        echo ' <a href="galerie.php?page='.$l.'&i='.($tmp_i).'">'.$l.'</a> ';
						     }
						}
						echo '</p>';
						while ($res[--$i]['img'] && $nbr++ < $messagesParPage)
						{
							$img = $res[$i]['img'];
							$likes = get_likes_by_img($img);
							$user_likes = get_user_likes_by_img($img);
							$id = get_id_img_by_img($img);
							$user_img = get_user_by_img($img);
							echo '<div class="ensemble_photo" id="ensemble_photo'.$i.'">';
							if ($user == $user_img)
							{
								echo '<button type="submit" onclick="sub_img(\''.$img.'\', '.$i.')">supprimer</button>';
							}
									echo '<br><img src="'.$img.'">
									<br/>
									<div class="commentaire">
									
									<input class="like" type="submit" onclick="add_like('.$id.', '.$i.',\' '.$user.'\', \' '.$user_likes.'\' )" value="like"/>
										<input class="dislike" type="submit" onclick="sub_like('.$id.', '.$i.', \' '.$user.'\', \' '.$user_likes.'\' )" value="dislike"/>
										<div id="like'.$i.'">'.$likes.'</div>
										<textarea maxlength="45" type="text" id="texte'.$i.'" name="texte"></textarea>
										<br><input type="submit" onclick="add_comment('.$i.',\''.$user.'\')" id="add_comment"/>
										<input style="display:none;" id="user'.$i.'" value="'.$user.'"/>
										<input style="display:none;" id="img'.$i.'" value="'.$img.'"/>
										<div id="comment'.$i.'" >';
							$j = -1;
							$com = get_comment_by_img($img);
							if ($com)
							{
								$comment = $com['comment'];
								preg_match_all("/user=(.*?)&/", $comment, $person);
								preg_match_all("/text=(.*?)\/\//", $comment, $text);
								while ($person[1][++$j] && $j < 6)
								{
									echo '<div id="comentaire_photo">'.$person[1][$j].' : ',$text[1][$j].'</div>';
								}
							}
							echo '			</div>
									</div>
								</div>';
						}
						echo '<p id="page" align="center">Page : ';
						for($l = 1; $l<= $nombreDePages; $l++)
						{
						     if($l == $pageActuelle)
						         echo ' [ '.$l.' ] '; 
						     else
						     {
						    	$tmp_i = $total - (3 * ($l - 1));
						        echo ' <a href="galerie.php?page='.$l.'&i='.($tmp_i).'">'.$l.'</a> ';
						     }
						}
						echo '</p>';
					}
				?>
			</div>
			<script src="../js/commentary.js"></script>
			<div id="login" class="shadow">
				<div class="form">
					<form class="connexion" action="login.php" method="post" target="_self">
						<h3>Connexion</h3>
						<div>
							<label>Identidiant</label>
							<input type="text" placeholder="Entrez identifiant" name="user" required>
							<label>Mot de passe</label>
							<input type="password" placeholder="Entrez mot de passe" name="password" required>
							<button class="btn" type="submit" value="OK">Go</button>
							<a href="#code">Mot de passe oublie ?</a>
              				<a href="#" class="quit">Fermer</a>
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
							<label>Adresse Mail</label>
							<input type="text" placeholder="Entrez votre mail" name="mail" required>
							<label>Identidiant</label>
							<input type="text" placeholder="Entrez identifiant" name="user" required>
							<label>Mot de passe</label>
							<input type="password" placeholder="Entrez mot de passe" name="password" required>
							<button class="btn" type="submit" value="OK">Go</button>
              				<a href="#" class="quit">Fermer</a>
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
              				<a href="#" class="quit">Fermer</a>
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