<?php 
	include 'class/Client.php';

	if (session_status() !== PHP_SESSION_ACTIVE) session_start();
	if(isset($_SESSION['mail'])){
		$session="<li><a href=\"panier.php\" title=\"Panier\">PANIER</a></li>";
		$session.="<li><a href=\"compte.php\" title=\"Compte\">COMPTE</a></li>";
	}else{
	 $session="<li><a href=\"connexion.php\" title=\"Se connecter\">CONNEXION</a></li>";
	 $session.="<li><a href=\"inscription.php\" title=\"S'inscrire\">INSCRIPTION</a></li>";
	}

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
	
	$message="Inscription";
	$inscription=true;
	$compteurFacultatif = 0;
	$compteurFacultatif2 = 0;
	
	if(isset($_POST['valider'])){
		$regexNom = "/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i";
		$regexTel = "`^0[1-9]([-. ]?\d{2}){4}[-. ]?$`";
		if(!empty($_POST['prenom']) && preg_match($regexNom,$_POST['prenom'])==0)
			$prenom=$_POST['prenom'];
		else {$errP="Prénom incorrect";$inscription=false;}
		if(!empty($_POST['nom']) && preg_match($regexNom,$_POST['nom'])==0)
			$nom=$_POST['nom'];
		else {$errN="Nom incorrect";$inscription=false;}
		if(!empty($_POST['email']) && (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)===false))
			$email=$_POST['email'];
		else {$errM="eMail incorrect";$inscription=false;}
		if(!empty($_POST['pass']) && !empty($_POST['passVerif']) && $_POST['pass']==$_POST['passVerif'] && verifMdp($_POST['pass']))
			$mdp=$_POST['pass'];
		else{$errMdp="Erreur sur les critères du mot de passe ou sur la vérification";$inscription=false;}		
		if(!empty($_POST['phone']) && preg_match($regexTel,$_POST['phone'])==1)
			$tel=$_POST['phone'];
		else {$errT="Téléphone incorrect";$inscription=false;}
		
		if(!empty($_POST['addr1'])) $compteurFacultatif++;
		if(!empty($_POST['addr2'])) $compteurFacultatif2++;
		if(!empty($_POST['cod'])) $compteurFacultatif++;
		if(!empty($_POST['ville'])) $compteurFacultatif++;
		if(!($compteurFacultatif==0  || $compteurFacultatif==3)){ $inscription=false; $errF = "Si un champ d'adresse est renseigné, tous doivent être renseignés (sauf Adresse(2) qui reste facultatif).";}
		if($compteurFacultatif!=3  && $compteurFacultatif2==1) { $inscription=false; $errF = "Un complément d'adresse seul est absurde!";}
		
		if($inscription){
			$nouvMembre = new Client();
			
			$addr1 = null; $addr2 = null; $code = null; $ville = null;
			if(!empty($_POST['addr1'])) $addr1 = $_POST['addr1'];
			if(!empty($_POST['addr2'])) $addr2 = $_POST['addr2'];
			if(!empty($_POST['cod'])) $code = $_POST['cod'];
			if(!empty($_POST['ville'])) $ville = $_POST['ville'];
			
			if($nouvMembre->estMembreValide($email) || $nouvMembre->estMembreNonValide($email)){
				$errM="Cet email est déjà utilisé !";
				$message="L'inscription a une erreur";
			}
			else{
				$nouvMembre->enregistrer($_POST['civilite'],$nom,$prenom,$_POST['datenais'],$email,$mdp,$tel,$addr1,$addr2,$code,$ville);
				$message="L'inscription est valide";
			}
		}else $message="L'inscription a une erreur";
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
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<script src="datepicker/locales/bootstrap-datepicker.fr.min.js"></script>

<title>Inscription</title>
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
			<label class="control-label col-sm-2"><span>*</span>Civilité </label><div class="col-sm-10"><label class="radio-inline"><input type="radio" name="civilite" required="true" value="M." >M.</label><label class="radio-inline"><input type="radio" name="civilite" required="true" value="Mme." >Mme.</label></div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2"><span>*</span>Prénom </label><div class="col-sm-10"><input class="form-control" type="text" name="prenom" required="true" maxlength="255" placeholder="Prénom"><?php echo "<label class=\"erreur\">".$errP."</label>";?></div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2"><span>*</span>Nom </label><div class="col-sm-10"><input class="form-control" type="text" name="nom" required="true" maxlength="255" placeholder="Nom"><?php echo "<label class=\"erreur\">".$errN."</label>";?></div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2"><span>*</span>Date de naissance </label><div class="col-sm-10"><input id="datePicker" class="form-control" type="text" name="datenais" required="true" maxlength="10" placeholder="AAAA-MM-JJ"><?php echo "<label class=\"erreur\"></label>";?></div>
		</div>
		<script>
					$(document).ready(function() {
					$('#datePicker')
					    .datepicker({
					        todayBtn: "linked",
							language: "fr",
					        format: 'yyyy-mm-dd'
					    })


					    .on('changeDate', function(e) {
					        // Revalidate the date field
					        $('#eventForm').formValidation('revalidateField', 'date');
					    });

					
					});
</script>
		<div class="form-group">
			<label class="control-label col-sm-2"><span>*</span>E-mail </label><div class="col-sm-10"><input class="form-control" type="text" name="email"  required="true" maxlength="255" placeholder="Adresse e-mail"><?php echo "<label class=\"erreur\">".$errM."</label>";?></div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2"><span>*</span>Mot de passe </label><div class="col-sm-5"><input class="form-control" type="password" name="pass" required="true" maxlength="32" placeholder="Au moins huit caractères dont un chiffre"></div><div class="col-sm-5"><input class="form-control" required="true" type="password" name="passVerif" placeholder="Confirmation du mot de passe"><?php echo "<label class=\"erreur\">".$errMdp."</label>";?></div> 
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2"><span>*</span>Téléphone </label><div class="col-sm-10"><input class="form-control" type="tel" name="phone"  required="true" maxlength="10" placeholder="Numéro de téléphone"><?php echo "<label class=\"erreur\">".$errT."</label>";?></div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Adresse </label><div class="col-sm-10"><input class="form-control" type="text" name="addr1" maxlength="255" placeholder="Adresse postale"><?php echo "<label class=\"erreur\">".$errF."</label>";?></div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Adresse (2) </label><div class="col-sm-10"><input class="form-control" type="text" name="addr2" maxlength="255" placeholder="Complément d'adresse"><?php echo "<label class=\"erreur\"></label>";?></div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Code postal </label><div class="col-sm-4"><input class="form-control" type="text" name="cod" maxlength="5" placeholder="Code postal"><?php echo "<label class=\"erreur\">".$errCP."</label>";?></div><label class="control-label col-sm-1">Ville</label><div class="col-sm-5"><input class="form-control" type="text" name="ville" maxlength="255" placeholder="Ville"><?php echo "<label class=\"erreur\">".$errV."</label>";?></div>
		</div>

		<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
		<button type="submit" class="btn btn-default" name="valider">Je m'inscris !</button> </div></div>
	</form>
	</div>
	<footer class="footer" style="margin-top:50px;">
      <div class="container">
        <p class="text-muted">Infoservice est un projet étudiant réalisé par Dylan Ritrovato et Lucas Marie.<br>Pour plus d'infos n'hésitez pas à nous contacter <a href="mailto:contact@piwit.xyz"> contact@infoserv.xyz</a></p>
      </div>
    </footer>
</body>

</html>
