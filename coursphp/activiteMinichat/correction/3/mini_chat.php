<?php
    session_start();
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=mini_chat;', 'root', '');
    }catch(Exception $e){
        die($e->getMessage());
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/style.css">
        <title>Mini-chat</title>
    </head>
    <body>
        <form method="POST" action="traitement.php">
            <label for="pseudo">Pseudo: </label><input type="text" name="pseudo" id="pseudo"<?php
                                                                                                if(isset($_SESSION['pseudo']))
                                                                                                    echo 'value="' . htmlspecialchars($_SESSION['pseudo']) . '"';
                                                                                                else
                                                                                                    echo 'placeholder="20 caractères max" autofocus';
                                                                                            ?>
                                                ><br>
            <label for="contenu">Message: </label><input type="text" name="contenu" id="contenu" placeholder="255 caractères max" <?php if(isset($_SESSION['pseudo'])){echo 'autofocus';} ?>>
            <input type="submit" value="Envoyer">

        </form>

        <?php
            // Affichage des éléments de la base de donnée
            $req = $bdd->query('SELECT `pseudo`, `contenu`, DATE_FORMAT(date_creation, \'%d/%m/%Y %Hh%imin%ss\') AS d_c FROM messages');
            while($donnees = $req->fetch()){
                echo '<span class="date">' . $donnees['d_c'] . '</span>' . $donnees['pseudo'] . ' : ' . $donnees['contenu'] . '<br>';
            }
        ?>
    </body>
</html>