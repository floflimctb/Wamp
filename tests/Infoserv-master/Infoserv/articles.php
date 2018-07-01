<?php 
	include 'class/Service.php';
	include 'class/Panier.php';

	if(session_status() !== PHP_SESSION_ACTIVE) session_start();
	if(isset($_SESSION['mail'])){
		$session="<li><a href=\"panier.php\" title=\"Panier\">PANIER</a></li>";
		$session.="<li><a href=\"compte.php\" title=\"Compte\">COMPTE</a></li>";
	}else{
	 $session="<li><a href=\"connexion.php\" title=\"Se connecter\">CONNEXION</a></li>";
	 $session.="<li><a href=\"inscription.php\" title=\"S'inscrire\">INSCRIPTION</a></li>";
	}
	if(!isset($_SESSION['panier']) || $_SESSION['panier']==null){
		$p = new Panier($_SESSION['mail']);
		$_SESSION['panier'] = serialize($p);
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
<title>Infoserv🔩</title>
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
		 	<li><a href="#" title="Services">SERVICES</a></li>
	        <li><a href="contact.php" title="Contact">CONTACT</a></li>
	        <li><a href="index.php" title="Accueil"> <span class="glyphicon glyphicon-home accueil"></span></a></li>
	      </ul>
		</div>
	</nav>
	<div class="container">
	<?php 
		for($i=1;$i<=11;$i++){
		 	$s=new Service();
			$s->generer($i);
		?>
		<div class="col-xs-12 col-sm-6 col-md-4">	
			<a href="service.php?id=<?php echo $i; ?>">
			<div class="articles">
				<?php
					echo "<h2>".$s->getNom()."</h2>";
					echo "<img src=img/service/".$i.".png alt=".$s->getNom().">";
				?>
				<p>
					<span> 
					<?php
						echo $s->getPrix();
					?>
					</span>
					<span>
					<?php 
						echo $s->getDuree();
					?>
					</span>
				</p>	
			</div>
			</a>
		</div>
				<?php
				}
				?>
	</div>
	<footer class="footer" style="margin-top:50px;">
      <div class="container">
        <p class="text-muted">Infoservice est un projet étudiant réalisé par Dylan Ritrovato et Lucas Marie.<br>Pour plus d'infos n'hésitez pas à nous contacter <a href="mailto:contact@piwit.xyz"> contact@infoserv.xyz</a></p>
      </div>
    </footer>
</body>
</html>