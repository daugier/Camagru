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
			<div class="galerie" id="galerie" href="javascript:ajax();">
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
							echo '<div class="ensemble_photo">
									<img src="'.$res[$i]['img'].'">
									<br/>
									<button class="like" type="submit" value="like">like</button>
									<div class="commentaire">
										<textarea type="text" id="texte" name="texte"></textarea>
										<input type="submit" id="comment" name="comment" />
										<input style="display:none;" id="user" value="'.$user.'"/>
										<input style="display:none;" id="img" value="'.$res[$i]['img'].'"/>
										<div id="new_comment">
										</div>
									</div>
								</div>';
						}
					}
				?>
			<script src="../js/commentary.js"></script>
			</div>
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