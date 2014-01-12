<?php 
	include "inc/inc.php";
	include "inc/database.php";
	include "inc/add-entry.php";
	$abfrage = "SELECT * FROM dvd ORDER BY dvd_id DESC";
	$ergebnis = mysql_query($abfrage);
?>
<!doctype html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>
	<meta name="author" content="<?php echo $authors ?>">
	<meta name="date" content="<?php echo $last_mod ?>">
	<!-- <meta name="viewport" content="width=device-width"> -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dvd.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
</head>
<body>
	<header>
		<section class="innerwrap">
			<div id="search" class="left">
				<!-- <i class="fa fa-search fa-2x"></i> -->
				<!-- <input id="titel" name="search" type="text" placeholder="Titel">
				<input id="genre" type="text" placeholder="Genre">
				<input id="fsk" type="text" placeholder="FSK"> -->
			</div>
			<!-- Wenn die Funktion zum Hinzufügen von Einträgen nicht included wird, ist $add = false und dementsprechend wird dann die entsprechende Funktionalität aus dem Front End entfernt. Weil wer braucht schon einen Hinzufügen-Button wenn dieser keine Funktionalität hat? ;) LG Eduard -->
			<div id="add-item" class="<?php if($add == false) {echo ' deactivated';} ?>">
				<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#add">Film hinzufügen</button>
			</div>
		</section>
	</header>
	<section class="wrapper">
		<?php 
			while ($film = mysql_fetch_array($ergebnis)) {
				echo '<article class="dvd-element">';
				// echo '<img class="blur" src="'.$film["dvd_cover"].'" alt="" />';
				echo '<section class="innerwrap">
				<div class="cover"><img src="'.$film["dvd_cover"].'" alt="'.$film["dvd_titel"].'"></div>
				<div class="info">
				<h3 class="titel">'.$film["dvd_titel"].' <span class="jahr">('.$film["dvd_jahr"].')</span></h3>
				<p class="genre">'.$film["dvd_genre"].'</p>
				<p class="dauer">'.$film["dvd_dauer"].' Minuten</p>
				<p class="fsk">Ab '.$film["dvd_fsk"].' Jahren</p>
				</div></section></article>';
			} 
		?>
	</section>
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<!-- <script src="js/vague.js"></script>
	<script>
		var vague = $(".blur").Vague({
		  intensity:6, //blur intensity,
		  forceSVGUrl: false // force the absolute path to the svg filter
		});
		vague.blur();
	</script> -->
	<script>
		$(document).ready(function() {
			// PHP IM JS-CODE!
			// Hier wird geprüft, ob die Variable $fail definiert ist (bzw. existiert);
			// Wenn dies der Fall ist, wird der JS-Code ausgeführt.
			// Was macht der Code? Nichts besonderes.
			// Wenn das Formular validiert wurde und Einträge fehlen, dann wird das Modal-Window wieder aufgerufen,
			// sodass man die Validierung sieht.
			<?php if($fail != NULL) {echo "$('#add').modal('show')";} ?>
		});
	</script>
	<?php mysql_close($connect); ?>
	<!-- Modal für Eingabemaske um Film hinzuzufügen -->
	<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel">Film hinzufügen</h4>
	        <?php if($fail != NULL) { echo '<p class="error">'.$fail.'</p>'; } ?>
	      </div>
	      <div class="modal-body">
	      	<!-- Unsere Eingabemaske -->
	      	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
				<fieldset class="form-group">
					<label class="pflicht" for="entry_title">Titel</label><input type="text" value="<?php echo $entry_title; ?>" class="form-control <?php echo $titleError; ?>" name="entry_title">
					<label class="pflicht" for="entry_regie">Regie</label><input type="text" value="<?php echo $entry_regie; ?>" class="form-control <?php echo $regieError; ?>" name="entry_regie">
					<label class="pflicht" for="entry_jahr">Jahr</label><input type="text" value="<?php echo $entry_jahr; ?>" class="form-control <?php echo $jahrError; ?>" name="entry_jahr">
					<label class="pflicht" for="entry_dauer">Länge (in Minuten)</label><input type="text" value="<?php echo $entry_dauer; ?>" class="form-control <?php echo $dauerError; ?>" name="entry_dauer">
					<label for="entry_fsk">Altersbeschränkung (FSK)</label>
					<select name="entry_fsk" class="form-control">
						<!-- Falls $entry_fsk einer der abgefragten ist, wird die passende Option bei der Validierung als "selected" gesetzt, sodass man die Altersbeschränkung nicht doppelt auswählen muss. -->
						<option <?php if($entry_fsk == 0) { echo 'selected';} ?> value="0">ab 0 Jahren</option>
						<option <?php if($entry_fsk == 6) { echo 'selected';} ?> value="6">ab 6 Jahren</option>
						<option <?php if($entry_fsk == 12) { echo 'selected';} ?> value="12">ab 12 Jahren</option>
						<option <?php if($entry_fsk == 16) { echo 'selected';} ?> value="16">ab 16 Jahren</option>
						<option <?php if($entry_fsk == 18) { echo 'selected';} ?> value="18">ab 18 Jahren</option>
					</select>
					<label for="entry_genre">Genre (mehrere mit Kommatrennung)</label><input type="text" class="form-control" name="entry_genre">
					<label class="pflicht" for="entry_cover">Link zum Cover</label><input type="text" value="<?php echo $entry_cover; ?>" class="form-control <?php echo $coverError; ?>" name="entry_cover">
					<label class="pflicht" for="entry_description">Beschreibung</label><textarea class="form-control <?php echo $descriptionError; ?>" name="entry_description"><?php echo $entry_description ?></textarea>
				</fieldset>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
		        <input type="submit" name="speichern" class="btn btn-primary" value="Film hinzufügen &raquo;">
		      </div>
	      </form>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</body>
</html>