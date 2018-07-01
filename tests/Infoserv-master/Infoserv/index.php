<?php 
	if (session_status() !== PHP_SESSION_ACTIVE) session_start();
	if(isset($_SESSION['mail'])){
		$session="<li><a href=\"panier.php\" title=\"Panier\">PANIER</a></li>";
		$session.="<li><a href=\"compte.php\" title=\"Compte\">COMPTE</a></li>";
	}else{
	 $session="<li><a href=\"connexion.php\" title=\"Se connecter\">CONNEXION</a></li>";
	 $session.="<li><a href=\"inscription.php\" title=\"S'inscrire\">INSCRIPTION</a></li>";
	}
	
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="icon" type="image/png" href="img/favicon.png" />
<link rel="stylesheet" href="style.css">
<title>Infoserv🔩</title>
</head>
<body>
	<nav class="navbar navbar-inverse navbar-static-top" id="nav">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="#">
	        <img alt="Infoserv🔩" src="logo.png"  width="93px" height="75px" style="margin-top:-20px;">
	      </a>
	    </div>
	  
		 <ul class="nav navbar-nav navbar-right">
		 	<?php echo $session?>
		 	<li><a href="articles.php" title="Services">SERVICES</a></li>
	        <li><a href="contact.php" title="Contact">CONTACT</a></li>
	        <li><a href="#" title="Accueil"> <span class="glyphicon glyphicon-home accueil"></span></a></li>
	      </ul>
		</div>
	</nav>
	<div class="jumbotron">
	<img src="img/bureau1.jpg" class="img-responsive" alt="Bureau">
	</div>
	<div>
		<div class="col-xs-12 col-md-6" id="lucas">
			<div class="rond" >L</div>
			<p>Ambitieux, dynamique et à votre service. Je suis actuellement en deuxième année d'un DUT Informatique à l'IUT de Nice. Toujours à la recherche d'un défi à accomplir je suis prêt à vous aider dans n'importe quel problème que vous renconterez :). Co-fondateur du site avec mon collègue Dylan Ritrovato. Vous pouvez me contacter au 06484000084 ou par mail via <a href="mailto:lucas@piwit.xyz"> lucas@infoserv.xyz</a></p>
		</div>

		<div class="col-xs-12 col-md-6" id="dylan">
			<div class="rond" id="dylan">D</div>
			<p>Je suis Dylan Ritrovato, le second développeur et concepteur du site. Passionné par les nouvelles technologies, je passe beaucoup de mon temps libre à coder (principalement), monter des PC, lire des mangas et des bouquins de physique et de maths et jouer quand j'ai le temps aux jeux vidéos. :) Je prépare cette année un DUT en informatique qui me servira à continuer mes études en cycle ingénieur. Je suis actuellement à la recherche d'un stage, si cela peut vous intéresser ! ;) Vous pouvez me contacter au 06.95.11.74.95</p>
		</div>
	</div>
	<div class="centre apropos" apropos>
		<div class="col-xs-12 col-md-12" id="infoservice">
			<div class="rond" id="infoservice">I</div>
			<p>Infoservis est un site marchand réalisé, au commencement, dans le cadre d'un projet étudiant. Il a pour vocation de mettre en œuvre nos connaissances informatique acquises en HTML, PHP, JS, web service et bases de données. Ce projet sera très probablement maintenu suite à sa présentation à notre professeur et il aura pour but de proposer les services de deux étudiants en informatique pour du dépannage, du montage, du développement, de la conception et des cours particuliers sur Nice et environs. N'hésitez pas à nous laisser vos commentaires et avis dans la section 'contact'. Merci à vous et bonne navigation ! :)</p>
		</div>
	</div>
	<div class="jumbotron">
		<iframe src="https://www.google.com/maps/d/u/0/embed?mid=zZjUYTnMXD2g.kEpfui3hFf78" width="100%" height="500" style="margin-top: -3px;border-top:1px solid #e4e4e4;"></iframe>
	</div>
	<footer class="footer">
      <div class="container">
        <p class="text-muted">Infoservice est un projet étudiant réalisé par Dylan Ritrovato et Lucas Marie.<br>Pour plus d'infos n'hésitez pas à nous contacter <a href="mailto:contact@piwit.xyz"> contact@infoserv.xyz</a></p>
      </div>
    </footer>
</body>

</html>
