<!doctype html>
<!-- Mit folgender Funktion wird die zentrale PHP-Datei "inc.php" reingeladen -->
<?php include '../inc.php'; ?> 

<!-- Variable $text wird ausgegeben -->
<?php $text = "Die ist meine erste fröhliche Mitteilung in php. \n Sagt ihr dazu: \"Das ist toll?\"" ?>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>
	<meta name="author" content="<?php echo $authors ?>">
	<meta name="date" content="<?php echo $last_mod ?>">
	<style>
		body 			{ background: #000; font-family: Helvetica, sans-serif;}
		.alert			{ height: auto; width: 100%; max-width: 500px; background: #222; border-radius: 4px; display: block; margin: 0 auto; box-sizing: border-box; -moz-box-sizing: border-box; padding: 30px 40px; -webkit-transition: background 500ms ease-in-out; transition: background 500ms ease-in-out; -moz-transition: background 500ms ease-in-out}
		.alert:hover 	{ background: #666; }
		.alert p 		{ color: #fff; font-size: 16px; font-style: italic; white-space: pre-wrap;}
		header 			{ height: auto; display: block; width: 100%; max-width: 500px; margin: 20% auto 20px;}
		header h2 		{ color: #eee; text-align: center; font-style: normal;}
	</style>
</head>
<body>
	<header>
		<!-- Mit dieser Ausgabe wird der Titel ausgegeben, der als Variable extern definiert wurde -->
		<h2><?php echo $title ?>
		</h2>
	</header>
	<div class="alert">
		<!-- Mit dem Befehl "new line to break" wird die Variable $text mit Zeilenumbruch ausgegeben -->
		<p><?php echo nl2br($text) ?></p>
	</div>
</body>
</html>