<!doctype html>

<html>
	<head>
		<meta charset="utf-8" />
		<title>Minichat</title>
	</head>

	<body>
        <form method="post" action="minichat_post.php">
            <label for="pseudo">Votre pseudo : </label>
                <input type="text" name="pseudo" id="pseudo" size="30" maxholder="30" /><br />
            
            <label for="message">Votre message : </label>
                <input type="text" name="message" id="message" size="30" maxholder="255" /><br />
            
            <input type="submit" name="submit" id="submit" /><br />
            
        </form>
        
        <?php
        
        try { 
            $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); 
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage()); 
        }
        
        $reponses = $bdd->query('SELECT pseudo, message FROM minichat ORDER BY ID DESC LIMIT 0, 10');
        
        while ($donnees = $reponses->fetch()) { 
            echo '<p>' . htmlspecialchars($donnees['pseudo']) . ' : ' . htmlspecialchars($donnees['message']) . '</p>';
        }

        $reponses->closeCursor();    

        ?>
	</body>