<!doctype html>
<?php include '../inc.php'; ?>
<?php 
	// Erstmal schön alle Variablen erstellen und leer machen. 
	$vornameError = $nachnameError = $reiseberichtError = $checkboxError = $vorname = $nachname = $reisebericht = $fehlermeldung = $ziele = '';
	// Funktion zum Schreiben der Einträge in eine XML-Datei. Die Datei wird dabei in der Funktion angegeben, ein Übergeben per Parameter sollte erstmal so nicht notwendig sein.
	function toXML($vorname, $nachname, $reisebericht, $ziele, $sex) {
		// Das ist unsere XML-Datei.
		$file = 'data.xml';
		// Für jeden Eintrag wird das Datum und die uhrzeit gespeichert.
		$date = date("d.m.Y, H:i:s");
		// SimpleXML von PHP nutzen um unsere XML-Datei zu laden
		$xml = simplexml_load_file($file);
		// Falls keine Ziele angecheckt wurden, wird ein alternativer Text gespeichert
		if($ziele != '') {$wunschziele = $ziele;}
		else {$wunschziele = 'Leider keine Ziele angegeben :(';}
		// Hier erstellen wir pro Eintrag unsere XML-Struktur. Jedes Input-Field packen wir fein säuberlich in unsere XML-Datei
		$eintrag = $xml->addChild('eintrag');
		$eintrag->addChild('sex', $sex);
		$eintrag->addChild('name', $vorname . ' ' . $nachname);
		$eintrag->addChild('datum', $date);
		$eintrag->addChild('bericht', $reisebericht);
		$eintrag->addChild('ziele', $wunschziele);
		// ..und nun speichern wir unsere Datei wieder.
		$xml->asXML($file);
	}

	// Funktion um die Eingaben sicherer zu machen und spezielle HTML-Zeichen zu safen. Damit verhindern wir mögliche XSS-Attacken. Wenn schon, denn schon.
	function secure($string) {
		$string = trim($string);
	    $string = stripslashes($string);
	    $string = htmlspecialchars($string);
	    return $string;
	}

	// Funktion um Wunschziele für unsere XML-Datei zu formatieren. Hinterher könnte man es auch wieder exploden wenn notwendig.
	function wunschziele() {
		$checkboxes = $_POST["checkbox-list"];
		$wunschziele = implode(", ", $checkboxes);
		return $wunschziele;
	}

	// Funktion um zu bestimmen, was hinterher im Gästebuch für ein Geschlecht bei jedem Eintrag steht. Abhängig davon, was der User für einen Radio-Button angeklickt hat.
	// Zudem kann man zwei Parameter angeben.
	// Mit dem ersten Parameter $form wird je nachdem ein anderes Wording ausgegeben.
	// Der zweite Parameter sorgt dafür, dass die Funktion mit einem "Opfer" gefüttert wird. Das ist dann das, was wir mit der Funktion verarbeiten.
	function gender($form, $gender) {
		// Variablen erzeugen
		$woman; 
		$man; 
		$radiobutton = $gender;
		// Falls der Funktion etwas übergeben wird, werden "Frau" und "Herr" verwendet.
		// "Herr" ist obsolete; es ist nun "Herrn".
		if ($form == true) { $woman = 'Frau'; $man = 'Herrn'; } 
		// ansonsten ist es "Sie" und "Er", abhängig von dem, was per Radio-Button angeklickt wurde
		else { $woman = 'Sie'; $man = 'Er'; }
		// Überprüfung ob "Frau" oder "Herr" angeklickt wurden und dann das Ausgeben der entsprechenden Begriffe.
		return ($radiobutton == 'Frau' ? $woman : $man);
	}

	// Und los geht die Schose.
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$geschlecht = $_POST['radiobutton-list'];

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
		} 
		else {
			// Wunschziele per Funktion imploden damit es in kurzer Form in der XML gespeichert wird. Niemand mag volle XMLs. Wirklich nicht.
			$wunschziele = wunschziele();
			// Funktion zum Schreiben in die XML-Datei aufrufen
			toXML($vorname, $nachname, $reisebericht, $wunschziele, $geschlecht);
			// Zurücksetzen der Werte nach dem Schreiben als XML
			$vorname = $nachname = $reisebericht = $geschlecht = '';
		}
	}
