<!doctype html>
<?php include '../inc.php'; ?>
<?php 
	$staedte = array(
		"Deutschland"	=> "Berlin",
		"Schweiz"		=> "Bern",
		"Italien"		=> "Rom",
		"Niederlande"	=> "Den Haag",
		"Frankreich"	=> "Paris",
		"England"		=> "London",
		"Spanien"		=> "Madrid"
	);
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
		table {
			width: 100%;
			text-align: left;
		}
		table th {
			text-decoration: underline;
			line-height: 2;
			vertical-align: top;
		}
	</style>
</head>
<body>
	<section id="form">
		<h1><?php echo $title ?></h1>
		<p>Hier wird das Array als Tabelle ausgegeben:</p>
	</section>
	<section>
		<table>
			<tr>
				<th>Land</th>
				<th>Hauptstadt</th>
			</tr>
			<?php 
				foreach ($staedte as $land => $stadt) {
					echo '<tr><td>' . $land . '</td><td>' . $stadt . '</td></tr>';
				}
			?>
		</table>
	</section>
</body>
</html>