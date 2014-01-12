<?php 
	// Wir setzen hier eine Variable auf "true".
	// Damit können wir dann später das Front End per PHP kontrollieren.
	// Es soll später schauen, ob die Funktion auch included wurde – wenn nicht, wird die Variable automatisch auf "false" gesetzt, da sie ohne die passende Funktions-PHP nicht definiert wird.
	$add = true;

	// Funktion bekannt aus Aufgabe 3-3 der Aufgabensammlung.
	function secure($string) {
		$string = trim($string);
	    $string = stripslashes($string);
	    $string = htmlspecialchars($string);
	    return $string;
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") { 
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
	}
?>