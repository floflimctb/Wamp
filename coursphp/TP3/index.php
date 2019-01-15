<!doctype html>

<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
		<title>Mon super blog !</title>
	</head>

	<body>
		<h1>Mon super blog !</h1>

		<p>Derniers billets du blog : </p>

		<?php

		try {
			$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch (Exception $e) { 
			die('Erreur : ' . $e->getMessage()); 
		}

		$reponses = $bdd->query('SELECT titre, contenu, DATE_FORMAT(date_creation, ' le %d/%m/%Y à %Hh%imin%ss') FROM billets ORDER BY date_creation DESC LIMIT 0, 2');

		while ($donnees = $reponses->fetch()) { 
			?><p class="news">
				<h3>
					<?php echo $donnees['titre'] . '<i>' . $donnees['date_creation'] . '</i>'; ?>
				</h3>

				<?php echo $donnees['contenu']; ?>

				<a href="commentaires.php">Commentaires</a>
			</p><?php
		}

		$reponses->closeCursor();

		?>
	</body>
</html>