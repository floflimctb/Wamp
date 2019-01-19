<?php
    session_start();

    // mini_chat
    //     messages
    //         id / date_creation / pseudo / contenu
    
    // Insertion des formulaires dans la bdd
    if(isset($_POST['pseudo'])){
        $_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);
        $_POST['contenu'] = htmlspecialchars($_POST['contenu']);
        
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=mini_chat;', 'root', '');
        }catch(Exception $e){
            die($e->getMessage());
        }

        $_SESSION['pseudo'] = $_POST['pseudo'];
        if(isset($_POST['contenu'])){
            $req = $bdd->prepare('INSERT INTO messages (`pseudo`, `contenu`)
                                  VALUES (:pseudo, :contenu)
                                ');
            $req->execute(array(
                'pseudo' => $_POST['pseudo'],
                'contenu' => $_POST['contenu']
            ));
            $req->closeCursor();
        }
    }
    header('location:mini_chat.php');
?>