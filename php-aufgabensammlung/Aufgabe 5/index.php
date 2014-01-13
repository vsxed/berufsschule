<!doctype html>
<?php include '../inc.php'; ?>
<?php 
	// Alle relevaten Daten zur Verbindung um die Datenbank auszulesen als Variablen definieren.
	$mysql_server 	= "localhost";
	$mysql_user 	= "root";
	$mysql_password = "root";
	$mysql_db 		= "schueler_db";

	// Verbindung zum Server als Variable definieren
	$connect = mysql_connect($mysql_server, $mysql_user, $mysql_password) or die("Keine Verbindung zum Server!");

	// Verbindung zur Datenbank herstellen
	mysql_select_db($mysql_db, $connect) or die("Datenbank nicht gefunden");

	$tabelle = "schueler";
	$sql_result = mysql_query("SELECT * FROM $tabelle);

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
	<section>
		<?php 
			while($schueler = mysql_fetch_array($sql_result)){
	
			$vorname = $schueler['vorname'];
			$nachname = $schueler['nachname'];
			$klasse = $schueler['klasse'];

			echo '<p>
					Vorname: '.$vorname.'<br>
					Nachname: '.$nachname.'<br>
					Klasse: '.$klasse.'
				  </p>';
			}

			mysql_close($connect);
		?>
	</section>
</body>
</html>