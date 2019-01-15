<?php

// Effectuer ici la requête qui insère le message

try { 
    $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); 
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage()); 
}

if (isset($_POST['pseudo']) AND isset($_POST['message'])) {
    $req = $bdd->prepare('INSERT INTO minichat(pseudo, message) VALUES(:pseudo, :message)');
    $req->execute(array(
        'pseudo' => htmlspecialchars($_POST['pseudo']),
        'message' => htmlspecialchars($_POST['message'])));
}
else {
    if (! isset($_POST['pseudo'])) {
        echo '<br />Il faut renseigner un pseudo.';
    }
    if (! isset($_POST['message'])) {
        echo '<br />Il faut renseigner un message.<br />';
    }
}

// Puis rediriger vers minichat.php comme ceci :

header('Location: minichat.php');

?>