<?php 
	// Wir setzen hier eine Variable auf "true".
	// Damit können wir dann später das Front End per PHP kontrollieren.
	// Es soll später schauen, ob die Funktion auch included wurde – wenn nicht, ist die Variable automatisch "false", da sie ohne die passende Funktions-PHP nicht definiert wird.
	$add = true;
	// Variablen erstellen und erstmal leer lassen.
	$entry_title = $entry_description = $entry_regie = $entry_jahr = $entry_dauer = $entry_cover = $entry_fsk = "";

	// Funktion bekannt aus Aufgabe 3-3 der Aufgabensammlung.
	function secure($string) {
		$string = trim($string);
	    $string = stripslashes($string);
	    $string = htmlspecialchars($string);
	    return $string;
	}

	if (isset($_POST["speichern"])) { 
		// Titel validieren + sicher weitergeben
		if (empty($_POST['entry_title'])) {$titleError = 'error';} 
		else {$entry_title = secure($_POST['entry_title']);}

		// Regisseur validieren + sicher weitergeben
		if (empty($_POST['entry_regie'])) {$regieError = 'error';} 
		else {$entry_regie = secure($_POST['entry_regie']);}

		// Jahr validieren + sicher weitergeben
		if (empty($_POST['entry_jahr'])) {$jahrError = 'error';} 
		else {$entry_jahr = secure($_POST['entry_jahr']);}

		// Länge validieren + sicher weitergeben
		if (empty($_POST['entry_dauer'])) {$dauerError = 'error';} 
		else {$entry_dauer = secure($_POST['entry_dauer']);}

		// Cover validieren + sicher weitergeben
		if (empty($_POST['entry_cover'])) {$coverError = 'error';} 
		else {$entry_cover = secure($_POST['entry_cover']);}

		// Beschreibung validieren + sicher weitergeben
		if (empty($_POST['entry_description'])) {$descriptionError = 'error';} 
		else {$entry_description = secure($_POST['entry_description']);}

		// FSK durchgeben und definieren
		$entry_fsk = $_POST['entry_fsk'];

		// Durchgeben, ob die erweiterte Genre-Suche aktiviert war.
		$erweitert = $_POST['erweitert'];

		// Haupt- und Unterkategorie in die Datenbank schreiben
		// Zuerst fangen wir die Hauptkategorie ab. Die ist unsere Basis für die erweiterten Unterkategorien.
		// 
		$mainGenres = $_POST['hauptgenre'];
		foreach ($mainGenres as $key => $main):
			// Hier fangen wir erstmal alle Hauptkategorien ab und sichern uns diese als Array ab.
			$mainGenresAusgabe[] = $main;
			// Nun erstellen wir daraus ein multidimensionales Array, indem wir noch die jeweiligen 
			// Unterkategorien as Arrays daran hängen.
			// Unsere Unterkategorien haben immer einen eindeutigen Namen.
			// So haben Sie immer einen Prefix "sub-", darauffolgend der Hauptkategorie wo sie zugehören.
			// Damit fangen wir also alle Subkategorien ab, sobald dessen Hauptkategorie angeklickt wurde.
			$arr[$main] = $_POST['sub-'.$main];

			// Jetzt noch eine foreach-Schleife um lediglich die Unterkategorien zu bekommen und 
			// in ein gemeinsames Array für die Datenbank zu sichern.
			foreach($arr[$main] as $stuff):
				$subs[] = $stuff;
			endforeach;
		endforeach;

		// Nun noch ein schönes Format für unsere Datenbank imploden und dann ist es bereit für
		// den langen Weg in unsere Datenbank.
		$hauptgenreAusgabe = implode(", ", $mainGenresAusgabe);
		$subgenreAusgabe = implode(", ", $subs);

		if (empty($entry_title) || empty($entry_regie) || empty($entry_dauer) || empty($entry_jahr) || empty($entry_cover) || empty($entry_description)) {
			$fail = 'Bitte füllen Sie alle notwendigen Felder aus!';
			// Wenn die erweiterte Genre-Liste aktiviert war, ist die Variable true, ansonsten false.
			// Damit können wir dann in der Abfragen machen.
			$extend_check = (!empty($erweitert)) ? true : false;
		} else {
			mysql_query("INSERT INTO dvd (dvd_titel, dvd_regie, dvd_jahr, dvd_dauer, dvd_fsk, dvd_genre, dvd_subgenre, dvd_beschreibung, dvd_cover) VALUES ('".$entry_title."', '".$entry_regie."', '".$entry_jahr."', '".$entry_dauer."', '".$entry_fsk."', '".$hauptgenreAusgabe."', '".$subgenreAusgabe."', '".$entry_description."', '".$entry_cover."')");
			// Variablen wieder leeren
			$entry_title = $entry_description = $entry_regie = $entry_jahr = $entry_dauer = $entry_cover = $entry_fsk = "";
		}
	}
?>