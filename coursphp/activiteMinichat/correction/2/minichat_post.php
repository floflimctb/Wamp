<?php 

try {
		$bdd = new PDO('mysql:host=localhost;dbname=minichat', 'root', '');
	} catch (Exception $e) {
		die('Erreur'. $e->getMessage());
	}




if (isset($_POST['pseudo'], $_POST['message'])) {
	$pseudo = htmlentities($_POST['pseudo']);
	$message = htmlentities($_POST['message']);
	setcookie('pseudo', $pseudo, time() + 365*24*3600);

	$requete = $bdd->prepare('INSERT INTO minichat (pseudo, message,date_creation) VALUES (?,?, NOW())');
	$requete->execute(array($pseudo, $message));



}else{
	echo "Veuillez Renseigner un pseudo et/ou un Message" ;
}

header('Location: minichat.php');

?>
