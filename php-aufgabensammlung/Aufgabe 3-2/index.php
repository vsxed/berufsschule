<!doctype html>
<?php include '../inc.php'; ?>
<?php 
	function secure($string) {
		$string = trim($string);
	    $string = stripslashes($string);
	    $string = htmlspecialchars($string);
	    return $string;
	}

	function gender($form, $gender) {
		$woman; 
		$man; 
		$radiobutton = $gender;
		if ($form == true) { $woman = 'Frau'; $man = 'Herr'; } 
		else { $woman = 'Sie'; $man = 'Er'; }
		return ($radiobutton == 'Frau' ? $woman : $man);
	}

	// Erstmal schön alle Variablen erstellen und leer machen. 
	$vornameError = $nachnameError = $reiseberichtError = $checkboxError = $vorname = $nachname = $reisebericht = $fehlermeldung = $ziele = '';

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$geschlecht = $_POST['gender'];

		// Vorname validieren + sicher weitergeben
		if (empty($_POST['vorname'])) {$vornameError = 'error';} 
		else {$vorname = secure($_POST['vorname']);}

		// Nachnamen validieren
		if (empty($_POST['nachname'])) {$nachnameError = 'error';} 
		else {$nachname = secure($_POST['nachname']);}

		// Reisebericht validieren
		if (empty($_POST['reisebericht'])) {$reiseberichtError = 'error';} 
		else {$reisebericht = secure($_POST['reisebericht']);}

		// Schauen, ob alles was notwendig ist nicht leer ist und es in die XML-Datei schieben
		if (empty($nachname) || empty($vorname) || empty($reisebericht)) {
			$fehlermeldung = 'Bitte füllen Sie alle notwendigen Felder aus…';
			// Falls Checkboxen angeklickt wurden, soll das Array mitgeliefert werden und in den einzelnen Checkboxen wird mit in_array geprüft, ob das Reiseziel sich im Array befindet. Wenn ja, bleiben die jeweils angeklickten Checkboxen beim Validieren gechecked und werden nicht resettet.
			$checkboxes = $_POST["checkbox-list"];
		} else {
			if(isset($_POST["submit"])) {
				$fehlermeldung = "Daten erfolgreich abgeschickt!";
			}
			$checkboxes = $_POST["checkbox-list"];
		}
	}
?>
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
		label, legend {
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
		fieldset.radio, fieldset.checkbox {
			display: inline-block;
			margin-right: 20px;
		}
		fieldset.radio *, fieldset.checkbox * {
			display: inline-block;
			margin-right: 5px;
			width: auto !important;
		}
		input[type=radio]:checked + label, input[type=checkbox]:checked + label {
			font-weight: bold;
		}
		.error {
			border: red 2px solid; 
			background: #EEBBBB;
		}
		.error-text {
			color: red;
		}
	</style>
</head>
<body>
	<section id="form">
		<h1>Teilen Sie Ihre Erfahrung mit uns!</h1>
		<p>Füllen Sie einfach das Formular aus und teilen Sie Ihre Erfahrung mit uns und allen anderen!</p>
		<p class="error-text"><?php echo $fehlermeldung; ?></p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
			<fieldset class="radio">
				<input type="radio" value="Frau" name="gender" id="women" <?php echo ($geschlecht == 'Frau') ? 'checked' : '' ?>>
				<label for="women">Frau</label>
			</fieldset>
			<fieldset class="radio">
				<input type="radio" value="Herr" name="gender" id="men" <?php echo ($geschlecht == 'Herr') ? 'checked' : '' ?>>
				<label for="men">Herr</label>
			</fieldset>
			<fieldset>
				<label for="vorname">Vorname</label>
				<input name="vorname" class="<?php echo $vornameError; ?>" value="<?php echo $vorname; ?>" type="text">
			</fieldset>
			<fieldset>
				<label for="nachname">Nachname</label>
				<input name="nachname" class="<?php echo $nachnameError; ?>" value="<?php echo $nachname; ?>" type="text">
			</fieldset>
			<fieldset>
				<label for="bericht">Dein Urlaubserlebnis</label>
				<textarea class="<?php echo $reiseberichtError; ?>" name="reisebericht"><?php echo $reisebericht; ?></textarea>
			</fieldset>
			<fieldset class="checkbox">
				<legend>Welche Ziele würdest du noch gerne bereisen?</legend>
				<input value="Mazedonien" name="checkbox-list[]" type="checkbox" <?php if(in_array('Mazedonien', $checkboxes)) echo "checked";?> id="input-1">
				<label for="input-1">Mazedonien</label>
				<br>
				<input value="Spanien" name="checkbox-list[]" type="checkbox" <?php if(in_array('Spanien', $checkboxes)) echo "checked";?> id="input-2">
				<label for="input-2">Spanien</label>
				<br>
				<input value="England" name="checkbox-list[]" <?php if(in_array('England', $checkboxes)) echo "checked";?> type="checkbox" id="input-3">
				<label for="input-3">England</label>
				<br>
				<input value="Mesopotanien" name="checkbox-list[]" <?php if(in_array('Mesopotanien', $checkboxes)) echo "checked";?> type="checkbox" id="input-4">
				<label for="input-4">Mesopotanien</label>
				<br>
				<input value="Malediven" name="checkbox-list[]" <?php if(in_array('Malediven', $checkboxes)) echo "checked";?> type="checkbox" id="input-5">
				<label for="input-5">Malediven</label>
				<br>
				<input value="Russland" name="checkbox-list[]" <?php if(in_array('Russland', $checkboxes)) echo "checked";?> type="checkbox" id="input-6">
				<label for="input-6">Russland</label>
				<br>
				<input value="USA" name="checkbox-list[]" <?php if(in_array('USA', $checkboxes)) echo "checked";?> type="checkbox" id="input-7">
				<label for="input-7">USA</label>
			</fieldset>
			<input name="submit" type="submit" value="Absenden">
		</form>
	</section>
</body>
</html>