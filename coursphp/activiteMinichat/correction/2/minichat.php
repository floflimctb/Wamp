<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mini Chat</title>
	<style type="text/css">
		form{
			text-align: center;
		}
	</style>
</head>
<body>

	<form method="POST" action="minichat_post.php">
		<p>
			<label for="pseudo">Pseudo
				<input type="text" name="pseudo">
			</label>
		</p>
		<p>
			<label for="message">Message
				<input type="text" name="message">
			</label>
		</p>
		<p>
			<label for="envoyer">
				<input type="submit" value="Envoyer">
			</label>
		</p>

	</form>

	<?php 

	try {
		$bdd = new PDO('mysql:host=localhost;dbname=minichat', 'root', '');
	} catch (Exception $e) {
		die('Erreur'. $e->getMessage());
	}

	$requete = $bdd->query('SELECT pseudo, message, DATE_FORMAT(date_creation,"%d/%m/%Y %H:%i:%s") AS date FROM minichat ORDER BY id DESC');
	while ($resultat = $requete->fetch()) {
		echo "<p>[".$resultat['date']."]<strong>"." ".htmlspecialchars($resultat['pseudo']). "</strong> : ". htmlspecialchars($resultat['message']) . "</p>";
	}

	$requete->closeCursor();
	 ?>

</body>
</html>