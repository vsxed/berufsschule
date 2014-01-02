<!doctype html>
<?php include '../inc.php'; ?>
<?php 
// Für jeden Eingabefeld wird eine Variable gesezt
	$vorname 	= $_POST['vorname'];
	$nachname 	= $_POST['nachname'];
	$bericht 	= $_POST['bericht'];
	$date 		= date("d.m.Y");
?>
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
		<h2><?php echo $title ?></h2>
	</header>
	<div class="alert">
		<!-- Zu der Variable $vorname wird die Variable $nachname angehängt, beide Variablen werden als Text ausgegeben -->
		<!-- Mit der Variable $date wird das Datum ausgegeben -->
		<!-- Die Variable $bericht gibt den Berichtnamen als Text aus -->
		<p><strong><?php echo $vorname . ' ' . $nachname ?></strong> schreibt uns am <?php echo $date ?> : <br><?php echo $bericht ?></p>
	</div>
</body>
</html>