<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>minichat_post</title>
</head>
<body>

	<?php 
	include("db_connect.php");

	if(!isset($_COOKIE['pseudo'])){
			setcookie('pseudo',$_POST['pseudo'],time() + 3600, null, null, false, true);
		}

	$req = $bdd->prepare('
		INSERT INTO chat(pseudo,message,date_comment)
		VALUES(:pseudo,:message,NOW())
		');

	$req->execute(array(
		'pseudo' => htmlspecialchars($_POST['pseudo']),
		'message' => htmlspecialchars($_POST['message'])
	));

	header('Location: minichat.php');
	?>
	

</body>
</html>