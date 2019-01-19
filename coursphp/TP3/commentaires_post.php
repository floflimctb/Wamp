<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e) { 
    die('Erreur : ' . $e->getMessage()); 
}

$req = $bdd->prepare('INSERT INTO commentaires(id_billet, auteur, commentaire, date_commentaire) VALUES(:id_billet, :auteur, :commentaire, DATE_FORMAT(NOW(), \' le %d/%m/%Y à %Hh%imin%ss\'))');
$req->execute(array(
    'id_billet' => $_GET['billet'],
    'auteur' => htmlspecialchars($_POST['auteur']),
    'commentaire' => htmlspecialchars($_POST['commentaire'])));

header('Location: minichat.php');

?>