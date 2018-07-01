<?php

if (isset($_POST['mot_de_passe'])) {
	$_POST['mot_de_passe'] = strip_tags($_POST['mot_de_passe']);

	if (strtolower($_POST['mot_de_passe']) == "kangourou") {
		echo '<p>Vous êtes bien connecté au site de la NASA.</p>';
	}
	else {
		?>

		<p>Le mot de passe renseigné n'est pas valide. Cliquez <a href="http://localhost/coursphp/tp1.php">ici</a> pour revenir en arrière.</p>

		<?php
	}
}
else {
	?>

	<p>Vous n'avez pas renseigné de mot de passe. Cliquez <a href="http://localhost/coursphp/tp1.php">ici</a> pour revenir en arrière.</p>

	<?php
}

?>