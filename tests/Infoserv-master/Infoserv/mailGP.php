<?php 
function mailA($prenom,$nom,$mail,$mdp){
		$mail=strtolower($mail);
		$message="
		<!DOCTYPE html>
		<html lang=\"fr\">
		<head>
		<meta charset=\"utf8\">
		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">
		<link rel=\"stylesheet\" href=\"http://piwit.xyz/bootstrap/css/bootstrap.min.css\">
		<link rel=\"stylesheet\" href=\"http://piwit.xyz/style.css\">
		<title>Mail</title>
		</head>
		<body style=\"	width: 100%;
						height: 100%;
						padding: 0px;
						margin: 0px;
						background-color:#FAFAFA;
						color:#000000;
						font-family:Tahoma;
						font-size:1.5em;\">

		<h1 style=\"text-align:center;color:#FDD835;\">🔩 Bienvenue sur INFOSERVICE 🔩 </h1>
		<div style=\"text-align:center;padding-bottom:25px;\">
		<p style=\"color:#000000;\">Voici les informations de votre compte veuilllez cliquer sur le lien ci-dessous pour valider votre compte </p>
		<p style=\"color:#000000;\">Prénom : <span style=\"color:#FDD835;font-weight:bold;\">".$prenom."</span></p>
		<p style=\"color:#000000;\">Nom : <span style=\"color:#FDD835;font-weight:bold;\">".$nom."</span></p>
		<p style=\"color:#000000;\">E-mail : <span style=\"color:#FDD835;font-weight:bold;\">".$mail."</span></p>
		<p style=\"color:#000000;\">Mot de passe : <span style=\"color:#FDD835;font-weight:bold;\">".$mdp."</span></p>
		<p><a href=\"google.com\" >Cliquer ici pour valider votre compte !</a></p>
		</div>
		<div class=\"imgCentre\" style=\"
										background-color: #FAFAFA;
										border-top: 1px solid #FDD835;
										height:500px;
										\"
										>
			<a href=\"http://piwit.xyz/login.php\"><img alt=\"Infoserv🔩\" src=\"http://piwit.xyz/img/symbole.PNG\" style=
				\"	display: block;
					width:220px;
					height:220px;
					margin:auto;
					margin-top: 10px;
				\"></a></div>
		</body>
		</html>
		";
		$header='Content-type: text/html; charset=utf8'."\r\n";
		$header .= 'From: Infoserv🔩 <infoserv@piwit.xyz>' . "\r\n";
		mail($mail,"Infoserv🔩 inscription",$message,$header);
	}
	
	mailA("lucas","swag","lucas.marie.2b@gmail.com","starwars3");
?>