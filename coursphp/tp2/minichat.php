<!doctype html>

<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
		<title>Mini-chat</title>
	</head>

	<body>
		<p>Ceci est mon mini-chat</p>

		<form method="post" action="minichat_post.php">
			<label for="pseudo">Pseudo : </label><input type="text" name="pseudo" id="pseudo" /><br />
			<label for="message">Message : </label><input type="text" name="message" id="message" /><br />
			<input type="submit" value="Envoyer" /><br />
		</form>
	</body>
</html>