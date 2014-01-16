<?php 
	// Dazugehöriges Template: 
	// ---- template-search-entry.php

	// Variable, die nur in dieser PHP-Datei definiert wird.
	// Funktionsweise ersichtlich in der function-add.php (die ersten paar Zeilen).
	$search = true;

	// Nach dem getten muss erstmal wieder urldecoded werden (aus + werden Leerzeichen, etc)
	// Normalerweise müsste man ja auch noch Umlaute safen, jedoch scheint der Chrome das auch so interpretieren zu können, nice.
	$query = urldecode($_GET['query']);
	$type = $_GET['type'];

	// Kategorisierung und definition der Variable für die Tabelle anhand der Userauswahl der Suchkategorie
	if 		($type == 'title') 		{$spalte = 'dvd_titel'; $typetext = 'Filmtitel';}	// Suche nach Titel
	else if ($type == 'genre') 		{$spalte = 'dvd_genre'; $typetext = 'Genre';}	// Suche nach Hauptgenre
	else if ($type == 'subgenre') 	{$spalte = 'dvd_subgenre'; $typetext = 'Subgenre';} // Suche nach Subgenre
	else if ($type == 'fsk') 		{$spalte = 'dvd_fsk'; $typetext = 'Altersbeschränkung';}		// Suche nach FSK

	// Das ist dann unsere Suchanfrage an unsere Datenbank
	$searchquery = mysql_query('SELECT * FROM dvd WHERE '.$spalte.' LIKE \'%'.$query.'%\'');
	// Ergenisse werden auch noch gezählt.
	$num_query = mysql_num_rows($searchquery);
?>