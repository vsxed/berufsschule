<!doctype html>
<?php include '../inc.php'; ?>
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
		#form {
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
	</style>
</head>
<body>
	<section id="form">
		<h1>Teilen Sie Ihre Erfahrung mit uns!</h1>
		<p>Füllen Sie einfach das Formular aus und teilen Sie Ihre Erfahrung mit uns und allen anderen!</p>
		<form action="process.php" method="post">
			<fieldset class="radio">
				<input type="radio" value="Frau" name="gender" id="women">
				<label for="women">Frau</label>
			</fieldset>
			<fieldset class="radio">
				<input type="radio" value="Herr" name="gender" id="men">
				<label for="men">Herr</label>
			</fieldset>
			<fieldset>
				<label for="vorname">Vorname</label>
				<input name="vorname" type="text">
			</fieldset>
			<fieldset>
				<label for="nachname">Nachname</label>
				<input name="nachname" type="text">
			</fieldset>
			<fieldset>
				<label for="bericht">Dein Urlaubserlebnis</label>
				<textarea name="bericht"></textarea>
			</fieldset>
			<fieldset class="checkbox">
				<legend>Welche Ziele würdest du noch gerne bereisen?</legend>
				<input value="Mazedonien" name="checkbox-list[]" type="checkbox" id="input-1">
				<label for="input-1">Mazedonien</label>
				<br>
				<input value="Spanien" name="checkbox-list[]" type="checkbox" id="input-2">
				<label for="input-2">Spanien</label>
				<br>
				<input value="England" name="checkbox-list[]" type="checkbox" id="input-3">
				<label for="input-3">England</label>
				<br>
				<input value="Mesopotanien" name="checkbox-list[]" type="checkbox" id="input-4">
				<label for="input-4">Mesopotanien</label>
				<br>
				<input value="Malediven" name="checkbox-list[]" type="checkbox" id="input-5">
				<label for="input-5">Malediven</label>
				<br>
				<input value="Russland" name="checkbox-list[]" type="checkbox" id="input-6">
				<label for="input-6">Russland</label>
				<br>
				<input value="USA" name="checkbox-list[]" type="checkbox" id="input-7">
				<label for="input-7">USA</label>
			</fieldset>
			<input type="submit" value="Absenden">
		</form>
	</section>
</body>
</html>