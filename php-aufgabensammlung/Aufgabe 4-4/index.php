<!doctype html>
<?php include '../inc.php'; ?>
<?php 
	// Funktion um unsere coole Ausgabe zu schreiben.
	// Die Funktion benötigt 2 Parameter, die vom Nutzer übergeben werden sollen. Notwendig ist das Land.
	function info($country, $array) {
		// Zuerst wandeln wir den ersten Buchstaben der Eingabe um. So ist es auch möglich, dass der User ein Land klein schreibt und es dennoch im Array gefunden wird
		$country = mb_convert_case($country, MB_CASE_TITLE, 'UTF-8');
		// Hier setzen wir mithilfe des übergebenen Parameters das Land in das Array ein.
		// Wenn etwas übereinstimmt, ist es toll, ansonsten bleibt die Ausgabe leer.
		$hauptstadt = $array["$country"][0];
		$sprache	= $array["$country"][1];
		$flaeche	= $array["$country"][2];
		// Eine Kleinigkeit um die Fläche in Fußballfeldern zu liefern.
		// Ein Fußballfeld ist 7140 qm groß..
		// Mit round() wird das Ergebnis kaufmännisch gerundet.
		$fussball 	= round($flaeche / 7140); 
		// Hier setzen wir die Tausendertrennung mit der number_format()-Funktion in die Flächenangabe.
		// Damit haben wir eine schön leserliche und weniger verwirrende Zahl.
		$flaeche 	= number_format($flaeche, 0, '', '.'); 
		// Anweisung was zu tun ist, wenn die das Array verschiedene Ergebnisse liefert.
		// Falls das Land im Array existiert, wird eine coole Ausgabe in die Variable $ausgabe gesetzt. Sämtliche Variablen werden benutzt.
		if ($array[$country] != '') {
			$ausgabe = 'Die Hauptstadt von <strong>' . $country . '</strong> ist <strong>' . $hauptstadt . '</strong>. <br>Ihre Landessprache ist ' . $sprache . '. <br>Die Menschen leben auf einer Gesamtfläche von ' . $flaeche . 'km<sup>2</sup>. <br><br>Das ist ungefähr so groß wie ' . $fussball . ' Fußballfelder.';
		}
		// Wenn das Feld leer war abgeschickt wurde, dann wird die Ausgabe entsprechend angepasst.
		else if (empty($country)) {
			$ausgabe = 'Bitte ein Land eingeben…';
		}
		// In allen anderen Fällen (zB wenn das Land nicht im Array existiert) wird eine spezielle Ausgabe gesetzt.
		else {
			$ausgabe = 'Leider konnte <strong>' . $country . '</strong> nicht gefunden werden. Versuchen Sie es mit einem anderen Land…';
		}
		// Die Variable $ausgabe wird aus der Funktion ausgegeben.
		echo $ausgabe;
	}
	// Unser Array mit einigen Einträgen
	$world = array(
		"Deutschland"	=> array("Berlin", "Deutsch", "357021"),
		"Österreich"	=> array("Wien", "Deutsch", "83855"),
		"Frankreich"	=> array("Paris", "Französisch", "674843"),
		"Spanien"		=> array("Madrid", "Spanisch", "504645"),
		"Niederlande"	=> array("Amsterdam", "Niederländisch", "41548"),
		"England" 		=> array("London", "Englisch", "130395")
	);
	// Die Variable $land wird mit dem abgeschickten Eingabewert des Inputfelds "land" gesetzt.
	$land = $_POST['land'];

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
		section {
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
		<h1><?php echo $title ?></h1>
		<p>Geben Sie einfach ein Land in das Feld und erhalten Sie die Hauptstadt!</p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
			<fieldset>
				<label for="land">Geben Sie ein Land ein:</label>
				<input type="text" name="land">
			</fieldset>
			<input type="submit" value="Hauptstadt abfragen">
		</form>
	</section>
	<section>
		<!-- Hier benutzen wir unsere coole Funktion. Schöner, sauberer und schlanker php code im Markup. -->
		<p><?php info($land, $world) ?></p>
	</section>
</body>
</html>