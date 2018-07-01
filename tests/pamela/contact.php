<!doctype html>

<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
		<title>Contact</title>
	</head>

	<body>
		<div id="bloc_page">

            <?php include('entete.inc.html'); ?>

       		<br />
            <section>
            	<form method="post"  action="traitement.php">
            		<label for="email">Votre adresse mail : <input type="email" name="email" id="email" placeholder="Ex : nom.prenom@mail.com" size="50" />
            	</form>
            </section>
			<?php include('aside.inc.html'); ?>
        	<?php include('footer.inc.html'); ?>
        	
		</div>
	</body>
</html>