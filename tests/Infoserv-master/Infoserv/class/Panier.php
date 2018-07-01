<?php

include 'config.php';
include 'Article.php';
include_once 'Employe.php';
include_once 'Service.php';
include_once 'Client.php';

class Panier implements Serializable{
	
private $bd;

private $client;
private $articles;

	//string
	public function __construct($clientMail){
		$this->bd = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		if (!$this->bd->set_charset("utf8")) $this->bd->character_set_name();
		if ($this->bd->connect_error) 
		  die('Connect Error (' . $this->bd->connect_errno . ') '.$this->bd->connect_error);
		$this->client = $clientMail;
		$this->articles = array();
	}

	//article
	public function ajoutArticle($unArticle){
		//redéfinition
		$this->bd = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		if (!$this->bd->set_charset("utf8")) $this->bd->character_set_name();
		if ($this->bd->connect_error) 
		  die('Connect Error (' . $this->bd->connect_errno . ') '.$this->bd->connect_error);

		$emp = new Employe();
		$emp->generer($unArticle->getEmploye());

		$data = $this->bd->query("SELECT duree FROM service WHERE id=".$unArticle->getService())->fetch_assoc();//utiliser classe service mieux
		$duree = $data['duree'];

		foreach ($this->articles as $value){
			if($value!=null){
				$dateDebu = date_create($value->getDateCommande()." ".$value->getHeureDeb());
				$dateStop = date_create($value->getDateCommande()." ".$value->getHeureFin());

				$dateT = date_create($unArticle->getDateCommande()." ".$unArticle->getHeureDeb());

				for($i=0; $i<=$duree; $i++){
					if($dateDebu <= $dateT && $dateStop >= $dateT) return false;
					$dateT->add(new DateInterval('PT1H'));
				}
			}
		}

		array_push($this->articles, $unArticle);
		return true;
	}

	public function getArticles(){
		return $this->articles;
	}
	
	//int
	public function retraitArticle($numArticle){
		array_splice($this->articles, $numArticle, 1);
	}

	public function nbArticles(){
		$i=0;
		foreach ($this->articles as $value){
			$i++;
		}
		return $i;
	}

	public function getPrixTotal(){
		$p = 0;
		foreach ($this->articles as $value){
			$serv = new Service();
			$serv->generer($value->getService());
			$p = $p+intval(substr($serv->getPrix(), 0, -1));
		}
		return $p;
	}

	//int
	public function passerCommande($addrCli){
		//redéfinition
		$this->bd = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		if (!$this->bd->set_charset("utf8")) $this->bd->character_set_name();
		if ($this->bd->connect_error) 
		  die('Connect Error (' . $this->bd->connect_errno . ') '.$this->bd->connect_error);

		$mail = $this->client;

		foreach ($this->articles as $value){
			if($value!=null){
				$id = $this->bd->query("SELECT * FROM commande WHERE client='$mail'")->num_rows;
				$id=$id+1;

					$this->bd->query("INSERT INTO commande (id, client, adresse, employe, adresseEmploye, service, heureDeb, heureFin, dateCommande) VALUES ($id, '$mail', $addrCli, '".$value->getEmploye()."', ".$value->getAdresseEmploye().", ".$value->getService().", '".$value->getHeureDeb()."', '".$value->getHeureFin()."', '".$value->getDateCommande()."')") or die(mysqli_connect_errno()."OUCCHHHEE1");
			}
		}

		//GESTION FACTURE
		$this->bd->query("INSERT INTO facture (client, adresseFacturation) VALUES ('$mail', $addrCli)") or die(mysqli_connect_errno()."OUCCHHHEE2");

		$idFac = $this->bd->query("SELECT id FROM facture WHERE client='$mail' ORDER BY id DESC limit 1")->fetch_assoc()['id'];

		$ii=0;
		foreach ($this->articles as $value){
					$this->bd->query("INSERT INTO factureServices (facture, service, nbService) VALUES ($idFac, ".$value->getService().", $ii)") or die(mysqli_connect_errno()."OUCCHHHEE3");
					$ii++;
		}

		$cli = new Client();
		$cli->generer($mail);
		$prenom = $cli->getPrenom();
		$nom = $cli->getNom();

		$this->mailFac($prenom,$nom,$mail);
	}

	public function mailFac($prenom,$nom,$mail){
		$mail=strtolower($mail);

		$arts = "";
		$arts = $arts."<table class='table table-striped article'><thead><tr><th colspan='2'>Service</th><th>Employé</th><th>Date</th><th>Debut</th><th>Fin</th><th>Prix</th></tr></thead><tbody>";

		foreach ($this->articles as $value){
			$e = new Employe();
			$e->generer($value->getEmploye());
			$s = new Service();
			$s->generer($value->getService()); 

			$arts = $arts."<tr><td><img style=\"width:30px;height:30px\"; src=\"http://infoserv.piwit.xyz/img/service/".$value->getService().".png\"></td><td>".$s->getNom()."</td><td>".$e->getPrenom()." ".$e->getNom()."</td><td>".$value->getDateCommande()."</td><td>".$value->getHeureDeb()."</td><td>".$value->getHeureFin()."</td><td>".$s->getPrix()."</td></tr>";	
		}

		$arts = $arts."</tbody></table>";

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

		<h1 style=\"text-align:center;color:#FDD835;\">🔩 Votre facture 🔩 </h1>
		<div style=\"text-align:center;padding-bottom:25px;\">
		<p style=\"color:#000000;\">".$prenom." ".$nom.", merci d'avoir commandé nos services, voici donc le détail de vos achats : </p>
		".$arts."
		<p>Le montant total de la commande est de ".$this->getPrixTotal()." €</p>
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
		mail($mail,"Infoserv🔩 service commandes",$message,$header);
	}

	public function toStringue(){
		$s=$this->client;
		foreach($this->articles as $a){
			$s.=$a->toStringue()." ";
		}
		return $s;
	}

	public function serialize()
    {
        return serialize([
            $this->bd,
            $this->client,
            $this->articles
        ]);
    }

    public function unserialize($data)
    {
        list(
            $this->bd,
            $this->client,
            $this->articles
        ) = unserialize($data);
    }
}
?>