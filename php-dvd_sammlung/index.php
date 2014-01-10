<?php 
	include "inc/inc.php";
	include "inc/database.php";
	include "inc/add-entry.php";
	$abfrage = "SELECT * FROM dvd";
	$ergebnis = mysql_query($abfrage);
?>
<!doctype html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>
	<meta name="author" content="<?php echo $authors ?>">
	<meta name="date" content="<?php echo $last_mod ?>">
	<meta name="viewport" content="width=device-width">
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
				echo '<article class="dvd-element">
				<img class="blur" src="'.$film["dvd_cover"].'" alt="" />
				<section class="innerwrap">
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
	<script src="js/vague.js"></script>
	<script>
		var vague = $(".blur").Vague({
		  intensity:6, //blur intensity,
		  forceSVGUrl: false // force the absolute path to the svg filter
		});
		vague.blur();
	</script>
	<?php mysql_close($connect); ?>
	<!-- Modal für Eingabemasek um Film hinzuzufügen -->
	<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel">Film hinzufügen</h4>
	      </div>
	      <div class="modal-body">
	      	<!-- Unsere Eingabemaske -->
	      	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
				<fieldset class="form-group">
					<label for="entry_title">Titel</label><input type="text" class="form-control <?php echo $titleError; ?>" name="entry_title">
					<label for="entry_regie">Regie</label><input type="text" class="form-control <?php echo $regieError; ?>" name="entry_regie">
					<label for="entry_jahr">Jahr</label><input type="text" class="form-control <?php echo $jahrError; ?>" name="entry_jahr">
					<label for="entry_dauer">Länge</label><input type="text" class="form-control <?php echo $dauerError; ?>" name="entry_dauer">
					<label for="entry_fsk">Altersbeschränkung</label><input type="text"class="form-control"  name="entry_fsk">
					<label for="entry_genre">Genre</label><input type="text" class="form-control" name="entry_genre">
					<label for="entry_cover">Link zum Cover</label><input type="text" class="form-control <?php echo $coverError; ?>" name="entry_cover">
					<label for="entry_description">Beschreibung</label><textarea class="form-control <?php echo $descriptionError; ?>" name="entry_description"></textarea>
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