<!doctype html>

<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
		<title>Titre</title>
	</head>

	<body>
		<p>Salut</p>
	</body>
</html>

<?php

ERREURS :
Parse error: parse error in fichier.php on line 15 //Instruction php mal formée : point virgule manquant, oubli de fermer un guillemet, oubli dans la concoctenation (point pour separer les éléments dans echo), accolade mal fermée
Fatal Error: Call to undefined function: fonction_inconnue() in fichier.php on line 27 //Fonction inconnue
Warning: Wrong parameter count for fonction() in fichier.php on line 112 //Oubli ou rajout de paramètres pour une fonction
Cannot modify header information - headers already sent by ... //Headers à mettre avant quoi que ce soit d'autre
Fatal error: Maximum execution time exceeded in fichier.php on line 57 //Boucle infinie

echo 'Bonjour ' . $_GET['prenom'] . ' ' . $_GET['nom'] . ' !'; //affiche la variable mise en parametre dans la balise a au prealable
if (isset($_GET['prenom']) AND isset($_GET['nom'])) //Fonction isset() teste si une variable existe
$_GET['repeter'] = (int) $_GET['repeter']; //Transtypage : lire de droite à gauche : tout ce qui est envoyé à repeter ressort forcément en int
echo htmlspecialchars($_POST['prenom']); //Fonction htmlspecialchars : provoque l'affichage de la balise plutot que de l'affichage et empêche l'injection html
echo strip_tags($_POST['prenom']); //Idem mais au lieu d'afficher les balises il cache le code html tenté d'envoyer
move_uploaded_file //FOnction permettant d'accepter un fichier envoyé par formulaire
    
?>