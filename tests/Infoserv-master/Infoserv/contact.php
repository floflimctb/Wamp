<?php
	include 'class/Employe.php';
	include_once 'class/Client.php';
	include_once 'class/config.php';

	if(session_status() !== PHP_SESSION_ACTIVE) session_start();
	if(isset($_SESSION['mail'])){
		$session="<li><a href=\"panier.php\" title=\"Panier\">PANIER</a></li>";
		$session.="<li><a href=\"compte.php\" title=\"Compte\">COMPTE</a></li>";
		$mail=$_SESSION['mail'];
		$c=new CLient();
		$c->generer($mail);
		$prenom=$c->getPrenom();
		$nom=$c->getNom();
	}else{
	 $session="<li><a href=\"connexion.php\" title=\"Se connecter\">CONNEXION</a></li>";
	 $session.="<li><a href=\"inscription.php\" title=\"S'inscrire\">INSCRIPTION</a></li>";
	 $mail="adresse@email.com";
	 $prenom="Prénom";
	 $nom="Nom";
	}

	$bd = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	$res = $bd->query("SELECT email FROM employe");
	$tab=array();
	while($data=$res->fetch_assoc()){
		$e=new Employe();
		$e->generer($data['email']);
		array_push($tab,$e);
	}
	$nbEmploye=count($tab);
	$titre="Contactez un des notres pour un service personnalisé";
	if(isset($_POST['envoyer'])){
		if(isset($_POST['employe'])){
			$header='Content-type: text/html; charset=utf8'."\r\n";
			$header .= 'From: '.$_POST['prenom'].' '.$_POST['nom'].' <'.$_POST['mail'].'>' . "\r\n";
			$message=$_POST['message'];
			$a=$_POST['employe'];
			mail($a,"Message",$message,$header);
			$titre="Message envoyé";
		}else $titre="Il faut sélectionner un employé à qui envoyer le message";
	}
?> 	
	
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="icon" type="image/png" href="/img/favicon.png" />
	<link rel="stylesheet" href="style.css">
	<title>Contact</title>
</head>
<body>
	<nav class="navbar navbar-inverse navbar-static-top" id="nav">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="index.php">
	        <img alt="Infoserv🔩" src="logo.png"  width="93px" height="75px" style="margin-top:-20px;">
	      </a>
	    </div>
	  
		 <ul class="nav navbar-nav navbar-right">
		 	<?php echo $session;?>
	        <li><a href="articles.php" title="Services">SERVICES</a></li>
	        <li><a href="#" title="Contact">CONTACT</a></li>
	        <li><a href="index.php" title="Accueil"> <span class="glyphicon glyphicon-home accueil"></span></a></li>
	      </ul>
		</div>
	</nav>
	<h2 class="centre"><?php echo $titre;?></h2>
	<div class="container" id="contact">

	<form class="form-horizontal" role="form" action="#" method="post">
	<select class="form-control col-sm-12" name="employe">
			<option selected disabled>Quel employé ?</option>
			<?php for($i=0;$i<$nbEmploye;$i++){?>
				<option value="<?php echo $tab[$i]->getEmail();?>"><?php echo $tab[$i]->getPrenom()." ".$tab[$i]->getNom();?></option>
			<?php } ?>
	</select>
	<div class="form-group">
		<label class="control-label col-sm-1">Nom</label><div class="col-sm-5"><input class="form-control" type="text" name="nom" maxlength="255" placeholder="<?php echo $nom;?>" value="<?php echo $nom;?>"></div>

		<label class="control-label col-sm-1">Prénom</label><div class="col-sm-5"><input class="form-control" type="text" name="prenom" maxlength="255" placeholder="<?php echo $prenom;?>" value="<?php echo $prenom;?>"></div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-1">E-mail</label><div class="col-sm-11"><input class="form-control" type="text" name="mail" required="true" maxlength="255" placeholder="<?php echo $mail;?>" value="<?php echo $mail;?>"></div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-12">Message</label>
		<textarea class="form-control" rows="5" name="message"> </textarea>
	</div>
	<button class="btn btn-default" type="submit" name="envoyer">Envoyer</button>
	</form>
	</div>
	<footer class="footer" style="margin-top:50px;">
      <div class="container">
        <p class="text-muted">Infoservice est un projet étudiant réalisé par Dylan Ritrovato et Lucas Marie.<br>Pour plus d'infos n'hésitez pas à nous contacter <a href="mailto:contact@piwit.xyz"> contact@infoserv.xyz</a></p>
      </div>
    </footer>
</body>
</html>