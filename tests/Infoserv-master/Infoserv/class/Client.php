<?php 

include 'config.php';

class Client {

	private $bd;

	private $civilite;
	private $nom;
	private $prenom;
	private $dateNaiss;
	private $email;
	private $telephone;

	private $tabIDadresse;

	public function __construct(){
		$this->bd = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD,DB_DATABASE);
		if (!$this->bd->set_charset("utf8")) $this->bd->character_set_name();
	}

	public function enregistrer($civilite,$nom,$prenom,$dateNaiss,$email,$mdp,$tel,$addr,$addr2,$cp,$ville){
		$mail=strtolower($mail);
		$verifEnregistrement=$this->bd->query("SELECT * FROM utilisateur WHERE email='$mail'")->num_rows;
		if($verifEnregistrement!=0)
			return false;
		$bdMdp=md5($mdp);
		$md5 = md5($civilite.$nom.$prenom.$email);
		$this->bd->query("INSERT INTO utilisateur (civilite,nom,prenom,dateNaiss,email,mdp,telephone,md5,estValide) VALUES ('$civilite','$nom','$prenom','$dateNaiss','$email','$bdMdp','$tel','$md5',false)") or die(mysqli_connect_errno()."OUCCHHHEE");
		if($addr!=null){
			if($addr2!=null){
				$this->bd->query("INSERT INTO adresse (adresse,complAdress,codePostal,ville,id,client) VALUES ('$addr','$addr2','$cp','$ville',1,'$email')") or die(mysqli_connect_errno()."OUCCHHHEE");
			} else{
				$this->bd->query("INSERT INTO adresse (adresse,codePostal,ville,id,client) VALUES ('$addr','$cp','$ville',1,'$email')") or die(mysqli_connect_errno()."OUCCHHHEE");
			}
		}
		$this->mailConf($prenom,$nom,$email,$mdp,$md5);
	}

	public function generer($email){
		$this->tabIDadresse = array();
		
		$this->email=$email;
		$this->civilite=$this->bd->query("SELECT civilite FROM utilisateur WHERE email='$email'")->fetch_assoc()['civilite'];
		$this->nom=$this->bd->query("SELECT nom FROM utilisateur WHERE email='$email'")->fetch_assoc()['nom'];
		$this->prenom=$this->bd->query("SELECT prenom FROM utilisateur WHERE email='$email'")->fetch_assoc()['prenom'];
		$this->telephone=$this->bd->query("SELECT telephone FROM utilisateur WHERE email='$email'")->fetch_assoc()['telephone'];
		$this->dateNaiss=$this->bd->query("SELECT dateNaiss FROM utilisateur WHERE email='$email'")->fetch_assoc()['dateNaiss'];
		
		$res = $this->bd->query("SELECT id FROM adresse WHERE client='".$email."'");
		while($data = $res->fetch_assoc()){
			array_push($this->tabIDadresse, $data['id']);
		}
	}

	public function getEmail(){
		return $this->email;
	}
	
	public function getNom(){
		return $this->nom;
	}
	
	public function getPrenom(){
		return $this->prenom;
	}

	public function getTelephone(){
		return $this->telephone;
	}
	
	public function getCivilite(){
		return $this->civilite;
	}

	public function getDateNaiss(){
		return $this->dateNaiss;
	}

	public function getAdresses(){
		$tabAdr = array();
		foreach ($this->tabIDadresse as $value){
			$res = $this->bd->query("SELECT * FROM adresse WHERE id=$value && client='$this->email'");
			$data = $res->fetch_assoc();
				
			$ad = $this->getPrenom()." ".$this->getNom()."<br>".$data['adresse']."<br>".$data['complAdress']."<br>".$data['codePostal']." ".strtoupper($data['ville']);
			$tabAdr[$value] = $ad;
		}
		return $tabAdr;
	}

	public function getAdresse($id){
		$res = $this->bd->query("SELECT * FROM adresse WHERE id=$id && client='$this->email'");
		$data = $res->fetch_assoc();			
		$ad = $this->getPrenom()." ".$this->getNom()."<br>".$data['adresse']."<br>".$data['complAdress']."<br>".$data['codePostal']." ".strtoupper($data['ville']);
		return $ad;
	}

	public function estMembreValide($mail){
		$mail=strtolower($mail);
		$nbLignes=$this->bd->query("SELECT * FROM utilisateur WHERE email='$mail'")->num_rows;
		if($nbLignes>0){
			$nbLignes2=$this->bd->query("SELECT * FROM utilisateur WHERE email='$mail' AND estValide=true")->num_rows;
			if($nbLignes2>0) return true;
		}
		return false;
	}
	
	public function estMembreNonValide($mail){
		$mail=strtolower($mail);
		$nbLignes=$this->bd->query("SELECT * FROM utilisateur WHERE email='$mail'")->num_rows;
		if($nbLignes>0){
			$nbLignes2=$this->bd->query("SELECT * FROM utilisateur WHERE email='$mail' AND estValide=false")->num_rows;
			if($nbLignes2>0) return true;
		}
		return false;
	}

	public function connecter($mail,$mdp){
		$mail=strtolower($mail);
		$bdMdp=md5($mdp);
		$nbLignes=$this->bd->query("SELECT * FROM utilisateur WHERE email='$mail' AND mdp='$bdMdp' AND estValide=true")->num_rows;
		if($nbLignes==0)return false;
		return true;	
	}

	public function ajouterAdresse($addr, $addr2, $cp, $ville, $mail){
		$nbLignes=$this->bd->query("SELECT id FROM adresse WHERE client='$mail'")->num_rows;
		$nbLignes=$nbLignes+1;
		if($addr2!=null){
				$this->bd->query("INSERT INTO adresse (adresse,complAdress,codePostal,ville,id,client) VALUES ('$addr','$addr2','$cp','$ville',$nbLignes,'$mail')") or die(mysqli_connect_errno()."OUCCHHHEE");
			} else{
				$this->bd->query("INSERT INTO adresse (adresse,codePostal,ville,id,client) VALUES ('$addr','$cp','$ville',$nbLignes,'$mail')") or die(mysqli_connect_errno()."OUCCHHHEE2");
			}
	}

	public function modifierTelephone($mail, $param){
		$this->bd->query("UPDATE utilisateur SET telephone='$param' WHERE email='$mail'") or die(mysqli_connect_errno()."OUCCHHHEE");
	}

	public function modifierMdp($mail, $param){
		$md5 = md5($param);
		$this->bd->query("UPDATE utilisateur SET mdp='$md5' WHERE email='$mail'") or die(mysqli_connect_errno()."OUCCHHHEE");
	}
	
	public function mailConf($prenom,$nom,$mail,$mdp,$md5){
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
		<p><a href=\"http://infoserv.piwit.xyz/confirmation.php?cle=".$md5."\" >Cliquer ici pour valider votre compte !</a></p>
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

}
?>