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
				echo '<img class="blur" src="'.$film["dvd_cover"].'" alt="" />';
				echo '<section class="innerwrap">
				<div class="cover"><img class="cover-img" src="'.$film["dvd_cover"].'" alt="'.$film["dvd_titel"].'"><img class="fsk" src="img/fsk-'.$film["dvd_fsk"].'.png" alt="FSK '.$film["dvd_fsk"].'" /></div>
				<div class="info">
				<h3 class="titel">'.$film["dvd_titel"].' <span class="jahr">('.$film["dvd_jahr"].')</span></h3>
				<p class="genre">'.$film["dvd_genre"].'</p>
				<p class="dauer">'.$film["dvd_dauer"].' Minuten</p>
				<p class="description">'.$film["dvd_beschreibung"].'</p>
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
	<script>
		$(document).ready(function() {
			// PHP IM JS-CODE!
			// Hier wird geprüft, ob die Variable $fail definiert ist (bzw. existiert);
			// Wenn dies der Fall ist, wird der JS-Code ausgeführt.
			// Was macht der Code? Nichts besonderes.
			// Wenn das Formular validiert wurde und Einträge fehlen, dann wird das Modal-Window wieder aufgerufen,
			// sodass man die Validierung sieht.
			<?php if($fail != NULL) {echo "$('#add').modal('show')";} ?>
			// 
			// (c) by Eduard Mayer
			// 12. Januar 2014
			// Genre-List Selector
			// 
			// Variblen definieren -> Genres und Subgenres, Erweitert-Checkbox
			var $genre 		= $('.entry_genre .genre-wrap > input');
			var $genreWrap 	= $('.entry_genre .genre-wrap');
			var $subGenreWrapper = $('.entry_genre .genre-wrap .subgenre') ;
			var $subGenre 	= $('.entry_genre .genre-wrap .subgenre input') ;
			var $extended 	= $('#erweitert');
			var $untoggle	= $('#untoggle-all');

			$extended.on('click', function() {
				if( $extended.prop('checked') == true) {
					$genreWrap.addClass('extend');
					$subGenreWrapper.show();
				} else {
					$genreWrap.removeClass('extend');
					$subGenreWrapper.hide();
					$subGenre.prop('checked', false);
				}
			});

			// Für den Fall, wenn die Validierung zuschlägt und uns das Formular zurückbringt.
			// So erinnert es sich wenigstens dann auch die Unterkategorien anzuzeigen.
			if( $extended.prop('checked') == true) {
				$genreWrap.addClass('extend');
				$subGenreWrapper.show();
			}

			$subGenreWrapper.each(function() {
				$(this).children('input').on('click', function(){
					if($(this).prop('checked') == true) {
						$(this).closest('.genre-wrap').children('input').prop({
							checked: true
						});
					} else if ($(this).parent('.subgenre').children('input:checked').length == 0 ) {
						$(this).closest('.genre-wrap').children('input').prop({
							checked: false
						});
					}
				});
			});

			// Beim Klick auf unseren Untoggle-Button werden alle Checkboxen unchecked.
			$untoggle.on('click', function(){
				// Alle Input/Checkbox Elemente innerhalb des Fieldsets mit der Klasse "entry_gerne" werden ungechecked.
				// So werden Sie auch nicht per $_POST weitergegeben.
				// Referenz: http://api.jquery.com/prop/#prop-propertyName-value
				$('.entry_genre input[type=checkbox]').prop({
					checked: false
				});
				// Damit der Browser nicht beim Klick nach oben springt
				return false;
			});
		});
	</script>
	<?php mysql_close($connect); ?>
	<?php include "inc/template-add-entry.php"; ?>
</body>
</html>