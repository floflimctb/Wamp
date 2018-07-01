<?php 
include 'config.php';
include_once 'Employe.php';

class Service{
	private $bd;
	private $id;
	private $nom;
	private $prix;
	private $duree;
	private $description;

	public function __construct(){
		$this->bd = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD,DB_DATABASE);
		if (!$this->bd->set_charset("utf8")) $this->bd->character_set_name();
	}

	public function generer($id){
		$this->id=$id;
		$this->nom=$this->bd->query("SELECT nom FROM service WHERE id='$id'")->fetch_assoc()['nom'];
		$this->prix=$this->bd->query("SELECT prix FROM service WHERE id='$id'")->fetch_assoc()['prix'].'€';
		$this->duree=$this->bd->query("SELECT duree FROM service WHERE id='$id'")->fetch_assoc()['duree'].'h';
		$this->description=$this->bd->query("SELECT description  FROM service WHERE id='$id'")->fetch_assoc()['description'];
	}

	public function getNom(){
		return $this->nom;
	}

	public function getPrix(){
		return $this->prix;
	}

	public function getDuree(){
		return $this->duree;
	}

	public function getDureeHeure(){
		return substr($this->duree, 0, -1);
	}

	public function getDescription(){
		return $this->description;
	}

	public function getEmployeApteA(){
		$retour=array();
		$requete=$this->bd->query("SELECT employe FROM apteA WHERE service='$this->id'");
		while($donnee = $requete->fetch_assoc()){
			$email=$donnee['employe'];
			$e=new Employe();
			$e->generer($email);
			array_push($retour,$e);	
		}
		return $retour;
	}

	public function max(){
		$compteur=0;
		$requete=$this->bd->query("SELECT * FROM service");
		while($donnee = $requete->fetch_assoc()){
			$compteur++;
		}
		return $compteur;
	}

}
?>
