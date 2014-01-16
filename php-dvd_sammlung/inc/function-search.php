<?php 
	// Variable, die nur in dieser PHP-Datei definiert wird.
	// Funktionsweise ersichtlich in der function-add.php (die ersten paar Zeilen).
	$search = true;

	$query = urldecode($_GET['query']);
	$type = $_GET['type'];

	if ($type == 'title') {
		$searchquery = mysql_query('SELECT * FROM dvd WHERE dvd_titel LIKE \'%'.$query.'%\'');
	}
	else if ($type == 'genre') {
		$searchquery = mysql_query('SELECT * FROM dvd WHERE dvd_genre LIKE \'%'.$query.'%\'');
	}
	else if ($type == 'fsk') {
		$searchquery = mysql_query('SELECT * FROM dvd WHERE dvd_fsk LIKE \'%'.$query.'%\'');
	}

	$num_query = mysql_num_rows($searchquery);
?>