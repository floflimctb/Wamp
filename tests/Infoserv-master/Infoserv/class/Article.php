<?php

include 'config.php';

class Article implements Serializable{

private $employe;
private $adresseEmploye;
private $service;
private $heureDeb;
private $heureFin;
private $dateCommande;

	// string, int, int, time, time, date
	public function __construct($e, $a, $s, $hd, $hf, $d){
		$this->employe = $e;
		$this->adresseEmploye = $a;
		$this->service = $s;
		$this->heureDeb = $hd;
		$this->heureFin = $hf;
		$this->dateCommande = $d;
	}
	
	public function getEmploye(){
		return $this->employe;
	}

	public function getAdresseEmploye(){
		return $this->adresseEmploye;
	}

	public function getService(){
		return $this->service;
	}

	public function getHeureDeb(){
		return $this->heureDeb;
	}

	public function getHeureFin(){
		return $this->heureFin;
	}

	public function getDateCommande(){
		return $this->dateCommande;
	}

	public function toStringue(){
		$s=$this->service." ".$this->employe." ".$this->dateCommande." ".$this->heureDeb." ".$this->heureFin;
		return $s;
	}

	public function serialize()
    {
        return serialize([
            $this->employe,
            $this->adresseEmploye,
            $this->service,
            $this->heureDeb,
            $this->heureFin,
            $this->dateCommande
        ]);
    }

    public function unserialize($data)
    {
        list(
            $this->employe,
            $this->adresseEmploye,
            $this->service,
            $this->heureDeb,
            $this->heureFin,
            $this->dateCommande
        ) = unserialize($data);
    }
}
?>