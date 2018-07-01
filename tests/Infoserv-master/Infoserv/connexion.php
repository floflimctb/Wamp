<?php 
	include 'class/Client.php';

	if (session_status() !== PHP_SESSION_ACTIVE) session_start();
	if(isset($_SESSION['mail'])){
		header("location:index.php");
	}		
	$session="<li><a href=\"connexion.php\" title=\"Se connecter\">CONNEXION</a></li>";
	$session.="<li><a href=\"inscription.php\" title=\"S'inscrire\">INSCRIPTION</a></li>";
	
	$message="Connexion";
	$connexion=true;
	if(isset($_POST['valider'])){
		if(!empty($_POST['email']) && (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)===false))
			$email=$_POST['email'];
		else {$errM="eMail incorrect";$connexion=false;}
		if(!empty($_POST['pass']))
			$mdp=$_POST['pass'];
		else{$errMdp="Entrez un mot de passe.";$connexion=false;}		
		
		if($connexion){
			$membre = new Client();
			
			if($membre->estMembreNonValide($email)){
				$message="Ce compte n'est pas activé.";
			}
			else{
				if($membre->connecter($email, $mdp)){
					$_SESSION['mail'] = strtolower($email);
					$message="Vous êtes connecté";
					header( "refresh:1;url=index.php" );
				}
				else $message="Email ou mot de passe incorrect.";
			}
		}else $message="Erreur sur la saisie des identifiants.";
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
<title>Connexion</title>
</head>
<body>
	<nav class="navbar navbar-inverse navbar-static-top" id="nav">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="index.php">
	        <img alt="Infoserv🔩" src="logo.png" width="93px" height="75px" style="margin-top:-20px;">
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

	<h1 class="centre"><?php echo $message;?></h1>
	<div class="center">
	<form class="form-horizontal" role="form" action="#" method="post">
		<div class="form-group">
			<label class="control-label col-sm-2">E-mail </label><div class="col-sm-10"><input class="form-control" type="text" name="email"  required="true" maxlength="255" placeholder="Votre e-mail"><?php echo "<label class=\"erreur\">".$errM."</label>";?></div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Mot de passe </label><div class="col-sm-10"><input class="form-control" type="password" name="pass" required="true" maxlength="32" placeholder="Votre mot de passe"><?php echo "<label class=\"erreur\">".$errMdp."</label>";?></div> 
		</div>
		
		<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
		<button type="submit" class="btn btn-default" name="valider">Me connecter</button> </div></div>
	</form>
	</div>
	<footer class="footer" style="margin-top:50px;">
      <div class="container">
        <p class="text-muted">Infoservice est un projet étudiant réalisé par Dylan Ritrovato et Lucas Marie.<br>Pour plus d'infos n'hésitez pas à nous contacter <a href="mailto:contact@piwit.xyz"> contact@infoserv.xyz</a></p>
      </div>
    </footer>
</body>
</html>