?>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>
	<meta name="author" content="<?php echo $authors ?>">
	<meta name="date" content="<?php echo $last_mod ?>">
	<meta name="viewport" content="width=device-width">
	<!-- Ein wenig CSS um das ganze Ding etwas aufzuhübschen.. -->
	<style>
		@import url(http://fonts.googleapis.com/css?family=Lato:100,400,700);
		@import url(http://fonts.googleapis.com/css?family=Alegreya+Sans+SC:800);
		body 						{background: black; font-family: 'Lato', helvetica, sans-serif; font-weight: 400; -webkit-transition: background 1s ease-in-out;-moz-transition: background 1s ease-in-out;transition: background 1s ease-in-out;}
		body.op 					{background: #EEE;}
		h1 							{font-family: "Alegreya Sans SC", sans-serif;text-transform: uppercase;font-weight: 800; font-size: 23px; display: inline-block; font-size: 28px; letter-spacing: 1.4px;}
		fieldset 					{border:none; padding: 0; margin: 0 0 15px;}
		label 						{display:inline-block;vertical-align:top;}
		section 					{display: block;}
		.wrapper 					{width: 500px; margin: 0 auto; position: relative; color: white;}
		.wrapper > section 			{background: #222 ; position: absolute; -webkit-backface-visibility: hidden; -webkit-transition: -webkit-transform 1s ease-in-out; width: 100%; min-height: 600px; padding: 20px 40px; border-radius: 10px}
		.error 						{border: red 2px solid; background: #381818;}
		.error-text 				{color: red;}
		.form 						{-webkit-transform: perspective(600px) rotateY(0deg); z-index: 4; -moz-transform: perspective(600px) rotateY(0deg); z-index: 4; transform: perspective(600px) rotateY(0deg); z-index: 4;}
		.comments 					{-webkit-transform: perspective(600px) rotateY(180deg); z-index: 2;-moz-transform: perspective(600px) rotateY(180deg); z-index: 2;transform: perspective(600px) rotateY(180deg); z-index: 2;}
		.form.animate 				{-webkit-transform: perspective(600px) rotateY(180deg);-moz-transform: perspective(600px) rotateY(180deg);transform: perspective(600px) rotateY(180deg);}
		.comments.animate 			{-webkit-transform: perspective(600px) rotateY(360deg);-moz-transform: perspective(600px) rotateY(360deg);transform: perspective(600px) rotateY(360deg);}
		fieldset.block 				{display: block;width: 49%;}
		input, textarea 			{padding: 0;margin: 0;border: 2px solid transparent; box-sizing: border-box; padding: 8px; background: #444; border-radius: 4px; color: white;}
		fieldset.block label, 
		fieldset.block input 		{display: block; width: 100%;}
		fieldset label 				{margin-bottom: 5px;}
		fieldset.bericht label, 
		fieldset.bericht textarea 	{display: block; width: 100%;}
		fieldset.radio 				{display: inline-block; width: 10%; margin-right: 10px;}
		.left 						{float: left;}
		.right 						{float: right;}
		.berichte 					{display: block; overflow-y: scroll; height: 550px;}
		.clearfix:after 			{content:''; display: table; clear: both;}
		textarea 					{width: 100% !important;}
		.button.open 				{background: #2E4D2E}
		.comments 					{max-height: 600px}
		.berichte ul 				{padding: 0;margin: 0; list-style-type: none;}
		.entry 						{margin-bottom: 20px; padding: 10px 20px; -webkit-transition: opacity 250ms ease-in-out;}
		.entry.op 					{opacity: 0.25}
		.berichte ul li:nth-child(odd) .entry {background: #202020;}
		.entry * 					{margin: 0; box-sizing: border-box;}
		.entry h4 					{font-family: "Alegreya Sans SC", sans-serif;text-transform: uppercase;font-weight: 800;font-size: 28px;line-height: 1.3;letter-spacing: 1.4px;margin-bottom: -4px;}
		.entry span 				{color: #4E4E4E;}
		.entry p 					{margin-top: 15px;font-weight: 100; white-space: pre-wrap;}
		.entry span.ziele 			{margin-top: 14px; display: block;}
		.entry span.ziele strong 	{font-weight: 700; color: #fff;}
	</style>
</head>
<body>
	<section class="wrapper clearfix">
		<section class="form">
			<h1>Teilen Sie Ihre Erfahrung mit uns!</h1>
			<p>Füllen Sie einfach das Formular aus und teilen Sie Ihre Erfahrung mit uns und allen anderen!</p>
			<p class="error-text"><?php echo $fehlermeldung; ?></p>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
				<fieldset class="radio left">
					<input value="Frau" name="radiobutton-list" <?php echo ($geschlecht == 'Frau') ? 'checked' : '' ?> type="radio" id="input-women">
					<label for="input-women">Frau</label>
				</fieldset>
				<fieldset class="radio left">
					<input value="Herr" name="radiobutton-list" <?php echo ($geschlecht == 'Herr') ? 'checked' : '' ?> type="radio" id="input-men">
					<label for="input-men">Herr</label>
				</fieldset>
				<div class="clearfix"></div>
				<fieldset class="block left">
					<label for="vorname">Vorname:</label> 
					<input class="<?php echo $vornameError; ?>" name="vorname" value="<?php echo $vorname; ?>" type="text">
				</fieldset>
				<fieldset class="block right">
					<label for="nachname">Nachname:</label> 
					<input class="<?php echo $nachnameError; ?>" value="<?php echo $nachname ?>" name="nachname" type="text">
				</fieldset>
				<fieldset class="bericht">
					<label for="reisebericht">Reisebericht:</label>
					<textarea class="<?php echo $reiseberichtError; ?>" name="reisebericht"><?php echo $reisebericht ?></textarea>
				</fieldset>
				<fieldset>
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
				<input type="submit" name="submit" value="Absenden">
				<input type="reset" value="Zurücksetzen">
				<input type="button" class="button open right" value="Berichte lesen">
			</form>
			
		</section>
		<section class="comments">
			<div class="berichte">
				<ul>
					<?php 
						// Datei laden und als Array in Variable speichern
						$file = 'data.xml';
						$xml = simplexml_load_file($file);
						// Alle Einträge schön umsortieren, dabei werden die Eintrag-Elemente gewählt und sortiert.
						$items = array_reverse($xml->xpath('eintrag'));
						// Foreach um alle nacheinander auszugeben. Dabei nutzen wir unsere coole gender()-Funktion und setzen den Flag $form auf true um ein anderes Wording per Geschlecht zu bekommen.
						foreach($items as $entries) {
							echo '<li><div class="entry"><span>Ein Reisebericht von</span><h4>'.gender(true, $entries->sex).' '.$entries->name.'</h4><span>'.gender(false, $entries->sex).' schrieb am '.$entries->datum.'</span><p>'.$entries->bericht.'</p><span class="ziele">'.gender(false, $entries->sex).' hat desweiteren noch folgende Ziele: <br><strong>'.$entries->ziele.'<strong></div></li>';
						}
					?>
				</ul>
			</div>
			<input type="button" class="button open right" style="margin-top: 17px;" value="Schließen">
		</section>
	</section>
	<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
	<script>
		// CSS3, BITCHES! 
		$('.open').click(function() {
			$('.form, .comments').toggleClass('animate');
			$('body').toggleClass('op');
			$('body').scrollTop(0);
		});
		// Funktion für hübschen Hover-Effekt
		$('.entry').hover(function() {$('.entry').not($(this)).toggleClass('op');});
		// Funktion um Felder zurückzusetzen, da die Standard-Resetfunktion von HTML da ein wenig in die Knie geht.
		$('input[type=reset]').click(function() {
			$('input[name=vorname], input[name=zuname]').removeAttr('value');
			$('input[type=checkbox], input[type=radio]').removeAttr('checked');
		});
	</script>
</body>
</html>