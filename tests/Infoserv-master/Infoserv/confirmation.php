<?php
include 'class/config.php';

$clefAct = null;
$ok = 0;
if(!empty($_GET['cle'])) $clefAct = $_GET['cle'];

if($clefAct!=null){
	$dataBase = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD,DB_DATABASE);
		if (!$dataBase->set_charset("utf8")) $dataBase->character_set_name();

	$req = "SELECT * FROM utilisateur WHERE md5='$clefAct'";
	$existe = $dataBase->query($req)->num_rows;
	if($existe>0){
		$req2 = "SELECT * FROM utilisateur WHERE md5='$clefAct' AND estValide=false";
		$rendreValide = $dataBase->query($req2)->num_rows;
		if($rendreValide>0){
			$dataBase->query("UPDATE utilisateur SET estValide=true WHERE md5='$clefAct'") or die(mysqli_connect_errno()."OUCCHHHEE");
			$ok = 2;
		}
		else $ok = 1;
	}
	$dataBase->close();
}
	 $session="<li><a href=\"connexion.php\" title=\"Se connecter\">CONNEXION</a></li>";
	 $session.="<li><a href=\"inscription.php\" title=\"S'inscrire\">INSCRIPTION</a></li>";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="icon" type="image/png" href="/img/favicon.png" />
<link rel="stylesheet" href="style.css">
<title>Confirmation</title>
</head>
<body>
	<nav class="navbar navbar-inverse navbar-static-top" id="nav">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="index.php">
	        <img alt="Infoserv🔩" src="logo.png"width="93px" height="75px" style="margin-top:-20px;">
	      </a>
	    </div>
	  
		 <ul class="nav navbar-nav navbar-right">
		 	<?php echo $session;?>
	        <li><a href="articles.php" title="Services">SERVICES</a></li>
	        <li><a href="contact.php" title="Contact">CONTACT</a></li>
	        <li><a href="index.php" title="Index"> <span class="glyphicon glyphicon-home accueil"></span></a></li>
	      </ul>
		</div>
	</nav>
	<h1 class='centre'><?php if($ok==0) echo "Il y a eu une erreur lors du traitement de la demande..."; else if($ok==1) echo "Ce compte est déjà activé !"; else echo "Votre compte est désormais activé ! Vous pouvez désormais vous connecter en cliquant <a href='http://infoserv.piwit.xyz/connexion.php'>ici</a>."; ?></h1>
	<footer class="footer" style="margin-top:50px;">
      <div class="container">
        <p class="text-muted">Infoservice est un projet étudiant réalisé par Dylan Ritrovato et Lucas Marie.<br>Pour plus d'infos n'hésitez pas à nous contacter <a href="mailto:contact@piwit.xyz"> contact@infoserv.xyz</a></p>
      </div>
    </footer>
</body>
</html>
