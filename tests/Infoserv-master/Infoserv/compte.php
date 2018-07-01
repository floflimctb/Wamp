<?php
	include 'class/Client.php'; 
	include 'class/Employe.php'; 
	include 'class/Service.php'; 

	if (session_status() !== PHP_SESSION_ACTIVE) session_start();
	if(!isset($_SESSION['mail'])){
		header("location:index.php");
	}		
	$session="<li><a href=\"panier.php\" title=\"Panier\">PANIER</a></li>";
	$session.="<li><a href=\"compte.php\" title=\"Compte\">COMPTE</a></li>";
	$membre = new Client();
	$membre->generer($_SESSION['mail']);
	$tell = $membre->getTelephone();

	function verifMdp($mdp){
		if(!is_string($mdp)) return false;
		if(strlen($mdp)<8) return false;
		
		$countInt = 0;
		$i = 0;
		$temp;
		
		while($i<strlen($mdp)){
			$temp = substr($mdp,$i,1);
			if(ord($temp)>=48 && ord($temp)<=57) $countInt++;
			$i++;
		}
		if($countInt==0) return false;
		
		return true;
	}
	
	$changeMdp = 0;
	$changeTel = 0;
	
	if(isset($_POST['validerInfos'])){
		$regexTel = "`^0[1-9]([-. ]?\d{2}){4}[-. ]?$`";

		if(!empty($_POST['pass']) && !empty($_POST['passVerif'])){
			$changeMdp = 1;
			if($_POST['pass']==$_POST['passVerif'] && verifMdp($_POST['pass']))
				$changeMdp = 2;
		}

		if(!empty($_POST['phone'])){
			$changeTel = 1;
			if(preg_match($regexTel,$_POST['phone'])==1)
				$changeTel = 2;
		}

		$bd = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD,DB_DATABASE);
		if (!$bd->set_charset("utf8")) $this->bd->character_set_name();

		$m = $_SESSION['mail'];
		$passAVerif = $bd->query("SELECT mdp FROM utilisateur WHERE email='$m'")->fetch_assoc()['mdp'];
		$passSaisi = md5($_POST['passAncienConf']);

		if($passAVerif != $passSaisi){
			$erreures = "<p>Mot de passe de confirmation incorrect.</p>";
		} else if($changeMdp==0 && $changeTel==0){
			$erreures = "<p>Tous les champs sont vides.</p>";
		} else if($changeMdp==1 || $changeTel==1){
			$erreures = "<p>";
			if($changeMdp==1) $erreures = $erreures."Erreur sur le nouveau mot de passe.";
			if($changeTel==1) $erreures = $erreures."Erreur sur le nouveau téléphone.";
			$erreures = $erreures."</p>";
		} else{
			if($changeMdp==2) $membre->modifierMdp($_SESSION['mail'], $_POST['pass']);
			if($changeTel==2) $membre->modifierTelephone($_SESSION['mail'], $_POST['phone']);
			$tell = $_POST['phone'];
			$erreures = "<p>Modifications effectuées avec succès.</p>";
		}
	}

	$compteur = 0;

	if(isset($_POST['validerAjoutAdresse'])){
		
		if(!empty($_POST['addr1'])) $compteur++;
		if(!empty($_POST['cod'])) $compteur++;
		if(!empty($_POST['ville'])) $compteur++;
		
		if($compteur==3){
			$addr1 = null; $addr2 = null; $code = null; $ville = null;
			if(!empty($_POST['addr1'])) $addr1 = $_POST['addr1'];
			if(!empty($_POST['addr2'])) $addr2 = $_POST['addr2'];
			if(!empty($_POST['cod'])) $code = $_POST['cod'];
			if(!empty($_POST['ville'])) $ville = $_POST['ville'];
			
			$membre->ajouterAdresse($addr1, $addr2, $code, $ville, $_SESSION['mail']);
		}else $erreuresAd="Format d'adresse invalide !";
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
<title>Gestion de compte</title>
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
	        <li><a href="index.php" title="Index"> <span class="glyphicon glyphicon-home accueil"></span></a></li>
	      </ul>
		</div>
	</nav>

	<div class="container">

	<?php if(!empty($_SESSION['mail'])){ ?>

	<h2>Modifier mes informations</h2>
	<?php echo $erreures ?>
	<br>

	<div class="center">
	<form class="form-horizontal" role="form" action="#" method="post">
		<div class="form-group">
			<label class="control-label col-sm-2">Téléphone </label><div class="col-sm-10"><input class="form-control" type="tel" name="phone" maxlength="10" placeholder="Numéro de téléphone" value="<?php echo $tell; ?>"></div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Mot de passe </label><div class="col-sm-5"><input class="form-control" type="password" name="pass" maxlength="32" placeholder="Au moins huit caractères dont un chiffre"></div><div class="col-sm-5"><input class="form-control" type="password" name="passVerif" placeholder="Confirmez votre nouveau mot de passe"></div> 
		</div>

		<p style="text-align:center;margin:0;display:block;margin-bottom: -20px;	">Pour que les changements soient pris en compte, entrez votre mot de passe</p><br><br>

		<div class="form-group">
			<label class="control-label col-sm-2"><span>*</span>Mot de passe actuel </label><div class="col-sm-10"><input class="form-control" type="password" name="passAncienConf"  required="true" maxlength="32" placeholder="Entrez votre mot de passe"></div>
		</div>
		<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
		<button type="submit" class="btn btn-default" name="validerInfos">Valider</button> </div></div>
	</form>
	</div>

	<h2>Mes commandes</h2>
	<table class="table table-striped article">
	<thead>
		<tr>
			<th colspan="2">Service</th>
			<th>Employé</th>
			<th>Date</th>
			<th>Debut</th>
			<th>Fin</th>
			<th>Prix</th>
		</tr>
	</thead>
	<tbody>
	
	<?php
		$base = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD,DB_DATABASE);
		if (!$base->set_charset("utf8")) $this->bd->character_set_name();

		$m = $_SESSION['mail'];
		$results = $base->query('SELECT * FROM commande WHERE client="'.$m.'"');

		while($donnee = $results->fetch_assoc()){
			$e = new Employe();
			$e->generer($donnee['employe']);
			$s = new Service();
			$s->generer($donnee['service']); 
			?>
		<?php
			echo "<tr>
			<td>
				<img src=\"img/service/".$donnee['service'].".png\">
			</td>
			<td>".$s->getNom()."</td>
			<td>".$e->getPrenom()." ".$e->getNom()."</td>
			<td>".$donnee['dateCommande']."</td>
			<td>".$donnee['heureDeb']."</td>
			<td>".$donnee['heureFin']."</td>
			<td>".$s->getPrix()."</td>	
		</tr>";	
			//echo "Commande ".$donnee['id']." le ".$donnee['dateCommande']." de ".$donnee['heureDeb']." à ".$donnee['heureFin']." fait par ".$e->getPrenom()." ".$e->getNom()." pour le service de ".$s->getNom()." le prix était de ".$s->getPrix()."<br><br>";
		}
	?>
	</tbody>
	</table>

	<h2>Mes adresses</h2>
	<div class="container">

	<?php
		$membre->generer($_SESSION['mail']);
		$tab = $membre->getAdresses();
		foreach ($tab as $key => $value) {
			?>
			<div class="col-sm-3 adresse">
		<?php
			echo $value;?>
			</div><?php
		//	echo "<br><br>";
		}?>
		</div>
		<?php

		echo "<h3>Ajouter une adresse</h3>";
		echo $erreuresAd;
		echo "<br>";
		echo '<form class="form-horizontal" role="form" action="#" method="post"><div class="form-group"><label class="control-label col-sm-2">Adresse </label><div class="col-sm-10"><input class="form-control" type="text" name="addr1" maxlength="255" placeholder="Adresse postale"></div></div><div class="form-group"><label class="control-label col-sm-2">Adresse (2) </label><div class="col-sm-10"><input class="form-control" type="text" name="addr2" maxlength="255" placeholder="Complément d adresse"></div></div><div class="form-group"><label class="control-label col-sm-2">Code postal </label><div class="col-sm-4"><input class="form-control" type="text" name="cod" maxlength="5" placeholder="Code postal"></div><label class="control-label col-sm-1">Ville</label><div class="col-sm-5"><input class="form-control" type="text" name="ville" maxlength="255" placeholder="Ville"></div></div><div class="form-group"><div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-default" name="validerAjoutAdresse">Ajouter</button> </div></div></form>';

	?>

	<?php } else{ ?>

	<h2>Vous n'êtes pas connecté !</h2>

	<?php }?>

	</div>
	
	<footer class="footer" style="margin-top:50px;">
      <div class="container">
        <p class="text-muted">Infoservice est un projet étudiant réalisé par Dylan Ritrovato et Lucas Marie.<br>Pour plus d'infos n'hésitez pas à nous contacter <a href="mailto:contact@piwit.xyz"> contact@infoserv.xyz</a></p>
      </div>
    </footer>
</body>

</html>