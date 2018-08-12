<?php

// Effectuer ici la requête qui insère le message
// Puis rediriger vers minichat.php comme ceci :

try { 
	$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) { 
	die('Erreur : ' . $e->getMessage()); 
}

$req = $bdd->prepare('INSERT INTO minichat(pseudo, message) VALUES(:pseudo, :message)');
$req->execute(array(
	'pseudo' => $_POST['pseudo'],
	'message' => $_POST['message']));

$reponse = $bdd->query('SELECT * FROM minichat');

while ($donnees = $reponse->fetch()) {
	?>
	    <p>
		    <strong>Pseudo</strong> : <?php echo $donnees['pseudo']; ?><br />
		    <?php echo $donnees['message']; ?>
	   	</p>
	<?php
}

header('Location: minichat.php');

?>