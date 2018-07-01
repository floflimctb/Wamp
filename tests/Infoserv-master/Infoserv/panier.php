<?php
	include 'class/Panier.php';
	include_once 'class/Service.php';
	include_once 'class/Employe.php';

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

	if(isset($_POST['supp'])){
		$pp = unserialize($_SESSION['panier']);
		$pp->retraitArticle($_POST['clef']);
		$_SESSION['panier'] = serialize($pp);
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
	<title>Panier</title>
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
	<table class="table table-striped article">
	<thead>
		<tr>
			<th colspan="2">Service</th>
			<th>Employé</th>
			<th colspan="2">Date</th>
			<th>Prix</th>
			<th>Retirer</th>
		</tr>
	</thead>
	<tbody>
	<?php

	$pp = unserialize($_SESSION['panier']);

	//echo $_SESSION['panier']."<br><br>";

	foreach($pp->getArticles() as $key => $value){
		$s=new Service();
		$s->generer($value->getService());
		$e=new Employe();
		$e->generer($value->getEmploye());

		$formSupp = '<form action="#" method="post"><input type="hidden" name="clef" value='.$key.'><button type="submit" name="supp" value="" class="btn btn-default del"><span class="glyphicon glyphicon-remove"></span></button></form>';

		echo "<tr>
			<td>
				<img src=\"img/service/".$value->getService().".png\">
			</td>
			<td>".$s->getNom()."</td>
			<td>".$e->getPrenom()." ".$e->getNom()."</td>
			<td>".$value->getHeureDeb()."</td>
			<td>".$value->getHeureFin()."</td>
			<td>".$s->getPrix()."</td>	
			<td>".$formSupp."</td>	
		</tr>";

		//echo "Employe : ".$value->getEmploye()."//// Service : ".$value->getService()."//// Commence à  : ".$value->getHeureDeb()."//// Finis à  : ".$value->getHeureFin()."//// Le  : ".$value->getDateCommande()."<br><br>";
	}

	?>
	</tbody>
	</table>

	<p><?php if($pp->getPrixTotal()!=0) echo "<p class=\"col-sm-offset-11 col-sm-1 total\">".$pp->getPrixTotal()."€</p>"; ?></p>
	<br>
	<p><?php if($pp->getPrixTotal()!=0) echo '<form action="commande.php" method="post" class="centre"><input type="hidden" name="ok" value="cbon"><button type="submit" name="commander" class="btn btn-default">Passer ma commande</button></form>' ?></p>

	<footer class="footer" style="margin-top:50px;">
      <div class="container">
        <p class="text-muted">Infoservice est un projet étudiant réalisé par Dylan Ritrovato et Lucas Marie.<br>Pour plus d'infos n'hésitez pas à nous contacter <a href="mailto:contact@piwit.xyz"> contact@infoserv.xyz</a></p>
      </div>
    </footer>
</body>
</html>
