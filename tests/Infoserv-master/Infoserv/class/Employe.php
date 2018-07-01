<?php

include_once 'config.php';

class Employe{
	
private $bd;

private $email;
private $nom;
private $prenom;
private $telephone;
private $vacance;

private $tabIDadresse;

	public function __construct(){
		$this->bd = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		if (!$this->bd->set_charset("utf8")) $this->bd->character_set_name();
		if ($this->bd->connect_error) 
		  die('Connect Error (' . $this->bd->connect_errno . ') '.$this->bd->connect_error);
	}

	public function generer($email){
		$this->tabIDadresse = array();
		
		$this->email=$email;
		$this->nom=$this->bd->query("SELECT nom FROM employe WHERE email='$email'")->fetch_assoc()['nom'];
		$this->prenom=$this->bd->query("SELECT prenom FROM employe WHERE email='$email'")->fetch_assoc()['prenom'];
		$this->telephone=$this->bd->query("SELECT telephone FROM employe WHERE email='$email'")->fetch_assoc()['telephone'];
		$this->vacance=$this->bd->query("SELECT vacance FROM employe WHERE email='$email'")->fetch_assoc()['vacance'];
		
		$res = $this->bd->query("SELECT id FROM adresseEmploye WHERE employe='".$email."'");
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
	
	public function getVacance(){
		return $this->vacance;
	}
	
	
	public function getAdresses(){
		$tabAdr = array();
		foreach ($this->tabIDadresse as $value){
			$res = $this->bd->query("SELECT * FROM adresseEmploye WHERE id=$value");
			$data = $res->fetch_assoc();
				
			$ad = $this.getPrenom()." ".$this.getNom()."<br>".$data['adresse']."<br>".$data['complAdress']."<br>".$data['codePostal']." ".strtoupper($data['ville']);
			array_push($this->tabAdr, $ad);
		}
		return $tabAdr;
	}
	
	// METHODE PRIVEE
	private function estDisponible($date){
		$t1 = date_create($date->format('Y-m-d')." 08:00:00");
		$t2 = date_create($date->format('Y-m-d')." 19:00:00");
		if($t1 > $date || $t2 <= $date) return false;

		$res = $this->bd->query("SELECT * FROM commande WHERE employe='$this->email'");
		while($data = $res->fetch_assoc()){
			$dateDeb = date_create($data['dateCommande']." ".$data['heureDeb']);
			$dateFin = date_create($data['dateCommande']." ".$data['heureFin']);
			
			if($dateDeb <= $date && $dateFin >= $date) return false;
		}
		
		return true;
	}

	// donner une date objet en entrée au format Y-m-d H:i:s et nbHeures est un int (à chercher dans la BD à la charge du programmeur)
	public function estDisponibleInterval($date, $nbHeures){
		if($nbHeures<1) return false;
		if($nbHeures==1) return $this->estDisponible($date);

		$dateCour = $date;
		$boule;
		for($i=0; $i<$nbHeures; $i++){
			$boule = $this->estDisponible($dateCour);
			if($boule==false) return false;
			$dateCour->add(new DateInterval('PT1H'));
		}
		return true;
	}

	public function apteA($service){
		$res = $this->bd->query("SELECT * FROM commande WHERE employe='$this->email' AND service='$service'")->num_rows;
		
		if($res==0) return false;
		else return true;
	}

}
?>