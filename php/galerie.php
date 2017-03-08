<?php session_start()?>
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
				<?php
					require 'connect_db.php';

					$id = $_SESSION['logged_on_user'];
					$query= $db->prepare('SELECT user FROM user WHERE id=:id');
					$query->execute(array(':id' => $id));
					if ($res = $query->fetch())
						$user = $res['user'];
					$query= $db->prepare('SELECT img FROM image');
					$query->execute();
					$res = $query->fetchall();
					$i = 0;
					if ($res)
					{
						while ($res[$i]['img'])
							$i++;
						while ($res[--$i]['img'])
						{
							$query= $db->prepare('SELECT likes FROM image WHERE img=:img');
							$query->execute(array(':img' => $res[$i]['img']));
							$likes = $query->fetch();
							$likes = $likes['likes'];
							$img = $res[$i]['img'];
							$query= $db->prepare('SELECT user_likes FROM image WHERE img=:img');
							$query->execute(array(':img' => $img));
							$user_likes = $query->fetch();
							$user_likes = $user_likes['user_likes'];
							$query= $db->prepare('SELECT id FROM image WHERE img=:img');
							$query->execute(array(':img' => $img));
							$id = $query->fetch();
							$id = $id['id'];
							echo '<div class="ensemble_photo"  href="javascript:ajax();">
									<img src="'.$img.'">
									<br/>
									<div class="commentaire">
										<input class="like" type="submit" onclick="add_like('.$id.', '.$i.',\' '.$user.'\', \' '.$user_likes.'\' )" value="like"/>
										<input class="dislike" type="submit" onclick="sub_like('.$id.', '.$i.', \' '.$user.'\', \' '.$user_likes.'\' )" value="dislike"/>
										<div id="like'.$i.'">'.$likes.'</div>
										<textarea type="text" id="texte'.$i.'" name="texte"></textarea>
										<input type="submit" onclick="add_comment('.$i.')"/>
										<input style="display:none;" id="user'.$i.'" value="'.$user.'"/>
										<input style="display:none;" id="img'.$i.'" value="'.$img.'"/>
										<div id="comment'.$i.'" >';
							$query= $db->prepare('SELECT comment FROM image WHERE img=:img');
							$query->execute(array('img' => $img));
							$j = -1;
							if ($com = $query->fetch())
							{
								$comment = $com['comment'];
								preg_match_all("/user=(.*?)&/", $comment, $person);
								preg_match_all("/text=(.*?)\/\//", $comment, $text);
								while ($person[1][++$j] && $j < 2)
								{
									echo '<div>'.$person[1][$j].' : ',$text[1][$j].'</div>';
								}
							}
							echo '			</div>
									</div>
								</div>';
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
							<label>Identidiant</label>
							<input type="text" placeholder="Entrez identifiant" name="login" required>
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