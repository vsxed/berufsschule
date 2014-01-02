<!doctype html>
<!-- Mit folgender Funktion wird die zentrale PHP-Datei "inc.php" reingeladen -->
<?php include '../inc.php'; ?>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>
	<meta name="author" content="<?php echo $authors ?>">
	<meta name="date" content="<?php echo $last_mod ?>">
	<style>
		* {
			box-sizing: border-box;
			-moz-box-sizing: border-box;
		}
		body {
			font-family: Helvetica, sans-serif;
			color: #888;
		}
		#form {
			max-width: 400px;
			margin: 30px auto 0;
			width: 100%;
			height: auto;
			display: block;
			background: #eee;
			padding: 20px 30px;
		}
		fieldset {
			border: none;
			outline: none;
			padding: 0;
			margin: 0;
		}
		label {
			display: block;
			margin-bottom: 10px;
		}
		input, textarea {
			display: block;
			width: 100% !important;
			border: 1px solid transparent;
			outline: none;
			padding: 20px 10px;
			margin: 0 0 15px;
			font-size: 18px;
		}
		input[type=text]:focus, textarea:focus {
			background: #FFECD0;
			border: #E7A600 1px solid;
		}
		input[type=submit]:hover {
			background: #ccc;
		}
	</style>
</head>
<body>
	<section id="form">
		<h1>Teilen Sie Ihre Erfahrung mit uns!</h1>
		<p>Füllen Sie einfach das Formular aus und teilen Sie Ihre Erfahrung mit uns und allen anderen!</p>
		<form action="process.php" method="post">
			<fieldset>
				<label for="vorname">Vorname</label>
				<input name="vorname" type="text">
			</fieldset>
			<fieldset>
				<label for="nachname">Nachname</label>
				<input name="nachname" type="text">
			</fieldset>
			<fieldset>
				<label for="bericht">Dein Urlaubserlebnis</label>
				<textarea name="bericht"></textarea>
			</fieldset>
			<input type="submit" value="Absenden">
		</form>
	</section>
</body>
</html>