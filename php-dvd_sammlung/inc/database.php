<?php 
	$os = getenv("HTTP_USER_AGENT");
	$mysql_server 	= 'localhost';
	$mysql_user 	= 'root';
	$mysql_pass = (strpos($os, "Win") !== FALSE) ? "" : "root";
	$mysql_dbname 	= 'library_dvd';
	$dvds 			= simplexml_load_file("dvd.xml");

	// Verbindung zur Datenbank herstellen
	$connect = mysql_connect($mysql_server, $mysql_user, $mysql_pass) or die('Verbindung konnte nicht hergestellt werden!');

	// UTF-8 Fix. MAMP nervt manchmal und braucht dann einen kleinen Tritt in seinen Arsch – der fette Elefant eh.
	mysql_query("SET NAMES 'utf8'");

	// Funktion zum Überprüfen, ob eine Tabelle bereits existiert.
	// Dabei wird die PHP-Funktion mysql_num_rows verwendet um die Anzahl der Reihen in der Ausgabe zu liefern.
	// Im Idealfall sollte eine 1 ausgegeben werden (wenn die Tabelle existiert). Ansonsten ist es null oder >1.
	function check($table) {
		$cmd = mysql_query("SHOW TABLES LIKE '".$table."'");
		$result = mysql_num_rows($cmd);
		return $result;
	}

	// Erstellen eine Datenbank, die unsere Tabellen beinhalten soll.
	// Beim Befehl wird geprüft, ob die Datenbank bereit exisiert. Wenn nicht, wird sie erstellt.
	mysql_query("CREATE DATABASE IF NOT EXISTS " . $mysql_dbname);
	// Nun verbinden wir uns mit dieser Datenbank
	mysql_select_db($mysql_dbname, $connect) or die('Kein Datenbankzugriff!');

	// Die DVDs
	// --------
	// Wir prüfen, ob es eine Tabelle mit dem Namen "dvd" bereits gibt. Wenn nicht, erstellen wir diese und fügen Inhalte aus unserer XML hinzu.
	if (check("dvd") != 1) {
		mysql_query("CREATE TABLE dvd (dvd_id int(11) NOT NULL AUTO_INCREMENT, dvd_titel varchar(255) NOT NULL, dvd_regie varchar(255) NOT NULL, dvd_jahr int(4) NOT NULL, dvd_dauer int(3) NOT NULL, dvd_fsk int(2), dvd_imdb varchar(255), dvd_genre varchar(255) NOT NULL, dvd_beschreibung varchar(255), dvd_cover varchar(255), PRIMARY KEY (dvd_id)) default charset=utf8");
		foreach ($dvds as $dvd) {
			mysql_query("INSERT INTO dvd (dvd_titel, dvd_regie, dvd_jahr, dvd_dauer, dvd_fsk, dvd_imdb, dvd_genre, dvd_beschreibung, dvd_cover) VALUES ('".$dvd->titel."', '".$dvd->regie."', '".$dvd->jahr."', '".$dvd->dauer."', '".$dvd->fsk."', '".$dvd->imdb."', '".$dvd->genre."', '".$dvd->beschreibung."', '".$dvd->cover."')");
		}
	}
?>