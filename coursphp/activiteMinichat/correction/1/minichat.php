<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>minichat</title>
</head>
<body>
	<header>
		<form action="minichat_post.php" method="post">
			<label>Pseudo : <input type="text" name="pseudo"
				<?php 
					if (isset($_COOKIE['pseudo'])) {
						?>
						value="<?php echo($_COOKIE['pseudo']); ?>"
						<?php
					}
				?>
				></label><br>
			<label>Message : <input type="text" name="message"></label>
			<input type="submit" value="Envoyer">
		</form>
	</header>

	<?php 
		include("db_connect.php");

		$req = $bdd->query('
			SELECT pseudo,message,DATE_FORMAT(date_comment, "%d/%m/%Y à %Hh%imin%ss") AS date_time FROM chat');

		while ($donnees = $req->fetch()) {
			?>
			<p>
				<?php
				echo $donnees['pseudo'] . ' le ' . $donnees['date_time'] . ' : ' . $donnees['message'];
				?>
			</p>
			<?php
		}
	?>
</body>
</html>