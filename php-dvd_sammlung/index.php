<?php 
	include "inc/inc.php";
	include "inc/database.php";
	include "inc/function-add.php";
	include "inc/function-search.php";
	include "inc/template-list.php";
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
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dvd.css">
</head>
<body>
	<header>
		<section class="innerwrap">
			<!-- Wenn die Funktion zum Hinzufügen von Einträgen nicht included wird, ist $add = false oder $search = false und dementsprechend wird dann die entsprechende Funktionalität aus dem Front End entfernt. Weil wer braucht schon einen Hinzufügen-Button wenn dieser keine Funktionalität hat? ;) LG Eduard -->
			<div id="search-item" style="margin-right: 10px;" class="left<?php if($search == false) {echo ' deactivated';} ?>">
				<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#search">Suchen</button>
			</div>
			<div id="add-item" class="<?php if($add == false) {echo ' deactivated';} ?>">
				<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#add">Film hinzufügen</button>
			</div>
		</section>
	</header>
	<section class="wrapper">
		<?php 
			if ($_GET['type'] == NULL) {
				while ($film = mysql_fetch_array($ergebnis)) {
					makelist($film);
				} 
			} else {
				$textprefix = 'Die Suche nach <strong class="blue">'.$query.'</strong> in der Kategorie <strong>'.$typetext.'</strong> ergab ';

				if($num_query != 0) {
					echo '	<section class="padding innerwrap">
							<a href="index.php" class="btn btn-default">&laquo; Zurück zum Index</a>
							<p class="lead">'.$textprefix.$num_query.' Treffer.</p>
							</section>';
				} else {
					echo '	<section class="padding innerwrap">
							<a href="index.php" class="btn btn-default">&laquo; Zurück zum Index</a>
							<p class="lead">'.$textprefix.'leider nichts.</p>
							<img class="not-found" src="img/sad-robot.png" alt="Sad Robot" />
							</section>';
				}

				while ($suche = mysql_fetch_array($searchquery)) {
					makelist($suche);
				}
			}
		?>
	</section>
	<script src="js/jquery.min.js"></script>
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
			// sodass man die Validierung sieht und Daten ergänzen kann.
			<?php if($fail != NULL) {echo "$('#add').modal('show')";} ?>

			// (c) by Eduard Mayer
			// 12. Januar 2014
			// 
			// Genre-List Selector
			// Genre-List Untoggler
			// Suchkategorie-Wechsler
			// Suchkategorien-Input
			// 
			// Variblen definieren -> Genres und Subgenres, Erweitert-Checkbox
			var $genre 		= $('.entry_genre .genre-wrap > input');
			var $genreWrap 	= $('.entry_genre .genre-wrap');
			var $subGenreWrapper = $('.entry_genre .genre-wrap .subgenre') ;
			var $subGenre 	= $('.entry_genre .genre-wrap .subgenre input') ;
			var $extended 	= $('#erweitert');
			var $untoggle	= $('#untoggle-all');
			var $genreInput = $('label[for=filmgenre]');

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

			// Mechanik zur Suche von Unterkategorien (Subgenres)
			// data-extend ist unser data-Attribut, welches die Mechanik kontrolliert.
			// 1 = Subgenre, 2 = Genre, 0 = Reset (Genre, vorher nicht gecheckt)
			// Bei Klick wird deren Text in das Input-Feld geschrieben
			$genreInput.on('click', function() {
				var $input = $(this).prev();
				var $chooseHeader = $('.choose-from-list li.headliner');
				var $chooseSubs = $('.choose-from-list li').not($chooseHeader);

				// Funktion um den Text des angeklickten Objekts in das Suchfeld zu schreiben (hardcoded, sorry)
				function returnVal() {
					var $sfield = $('input[name="query"]');
					var text = $(this).text();
					$sfield.val(text);
				}

				$('.genre-help').fadeIn();
				if($input.attr('data-extend') == 0) {
					$input.attr('data-extend', 2);
					$('.genre-help-container').addClass('genre-only');
					$chooseHeader.on('click', returnVal);
				}
				else if ($input.attr('data-extend') == 2) {
					$input.attr({'data-extend': 1, 'value': 'subgenre'}).change();
					$(this).children('abbr').text('Subgenre');
					$('.genre-help-container').removeClass('genre-only');
					$chooseSubs.on('click', returnVal);
					$chooseHeader.on('click', function(){$('input[name="query"]').val('');});
				} 
				else {
					$input.attr({'data-extend': 2, 'value': 'genre'}).change();
					$(this).children('abbr').text('Genre');
					$('.genre-help-container').addClass('genre-only');
					$chooseHeader.on('click', returnVal);
				}
			});
			// Beim Wechsel zu Titel oder FSK soll Genre wieder zum Genre wechseln, wenn es zB davor Subgenre war.
			$('#filmtitle, #filmfsk').change(function(){
				$('#filmgenre').attr({'data-extend': 0, 'value': 'genre'}).next('label').children('abbr').text('Genre');
				$('input[name="query"]').val('');
				$('.genre-help').fadeOut();
				$('.genre-help-container').hide();
			});
			// Genre Hilfe Container Mechanik
			var $genreToggle = $('#genre-help-toggle');
			var $genreContainer = $('.genre-help-container');

			$genreToggle.on('click', function(){
				$genreContainer.fadeToggle();
			});
		});
	</script>
	<?php mysql_close($connect); ?>
	<?php if($add == true) {include "inc/template-add-entry.php";} ?>
	<?php if($search == true) {include "inc/template-search-entry.php";} ?>
</body>
</html>