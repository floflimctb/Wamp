<?php
	include 'class/Panier.php';
	include_once 'class/Service.php';
	include_once 'class/Employe.php';
	include_once 'class/Client.php';

	if (session_status() !== PHP_SESSION_ACTIVE) session_start();
	if(!isset($_SESSION['mail'])){
		header("location:index.php");
	}		
	$session="<li><a href=\"panier.php\" title=\"Panier\">PANIER</a></li>";
	$session.="<li><a href=\"compte.php\" title=\"Compte\">COMPTE</a></li>";
	if(!isset($_SESSION['panier']) || $_SESSION['panier']==null){
		$p = new Panier($_SESSION['mail']);
		$_SESSION['panier'] = serialize($p);
	}
	/*
	if($_POST['ok']!="cbon"){
		header("location:commande.php");
	}*/

	if(!isset($_POST['adress'])){
		header("location:panier.php");
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
	<script type="application/javascript" src="js/tableau.js"></script>
	<title>Ma commande</title>
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
	        <li><a href="contact.php" title="Contact">CONTACT</a></li>
	        <li><a href="index.php" title="Accueil"> <span class="glyphicon glyphicon-home accueil"></span></a></li>
	      </ul>
		</div>
	</nav>

	<h2>Récapitulatif de la commande</h2>
	<table class="table table-striped article">
	<thead>
		<tr>
			<th colspan="2">Service</th>
			<th>Employé</th>
			<th colspan="2">Date</th>
			<th>Prix</th>
		</tr>
	</thead>
	<tbody>
	<?php

	$pp = unserialize($_SESSION['panier']);

	foreach($pp->getArticles() as $value){
		$s=new Service();
		$s->generer($value->getService());
		$e=new Employe();
		$e->generer($value->getEmploye());

		$formSupp = '<form action="#" method="post"><input type="hidden" name="clef" value='.$key.'><button type="submit" name="supp" value="">X</button></form>';

		echo "<tr>
			<td>
				<img src=\"img/service/".$value->getService().".png\">
			</td>
			<td>".$s->getNom()."</td>
			<td>".$e->getPrenom()." ".$e->getNom()."</td>
			<td>".$value->getHeureDeb()."</td>
			<td>".$value->getHeureFin()."</td>
			<td>".$s->getPrix()."</td>	
		</tr>";
	}


	?>
	</tbody>
	</table>
	<div class="adresse centre">
	<?php 
		$cli = new Client();
		$cli->generer($_SESSION['mail']);
		echo $cli->getAdresse($_POST['adress']);
	?>
	</div>

	<?php

	$pp = unserialize($_SESSION['panier']);
	$chaine=$_SESSION['mail'].$pp->getPrixTotal();
	$md5=md5($chaine);
	$url="http://infoserv.piwit.xyz/traitementCommande.php?id=".$md5;
	?>

	<div class="centre">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="business" value="7LU4CFWYGPKRA">
			<input type="hidden" name="lc" value="FR">
			<input type="hidden" name="button_subtype" value="services">
			<input type="hidden" name="no_note" value="0">
			<input type="hidden" name="cn" value="Ajouter des instructions particulières pour le vendeur :">
			<input type="hidden" name="no_shipping" value="2">
			<input type="hidden" name="rm" value="1">
			<input type="hidden" name="return" value="<?php echo $url;?>">
			<input type="hidden" name="amount" value="<?php echo $pp->getPrixTotal();?>">
			<input type="hidden" name="item_name" value="Commande infoservice">
			<input type="hidden" name="currency_code" value="EUR">
			<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
			<input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal, le réflexe sécurité pour payer en ligne">
			<img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
		</form>
	</div>
	<?php
	if(isset($_GET["id"])){
		if($_GET["id"]==$md5){
		$pp->passerCommande($_POST['adress']);
		echo "Votre commande a été effectuée !!!";
		unset($pp);
		$p = new Panier($_SESSION['mail']);
		$_SESSION['panier'] = serialize($p);
	}else echo "Petit canaillou !";
}

	?>

	<footer class="footer" style="margin-top:50px;">
      <div class="container">
        <p class="text-muted">Infoservice est un projet étudiant réalisé par Dylan Ritrovato et Lucas Marie.<br>Pour plus d'infos n'hésitez pas à nous contacter <a href="mailto:contact@piwit.xyz"> contact@infoserv.xyz</a></p>
      </div>
    </footer>
</body>
</html>
