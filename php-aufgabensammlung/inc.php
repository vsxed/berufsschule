<?php 
	// Title und Letzte Bearbeitungszeit für jede Datei erstellen 
	$dirname 	= basename(dirname($_SERVER['PHP_SELF'])); 
	$file 		= basename($_SERVER['PHP_SELF']);
	$last_mod 	= date("d.m.Y, H:i:s", getlastmod());

	// Wenn es sich bei der aktuellen Datei um einen Ausgabeprozess handelt, dann soll der Titel etwas verändert ausgegeben werden
	$title = ($file == 'process.php') ? 'Ausgabe (' . $dirname . ')' : $dirname;

	// ---

	// Config.xml einlesen
	$config 	= "../config.xml";
	$configXML 	= simplexml_load_file($config);

	// Config-Variablen erzeugen
	// Zuerst die Autoren
	$xmlAuthors = (array)$configXML->authors;
	// Nun die Klasse
	$xmlClass 	= (array)$configXML->class;
	$metAutor	= implode(", ", $xmlAuthors['name']);
	$metClass 	= implode(", ", $xmlClass);
	// Schön zusammenfassen und ausgeben
	$authors 	= $metAutor . ', ' . $metClass;
?>