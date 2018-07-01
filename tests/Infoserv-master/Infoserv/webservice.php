<?php 
include_once "class/Service.php";
include_once "class/Employe.php";
if(isset($_GET['employe']) && isset($_GET['service'])){
	$e=new Employe();
	$e->generer($_GET['employe']);
	$s=new Service();
	$s->generer($_GET['service']);
	$jour=strtotime('previous monday');
	if(date("w")==1) $jour=strtotime("monday");

	header('Content-type: text/xml');
	echo "<dispo>";
	for($j=1;$j<=7;$j++){
		//echo date("Y-m-d",$jour);
		$h=8;
		while($h<=18){
			echo "<creneau>";
			$seconde=$jour+($h*3600);
			$date=date("Y-m-d H:i:s",$seconde);
			echo "<date>".$date."</date>";
			echo "<disponible>";
			$estDispo=$e->estDisponibleInterval(date_create($date),$s->getDureeHeure());
			if($estDispo)
				echo "Oui";
			else echo "Non";
			echo "</disponible>";
			//$h+=$s->getDureeHeure();
			$h++;
			echo "</creneau>";
		}
		$jour+=24*3600;
	}
	echo "</dispo>";
}else echo "Fuck fuck fuck";

?>