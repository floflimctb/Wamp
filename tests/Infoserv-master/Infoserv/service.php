<?php
	include_once 'class/Service.php';
	include 'class/Panier.php';


	if(session_status() !== PHP_SESSION_ACTIVE) session_start();
	if(isset($_SESSION['mail'])){
		$session="<li><a href=\"panier.php\" title=\"Panier\">PANIER</a></li>";
		$session.="<li><a href=\"compte.php\" title=\"Compte\">COMPTE</a></li>";
	}else{
	 $session="<li><a href=\"connexion.php\" title=\"Se connecter\">CONNEXION</a></li>";
	 $session.="<li><a href=\"inscription.php\" title=\"S'inscrire\">INSCRIPTION</a></li>";
	 $achat="desactive";	
	}

	$notif = "";
	if(!isset($_SESSION['panier']) || $_SESSION['panier']==null){
		$p = new Panier($_SESSION['mail']);
		$_SESSION['panier'] = serialize($p);
	}

	$s=new Service();
	if($_GET['id']==null || $_GET['id']<1 || $_GET['id']>$s->max())
		header("location:404.php");
	$s->generer($_GET['id']);
	$titre=$s->getNom();
	$description=$s->getDescription();
	$prix=$s->getPrix();
	$duree=$s->getDuree();
	$img="img/service/".$_GET['id'].".png";
	$tabEmploye=$s->getEmployeApteA();
	$nbEmploye=count($tabEmploye);
	if(isset($_COOKIE["date"])&&isset($_COOKIE["employe"])&&isset($_COOKIE["service"])){
		$pp = unserialize($_SESSION['panier']);

		$heureDeFinInt = intval(substr($_COOKIE["date"],11,2))+$duree;
		if($heureDeFinInt>=10)
			$heureDeFinStr = strval($heureDeFinInt).":00:00";
		else $heureDeFinStr = "0".strval($heureDeFinInt).":00:00";

		$art = new Article($_COOKIE["employe"], 1, $_GET['id'], substr($_COOKIE["date"],10,9), $heureDeFinStr, substr($_COOKIE["date"],0,10));
		if($pp->ajoutArticle($art))
			$notif = " - article ajouté";
		else $notif = " - erreur lors de l'ajout...";
		//echo $pp->toStringue();
		$_SESSION['panier'] = serialize($pp);
	}
	setcookie("date");
	setcookie("employe");
	setcookie("service");

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
	<title><?php echo $titre;?></title>
</head>
<body onload="init();">
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

	<div class="container-fluid">
	<div class="service">
		<h2><?php echo $titre.$notif;?></h2>
		<div class="col-xs-12 col-sm-4 col-md-3 gauche">
			<img src="<?php echo $img;?>" alt="<?php echo $titre;?>">
			<div class="infos">
				<p>Prix : <span><?php echo $prix;?></span></p>
				<p>Durée : <span> <?php echo $duree;?></span></p>
			</div>
			<button type="submit" class="btn btn-default" id="achat" name="ok" <?php echo $achat;?>> <span class="glyphicon glyphicon-shopping-cart"></span></button>

		</div>
		</div>

		<div class="col-xs-10 col-sm-5 col-md-7 milieu">
		<div class="description">
			<?php echo $description;?>
			<p id="erreur"></p>
		</div>
		</div>

		<div class="col-xs-2 col-sm-3 col-md-2 droite">
		<select id="apteA">
			<option selected disabled>Quel employé ?</option>
			<?php for($i=0;$i<$nbEmploye;$i++){?>
				<option value="<?php echo $tabEmploye[$i]->getEmail();?>"><?php echo $tabEmploye[$i]->getPrenom()." ".$tabEmploye[$i]->getNom();?></option>
			<?php } ?>
		</select>
		</div>
	</div>
	<div class="container">
		<div class="col-md-12">
		<div class="table-responsive tableau">
		<table class="table table-bordered">
		<thead>
			<tr>
				<th>Heure<br><p></p></th>
				<th>Lundi</th>
				<th>Mardi</th>
				<th>Mercredi</th>
				<th>Jeudi</th>
				<th>Vendredi</th>
				<th>Samedi</th>
				<th>Dimanche</th>
			</tr>
		</thead>
		<tbody>
			<tr><td class="heure">8h</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><td class="heure">9h</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><td class="heure">10h</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><td class="heure">11h</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><td class="heure">12h</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><td class="heure">13h</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><td class="heure">14h</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><td class="heure">15h</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><td class="heure">16h</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><td class="heure">17h</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
			<tr><td class="heure">18h</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		</tbody>
		</table>
		</div>
		</div>
	</div>

	<footer class="footer" style="margin-top:50px;">
      <div class="container">
        <p class="text-muted">Infoservice est un projet étudiant réalisé par Dylan Ritrovato et Lucas Marie.<br>Pour plus d'infos n'hésitez pas à nous contacter <a href="mailto:contact@piwit.xyz"> contact@infoserv.xyz</a></p>
      </div>
    </footer>
</body>
</html>
