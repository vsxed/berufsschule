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
	<!-- Modal für Eingabemaske um Film hinzuzufügen -->
	<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title" id="myModalLabel">Film hinzufügen</h4>
	        <!-- Wenn die Validierung etwas findet, was nicht passt, wird hier eine Fehlermeldung erstellt und unter dem Titel des Modals eingefügt. -->
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
					<label for="entry_genre">Genre <a href="#" class="toggle-all" id="untoggle-all">Alle untogglen</a> <fieldset class="inline right"><input type="checkbox" <?php if($extend_check == true) {echo 'checked';} ?> name="erweitert" id="erweitert"><label for="erweitert">Erweitert</label></fieldset></label>
					<fieldset class="entry_genre">
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" <?php if(in_array('Dokumentarfilm', $mainGenresAusgabe)) echo 'checked'; ?> id="Dokumentarfilm" value="Dokumentarfilm">
								<label for="Dokumentarfilm">Dokumentarfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Ereignisdokumentation" <?php if(in_array('Ereignisdokumentation', $subs)) echo 'checked'; ?> name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-1">
									<label for="sub-Dokumentarfilm-1">Ereignisdokumentation</label>
									<br>
									<input type="checkbox" value="Essay-Film" <?php if(in_array('Essay-Film', $subs)) echo 'checked'; ?> name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-2">
									<label for="sub-Dokumentarfilm-2">Essay-Film</label>
									<br>
									<input type="checkbox" value="Inszenierter Dokumentarfilm" <?php if(in_array('Inszenierter Dokumentarfilm', $subs)) echo 'checked'; ?> name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-3">
									<label for="sub-Dokumentarfilm-3">Inszenierter Dokumentarfilm</label>
									<br>
									<input type="checkbox" value="Investigativer Dokumentarfilm" <?php if(in_array('Investigativer Dokumentarfilm', $subs)) echo 'checked'; ?> name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-4">
									<label for="sub-Dokumentarfilm-4">Investigativer Dokumentarfilm</label>
									<br>
									<input type="checkbox" value="Kulturfilm" <?php if(in_array('Kulturfilm', $subs)) echo 'checked'; ?> name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-5">
									<label for="sub-Dokumentarfilm-5">Kulturfilm</label>
									<br>
									<input type="checkbox" value="Langzeitdokumentation" <?php if(in_array('Langzeitdokumentation', $subs)) echo 'checked'; ?> name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-6">
									<label for="sub-Dokumentarfilm-6">Langzeitdokumentation</label>
									<br>
									<input type="checkbox" value="Making-Of-Dokumentation" <?php if(in_array('Making-Of-Dokumentation', $subs)) echo 'checked'; ?> name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-7">
									<label for="sub-Dokumentarfilm-7">Making-Of-Dokumentation</label>
									<br>
									<input type="checkbox" value="Naturdokumentation" <?php if(in_array('Naturdokumentation', $subs)) echo 'checked'; ?> name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-8">
									<label for="sub-Dokumentarfilm-8">Naturdokumentation</label>
									<br>
									<input type="checkbox" value="Politische Dokumentation" <?php if(in_array('Politische Dokumentation', $subs)) echo 'checked'; ?> name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-9">
									<label for="sub-Dokumentarfilm-9">Politische Dokumentation</label>
									<br>
									<input type="checkbox" value="Reisedokumentation" <?php if(in_array('Reisedokumentation', $subs)) echo 'checked'; ?> name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-10">
									<label for="sub-Dokumentarfilm-10">Reisedokumentation</label>
									<br>
									<input type="checkbox" value="Sozialstudie" <?php if(in_array('Sozialstudie', $subs)) echo 'checked'; ?> name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-11">
									<label for="sub-Dokumentarfilm-11">Sozialstudie</label>
									<br>
									<input type="checkbox" value="Wissenschaftlicher Dokumentarfilm" <?php if(in_array('Wissenschaftlicher Dokumentarfilm', $subs)) echo 'checked'; ?> name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-12">
									<label for="sub-Dokumentarfilm-12">Wissenschaftlicher Dokumentarfilm</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" <?php if(in_array('Abenteuerfilm', $mainGenresAusgabe)) echo 'checked'; ?> name="hauptgenre[]" id="Abenteuerfilm" value="Abenteuerfilm">
								<label for="Abenteuerfilm">Abenteuerfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Mantel-und-Degen-Film" <?php if(in_array('Mantel-und-Degen-Film', $subs)) echo 'checked'; ?> name="sub-Abenteuerfilm[]" id="sub-Abenteuerfilm-1">
									<label for="sub-Abenteuerfilm-1">Mantel-und-Degen-Film</label>
									<br>
									<input type="checkbox" value="Piratenfilm" name="sub-Abenteuerfilm[]" <?php if(in_array('Piratenfilm', $subs)) echo 'checked'; ?> id="sub-Abenteuerfilm-2">
									<label for="sub-Abenteuerfilm-2">Piratenfilm</label>
									<br>
									<input type="checkbox" value="Ritterfilm" <?php if(in_array('Ritterfilm', $subs)) echo 'checked'; ?> name="sub-Abenteuerfilm[]" id="sub-Abenteuerfilm-3">
									<label for="sub-Abenteuerfilm-3">Ritterfilm</label>
									<br>
									<input type="checkbox" value="Schatzsucherfilm" <?php if(in_array('Schatzsucherfilm', $subs)) echo 'checked'; ?> name="sub-Abenteuerfilm[]" id="sub-Abenteuerfilm-4">
									<label for="sub-Abenteuerfilm-4">Schatzsucherfilm</label>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" <?php if(in_array('Actionfilm', $mainGenresAusgabe)) echo 'checked'; ?> id="Actionfilm" value="Actionfilm">
								<label for="Actionfilm">Actionfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Action-Superhelden-Film" <?php if(in_array('Action-Superhelden-Film', $subs)) echo 'checked'; ?> name="sub-Actionfilm[]" id="sub-Actionfilm-1">
									<label for="sub-Actionfilm-1">Action-Superhelden-Film</label>
									<br>
									<input type="checkbox" value="Agentenfilm" <?php if(in_array('Agentenfilm', $subs)) echo 'checked'; ?> name="sub-Actionfilm[]" id="sub-Actionfilm-2">
									<label for="sub-Actionfilm-2">Agentenfilm</label>
									<br>
									<input type="checkbox" value="Bad Cop" name="sub-Actionfilm[]" <?php if(in_array('Bad Cop', $subs)) echo 'checked'; ?> id="sub-Actionfilm-3">
									<label for="sub-Actionfilm-3">Bad Cop</label>
									<br>
									<input type="checkbox" value="Buddy Cop-Film" <?php if(in_array('Buddy Cop-Film', $subs)) echo 'checked'; ?> name="sub-Actionfilm[]" id="sub-Actionfilm-4">
									<label for="sub-Actionfilm-4">Buddy Cop-Film</label>
									<br>
									<input type="checkbox" value="Girls with Guns" <?php if(in_array('Girls with Guns', $subs)) echo 'checked'; ?> name="sub-Actionfilm[]" id="sub-Actionfilm-5">
									<label for="sub-Actionfilm-5">Girls with Guns</label>
									<br>
									<input type="checkbox" value="Heroic Bloodshed" <?php if(in_array('Heroic Bloodshed', $subs)) echo 'checked'; ?> name="sub-Actionfilm[]" id="sub-Actionfilm-6">
									<label for="sub-Actionfilm-6">Heroic Bloodshed</label>
									<br>
									<input type="checkbox" value="Militärfilm" <?php if(in_array('Militärfilm', $subs)) echo 'checked'; ?> name="sub-Actionfilm[]" id="sub-Actionfilm-7">
									<label for="sub-Actionfilm-7">Militärfilm</label>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" <?php if(in_array('Animationsfilm', $mainGenresAusgabe)) echo 'checked'; ?> id="Animationsfilm" value="Animationsfilm">
								<label for="Animationsfilm">Animationsfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Anime" <?php if(in_array('Anime', $subs)) echo 'checked'; ?> name="sub-Animationsfilm[]" id="sub-Animationsfilm-1">
									<label for="sub-Animationsfilm-1">Anime</label>
									<br>
									<input type="checkbox" value="Computeranimation" <?php if(in_array('Computeranimation', $subs)) echo 'checked'; ?> name="sub-Animationsfilm[]" id="sub-Animationsfilm-2">
									<label for="sub-Animationsfilm-2">Computeranimation</label>
									<br>
									<input type="checkbox" value="Klassischer Zeichentrick" <?php if(in_array('Klassischer Zeichentrick', $subs)) echo 'checked'; ?> name="sub-Animationsfilm[]" id="sub-Animationsfilm-3">
									<label for="sub-Animationsfilm-3">Klassischer Zeichentrick</label>
									<br>
									<input type="checkbox" value="Objektanimation" <?php if(in_array('Objektanimation', $subs)) echo 'checked'; ?> name="sub-Animationsfilm[]" id="sub-Animationsfilm-4">
									<label for="sub-Animationsfilm-4">Objektanimation</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" <?php if(in_array('Eastern', $mainGenresAusgabe)) echo 'checked'; ?> id="Eastern" value="Eastern">
								<label for="Eastern">Eastern</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Martial-Arts-Film" <?php if(in_array('Material-Arts-Film', $subs)) echo 'checked'; ?> name="sub-Eastern[]" id="sub-Eastern-1">
									<label for="sub-Eastern-1">Martial-Arts-Film</label>
									<br>
									<input type="checkbox" value="Ninjafilm" <?php if(in_array('Ninjafilm', $subs)) echo 'checked'; ?> name="sub-Eastern[]" id="sub-Eastern-2">
									<label for="sub-Eastern-2">Ninjafilm</label>
									<br>
									<input type="checkbox" value="Samuraifilm" <?php if(in_array('Samuraifilm', $subs)) echo 'checked'; ?> name="sub-Eastern[]" id="sub-Eastern-3">
									<label for="sub-Eastern-3">Samuraifilm</label>
									<br>
									<input type="checkbox" value="Wuxiafilm" <?php if(in_array('Wuxiafilm', $subs)) echo 'checked'; ?> name="sub-Eastern[]" id="sub-Eastern-4">
									<label for="sub-Eastern-4">Wuxiafilm</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" <?php if(in_array('Drama', $mainGenresAusgabe)) echo 'checked'; ?> id="Drama" value="Drama">
								<label for="Drama">Drama</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Biopic" <?php if(in_array('Biopic', $subs)) echo 'checked'; ?> name="sub-Drama[]" id="sub-Drama-1">
									<label for="sub-Drama-1">Biopic</label>
									<br>
									<input type="checkbox" value="Blaxploitation" <?php if(in_array('Blaxploitation', $subs)) echo 'checked'; ?> name="sub-Drama[]" id="sub-Drama-2">
									<label for="sub-Drama-2">Blaxploitation</label>
									<br>
									<input type="checkbox" value="Buddy-Film" <?php if(in_array('Buddy-Film', $subs)) echo 'checked'; ?> name="sub-Drama[]" id="sub-Drama-3">
									<label for="sub-Drama-3">Buddy-Film</label>
									<br>
									<input type="checkbox" value="Coming of Age-Film" <?php if(in_array('Coming of Age-Film', $subs)) echo 'checked'; ?> name="sub-Drama[]" id="sub-Drama-4">
									<label for="sub-Drama-4">Coming of Age-Film</label>
									<br>
									<input type="checkbox" value="Familiendrama" <?php if(in_array('Familiendrama', $subs)) echo 'checked'; ?> name="sub-Drama[]" id="sub-Drama-5">
									<label for="sub-Drama-5">Familiendrama</label>
									<br>
									<input type="checkbox" value="Gerechtigkeitsdrama" <?php if(in_array('Gerechtigkeitsdrama', $subs)) echo 'checked'; ?> name="sub-Drama[]" id="sub-Drama-6">
									<label for="sub-Drama-6">Gerechtigkeitsdrama</label>
									<br>
									<input type="checkbox" value="Heimatfilm" <?php if(in_array('Heimatfilm', $subs)) echo 'checked'; ?> name="sub-Drama[]" id="sub-Drama-7">
									<label for="sub-Drama-7">Heimatfilm</label>
									<br>
									<input type="checkbox" value="Liebesfilm" <?php if(in_array('Liebesfilm', $subs)) echo 'checked'; ?> name="sub-Drama[]" id="sub-Drama-8">
									<label for="sub-Drama-8">Liebesfilm</label>
									<br>
									<input type="checkbox" value="Politdrama" <?php if(in_array('Politdrama', $subs)) echo 'checked'; ?> name="sub-Drama[]" id="sub-Drama-9">
									<label for="sub-Drama-9">Politdrama</label>
									<br>
									<input type="checkbox" value="Psychodrama" <?php if(in_array('Psychodrama', $subs)) echo 'checked'; ?> name="sub-Drama[]" id="sub-Drama-10">
									<label for="sub-Drama-10">Psychodrama</label>
									<br>
									<input type="checkbox" value="Schicksalsdrama" <?php if(in_array('Schicksalsdrama', $subs)) echo 'checked'; ?> name="sub-Drama[]" id="sub-Drama-11">
									<label for="sub-Drama-11">Schicksalsdrama</label>
									<br>
									<input type="checkbox" value="Sozialdrama" <?php if(in_array('Sozialdrama', $subs)) echo 'checked'; ?> name="sub-Drama[]" id="sub-Drama-12">
									<label for="sub-Drama-12">Sozialdrama</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" <?php if(in_array('Erotikfilm', $mainGenresAusgabe)) echo 'checked'; ?> id="Erotikfilm" value="Erotikfilm">
								<label for="Erotikfilm">Erotikfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Aufklärungsfilm" <?php if(in_array('Aufklärungsfilm', $subs)) echo 'checked'; ?> name="sub-Erotikfilm[]" id="sub-Erotikfilm-1">
									<label for="sub-Erotikfilm-1">Aufklärungsfilm</label>
									<br>
									<input type="checkbox" value="Lederhosenfilm" <?php if(in_array('Lederhosenfilm', $subs)) echo 'checked'; ?> name="sub-Erotikfilm[]" id="sub-Erotikfilm-2">
									<label for="sub-Erotikfilm-2">Lederhosenfilm</label>
									<br>
									<input type="checkbox" value="Nudie-Film" <?php if(in_array('Nudie-Film', $subs)) echo 'checked'; ?> name="sub-Erotikfilm[]" id="sub-Erotikfilm-3">
									<label for="sub-Erotikfilm-3">Nudie-Film</label>
									<br>
									<input type="checkbox" value="Sex-Film" <?php if(in_array('Sex-Film', $subs)) echo 'checked'; ?> name="sub-Erotikfilm[]" id="sub-Erotikfilm-4">
									<label for="sub-Erotikfilm-4">Sex-Film</label>
									<br>
									<input type="checkbox" value="Sexploitation-Film" <?php if(in_array('Sexploitation-Film', $subs)) echo 'checked'; ?> name="sub-Erotikfilm[]" id="sub-Erotikfilm-5">
									<label for="sub-Erotikfilm-5">Sexploitation-Film</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" <?php if(in_array('Fantasyfilm', $mainGenresAusgabe)) echo 'checked'; ?> id="Fantasyfilm" value="Fantasyfilm">
								<label for="Fantasyfilm">Fantasyfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Bangsian Fantasy" <?php if(in_array('Bangsian Fantasy', $subs)) echo 'checked'; ?> name="sub-Fantasyfilm[]" id="sub-Fantasyfilm-1">
									<label for="sub-Fantasyfilm-1">Bangsian Fantasy</label>
									<br>
									<input type="checkbox" value="Gegenwartsfantasy" <?php if(in_array('Gegenwartsfantasy', $subs)) echo 'checked'; ?> name="sub-Fantasyfilm[]" id="sub-Fantasyfilm-2">
									<label for="sub-Fantasyfilm-2">Gegenwartsfantasy</label>
									<br>
									<input type="checkbox" value="High Fantasy" <?php if(in_array('High Fantasy', $subs)) echo 'checked'; ?> name="sub-Fantasyfilm[]" id="sub-Fantasyfilm-3">
									<label for="sub-Fantasyfilm-3">High Fantasy</label>
									<br>
									<input type="checkbox" value="Low Fantasy" <?php if(in_array('Low Fantasy', $subs)) echo 'checked'; ?> name="sub-Fantasyfilm[]" id="sub-Fantasyfilm-4">
									<label for="sub-Fantasyfilm-4">Low Fantasy</label>
									<br>
									<input type="checkbox" value="Märchenfilm" <?php if(in_array('Märchenfilm', $subs)) echo 'checked'; ?> name="sub-Fantasyfilm[]" id="sub-Fantasyfilm-5">
									<label for="sub-Fantasyfilm-5">Märchenfilm</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" <?php if(in_array('Historienfilm', $mainGenresAusgabe)) echo 'checked'; ?> id="Historienfilm" value="Historienfilm">
								<label for="Historienfilm">Historienfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Anti-Kriegsfilm" <?php if(in_array('Anti-Kriegsfilm', $subs)) echo 'checked'; ?> name="sub-Historienfilm[]" id="sub-Historienfilm-1">
									<label for="sub-Historienfilm-1">Anti-Kriegsfilm</label>
									<br>
									<input type="checkbox" value="Kriegsfilm" <?php if(in_array('Kriegsfilm', $subs)) echo 'checked'; ?> name="sub-Historienfilm[]" id="sub-Historienfilm-2">
									<label for="sub-Historienfilm-2">Kriegsfilm</label>
									<br>
									<input type="checkbox" value="Monumentalfilm" <?php if(in_array('Monumentalfilm', $subs)) echo 'checked'; ?> name="sub-Historienfilm[]" id="sub-Historienfilm-3">
									<label for="sub-Historienfilm-3">Monumentalfilm</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" <?php if(in_array('Horrorfilm', $mainGenresAusgabe)) echo 'checked'; ?> id="Horrorfilm" value="Horrorfilm">
								<label for="Horrorfilm">Horrorfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Monsterfilm" <?php if(in_array('Monsterfilm', $subs)) echo 'checked'; ?> name="sub-Horrorfilm[]" id="sub-Horrorfilm-1">
									<label for="sub-Horrorfilm-1">Monsterfilm</label>
									<br>
									<input type="checkbox" value="Okkulthorrorfilm" <?php if(in_array('Okkulthorrorfilm', $subs)) echo 'checked'; ?> name="sub-Horrorfilm[]" id="sub-Horrorfilm-2">
									<label for="sub-Horrorfilm-2">Okkulthorrorfilm</label>
									<br>
									<input type="checkbox" value="Slasherfilm" <?php if(in_array('Slasherfilm', $subs)) echo 'checked'; ?> name="sub-Horrorfilm[]" id="sub-Horrorfilm-3">
									<label for="sub-Horrorfilm-3">Slasherfilm</label>
									<br>
									<input type="checkbox" value="Splatterfilm" <?php if(in_array('Splatterfilm', $subs)) echo 'checked'; ?> name="sub-Horrorfilm[]" id="sub-Horrorfilm-4">
									<label for="sub-Horrorfilm-4">Splatterfilm</label>
									<br>
									<input type="checkbox" value="Spukhausfilm" <?php if(in_array('Spukhausfilm', $subs)) echo 'checked'; ?> name="sub-Horrorfilm[]" id="sub-Horrorfilm-5">
									<label for="sub-Horrorfilm-5">Spukhausfilm</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" <?php if(in_array('Komödie', $mainGenresAusgabe)) echo 'checked'; ?> id="Komödie" value="Komödie">
								<label for="Komödie">Komödie</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Erotikkomödie" <?php if(in_array('Erotikkomödie', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-1">
									<label for="sub-Komödie-1">Erotikkomödie</label>
									<br>
									<input type="checkbox" value="Familienkomödie" <?php if(in_array('Familienkomödie', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-2">
									<label for="sub-Komödie-2">Familienkomödie</label>
									<br>
									<input type="checkbox" value="Gaunerkomödie" <?php if(in_array('Gaunerkomödie', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-3">
									<label for="sub-Komödie-3">Gaunerkomödie</label>
									<br>
									<input type="checkbox" value="Gross-Out-Film" <?php if(in_array('Gross-Out-Film', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-4">
									<label for="sub-Komödie-4">Gross-Out-Film</label>
									<br>
									<input type="checkbox" value="Groteske" <?php if(in_array('Groteske', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-5">
									<label for="sub-Komödie-5">Groteske</label>
									<br>
									<input type="checkbox" value="Horrorkomödie" <?php if(in_array('Horrorkomödie', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-6">
									<label for="sub-Komödie-6">Horrorkomödie</label>
									<br>
									<input type="checkbox" value="Klamaukfilm" <?php if(in_array('Klamaukfilm', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-7">
									<label for="sub-Komödie-7">Klamaukfilm</label>
									<br>
									<input type="checkbox" value="Krimikomödie" <?php if(in_array('Krimikomödie', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-8">
									<label for="sub-Komödie-8">Krimikomödie</label>
									<br>
									<input type="checkbox" value="Parodie" <?php if(in_array('Parodie', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-9">
									<label for="sub-Komödie-9">Parodie</label>
									<br>
									<input type="checkbox" value="Romantische Komödie" <?php if(in_array('Romantische Komödie', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-10">
									<label for="sub-Komödie-10">Romantische Komödie</label>
									<br>
									<input type="checkbox" value="Satire" <?php if(in_array('Satire', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-11">
									<label for="sub-Komödie-11">Satire</label>
									<br>
									<input type="checkbox" value="Schwarze Komödie" <?php if(in_array('Schwarze Komödie', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-12">
									<label for="sub-Komödie-12">Schwarze Komödie</label>
									<br>
									<input type="checkbox" value="Screwball-Komödie" <?php if(in_array('Screwball-Komödie', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-13">
									<label for="sub-Komödie-13">Screwball-Komödie</label>
									<br>
									<input type="checkbox" value="Slapstickkomödie" <?php if(in_array('Slapstickkomödie', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-14">
									<label for="sub-Komödie-14">Slapstickkomödie</label>
									<br>
									<input type="checkbox" value="Teenie-Komödie" <?php if(in_array('Teenie-Komödie', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-15">
									<label for="sub-Komödie-15">Teenie-Komödie</label>
									<br>
									<input type="checkbox" value="Tragikomödie" <?php if(in_array('Tragikomödie', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-16">
									<label for="sub-Komödie-16">Tragikomödie</label>
									<br>
									<input type="checkbox" value="Verwechslungskomödie" <?php if(in_array('Verwechslungskomödie', $subs)) echo 'checked'; ?> name="sub-Komödie[]" id="sub-Komödie-17">
									<label for="sub-Komödie-17">Verwechslungskomödie</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" <?php if(in_array('Katastrophenfilm', $mainGenresAusgabe)) echo 'checked'; ?> id="Katastrophenfilm" value="Katastrophenfilm">
								<label for="Katastrophenfilm">Katastrophenfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Naturkatastrophe" <?php if(in_array('Naturkatastrophe', $subs)) echo 'checked'; ?> name="sub-Katastrophenfilm[]" id="sub-Katastrophenfilm-1">
									<label for="sub-Katastrophenfilm-1">Naturkatastrophe</label>
									<br>
									<input type="checkbox" value="Terrorismus" <?php if(in_array('Terrorismus', $subs)) echo 'checked'; ?> name="sub-Katastrophenfilm[]" id="sub-Katastrophenfilm-2">
									<label for="sub-Katastrophenfilm-2">Terrorismus</label>
									<br>
									<input type="checkbox" value="Unglücksfilm" <?php if(in_array('Unglücksfilm', $subs)) echo 'checked'; ?> name="sub-Katastrophenfilm[]" id="sub-Katastrophenfilm-3">
									<label for="sub-Katastrophenfilm-3">Unglücksfilm</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" <?php if(in_array('Kriminalfilm', $mainGenresAusgabe)) echo 'checked'; ?> id="Kriminalfilm" value="Kriminalfilm">
								<label for="Kriminalfilm">Kriminalfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Detektivfilm" <?php if(in_array('Detektivfilm', $subs)) echo 'checked'; ?> name="sub-Kriminalfilm[]" id="sub-Kriminalfilm-1">
									<label for="sub-Kriminalfilm-1">Detektivfilm</label>
									<br>
									<input type="checkbox" value="Film Noir" <?php if(in_array('Film Noir', $subs)) echo 'checked'; ?> name="sub-Kriminalfilm[]" id="sub-Kriminalfilm-2">
									<label for="sub-Kriminalfilm-2">Film Noir</label>
									<br>
									<input type="checkbox" value="Gangsterfilm" <?php if(in_array('Gangsterfilm', $subs)) echo 'checked'; ?> name="sub-Kriminalfilm[]" id="sub-Kriminalfilm-3">
									<label for="sub-Kriminalfilm-3">Gangsterfilm</label>
									<br>
									<input type="checkbox" value="Mafiafilm" <?php if(in_array('Mafiafilm', $subs)) echo 'checked'; ?> name="sub-Kriminalfilm[]" id="sub-Kriminalfilm-4">
									<label for="sub-Kriminalfilm-4">Mafiafilm</label>
									<br>
									<input type="checkbox" value="Polizeifilm" <?php if(in_array('Polizeifilm', $subs)) echo 'checked'; ?> name="sub-Kriminalfilm[]" id="sub-Kriminalfilm-5">
									<label for="sub-Kriminalfilm-5">Polizeifilm</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" <?php if(in_array('Musikfilm', $mainGenresAusgabe)) echo 'checked'; ?> id="Musikfilm" value="Musikfilm">
								<label for="Musikfilm">Musikfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Konzert" <?php if(in_array('Konzert', $subs)) echo 'checked'; ?> name="sub-Musikfilm[]" id="sub-Musikfilm-1">
									<label for="sub-Musikfilm-1">Konzert</label>
									<br>
									<input type="checkbox" value="Musical" <?php if(in_array('Musical', $subs)) echo 'checked'; ?> name="sub-Musikfilm[]" id="sub-Musikfilm-2">
									<label for="sub-Musikfilm-2">Musical</label>
									<br>
									<input type="checkbox" value="Tanzfilm" <?php if(in_array('Tanzfilm', $subs)) echo 'checked'; ?> name="sub-Musikfilm[]" id="sub-Musikfilm-3">
									<label for="sub-Musikfilm-3">Tanzfilm</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" <?php if(in_array('SciFi', $mainGenresAusgabe)) echo 'checked'; ?> id="SciFi" value="SciFi">
								<label for="SciFi">SciFi</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Apokalypse" <?php if(in_array('Apokalypse', $subs)) echo 'checked'; ?> name="sub-SciFi[]" id="sub-SciFi-1">
									<label for="sub-SciFi-1">Apokalypse</label>
									<br>
									<input type="checkbox" value="Cyberpunk" <?php if(in_array('Cyberpunk', $subs)) echo 'checked'; ?> name="sub-SciFi[]" id="sub-SciFi-2">
									<label for="sub-SciFi-2">Cyberpunk</label>
									<br>
									<input type="checkbox" value="Hard SF" <?php if(in_array('Hard SF', $subs)) echo 'checked'; ?> name="sub-SciFi[]" id="sub-SciFi-3">
									<label for="sub-SciFi-3">Hard SF</label>
									<br>
									<input type="checkbox" value="Retro SF" <?php if(in_array('Retro SF', $subs)) echo 'checked'; ?> name="sub-SciFi[]" id="sub-SciFi-4">
									<label for="sub-SciFi-4">Retro SF</label>
									<br>
									<input type="checkbox" value="Space Opera" <?php if(in_array('Space Opera', $subs)) echo 'checked'; ?> name="sub-SciFi[]" id="sub-SciFi-5">
									<label for="sub-SciFi-5">Space Opera</label>
									<br>
									<input type="checkbox" value="Utopie" <?php if(in_array('Utopie', $subs)) echo 'checked'; ?> name="sub-SciFi[]" id="sub-SciFi-6">
									<label for="sub-SciFi-6">Utopie</label>
									<br>
									<input type="checkbox" value="Zeitreise-Film" <?php if(in_array('Zeitreise-Film', $subs)) echo 'checked'; ?> name="sub-SciFi[]" id="sub-SciFi-7">
									<label for="sub-SciFi-7">Zeitreise-Film</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" <?php if(in_array('Thriller', $mainGenresAusgabe)) echo 'checked'; ?> id="Thriller" value="Thriller">
								<label for="Thriller">Thriller</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Erotikthriller" <?php if(in_array('Erotikthriller', $subs)) echo 'checked'; ?> name="sub-Thriller[]" id="sub-Thriller-1">
									<label for="sub-Thriller-1">Erotikthriller</label>
									<br>
									<input type="checkbox" value="Mysterythriller" <?php if(in_array('Mysterythriller', $subs)) echo 'checked'; ?> name="sub-Thriller[]" id="sub-Thriller-2">
									<label for="sub-Thriller-2">Mysterythriller</label>
									<br>
									<input type="checkbox" value="Politthriller" <?php if(in_array('Politthriller', $subs)) echo 'checked'; ?> name="sub-Thriller[]" id="sub-Thriller-3">
									<label for="sub-Thriller-3">Politthriller</label>
									<br>
									<input type="checkbox" value="Psychothriller" <?php if(in_array('Psychothriller', $subs)) echo 'checked'; ?> name="sub-Thriller[]" id="sub-Thriller-4">
									<label for="sub-Thriller-4">Psychothriller</label>
									<br>
									<input type="checkbox" value="Verschwörungsthriller" <?php if(in_array('Verschwörungsthriller', $subs)) echo 'checked'; ?> name="sub-Thriller[]" id="sub-Thriller-5">
									<label for="sub-Thriller-5">Verschwörungsthriller</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
					</fieldset>
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