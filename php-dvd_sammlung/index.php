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
				}
			});
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
				// Alle Input/Checkbox Elemente innerhalb des Fieldsets mit der Klasse "entry_gerne" ungechecked
				// Referenz: http://api.jquery.com/prop/#prop-propertyName-value
				$('.entry_genre input[type=checkbox]').prop({
					checked: false,
					readonly: false
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
					<label for="entry_genre">Genre <a href="#" class="toggle-all" id="untoggle-all">Alle untogglen</a> <fieldset class="inline right"><input type="checkbox" name="erweitert" id="erweitert"><label for="erweitert">Erweitert</label></fieldset></label>
					<fieldset class="entry_genre">
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" id="Abenteuerfilm" value="Abenteuerfilm">
								<label for="Abenteuerfilm">Abenteuerfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Mantel-und-Degen-Film" name="sub-Abenteuerfilm[]" id="sub-Abenteuerfilm-1">
									<label for="sub-Abenteuerfilm-1">Mantel-und-Degen-Film</label>
									<br>
									<input type="checkbox" value="Piratenfilm" name="sub-Abenteuerfilm[]" id="sub-Abenteuerfilm-2">
									<label for="sub-Abenteuerfilm-2">Piratenfilm</label>
									<br>
									<input type="checkbox" value="Ritterfilm" name="sub-Abenteuerfilm[]" id="sub-Abenteuerfilm-3">
									<label for="sub-Abenteuerfilm-3">Ritterfilm</label>
									<br>
									<input type="checkbox" value="Schatzsucherfilm" name="sub-Abenteuerfilm[]" id="sub-Abenteuerfilm-4">
									<label for="sub-Abenteuerfilm-4">Schatzsucherfilm</label>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" id="Actionfilm" value="Actionfilm">
								<label for="Actionfilm">Actionfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Action-Superhelden-Film" name="sub-Actionfilm[]" id="sub-Actionfilm-1">
									<label for="sub-Actionfilm-1">Action-Superhelden-Film</label>
									<br>
									<input type="checkbox" value="Agentenfilm" name="sub-Actionfilm[]" id="sub-Actionfilm-2">
									<label for="sub-Actionfilm-2">Agentenfilm</label>
									<br>
									<input type="checkbox" value="Bad Cop" name="sub-Actionfilm[]" id="sub-Actionfilm-3">
									<label for="sub-Actionfilm-3">Bad Cop</label>
									<br>
									<input type="checkbox" value="Buddy Cop-Film" name="sub-Actionfilm[]" id="sub-Actionfilm-4">
									<label for="sub-Actionfilm-4">Buddy Cop-Film</label>
									<br>
									<input type="checkbox" value="Girls with Guns" name="sub-Actionfilm[]" id="sub-Actionfilm-5">
									<label for="sub-Actionfilm-5">Girls with Guns</label>
									<br>
									<input type="checkbox" value="Heroic Bloodshed" name="sub-Actionfilm[]" id="sub-Actionfilm-6">
									<label for="sub-Actionfilm-6">Heroic Bloodshed</label>
									<br>
									<input type="checkbox" value="Militärfilm" name="sub-Actionfilm[]" id="sub-Actionfilm-7">
									<label for="sub-Actionfilm-7">Militärfilm</label>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" id="Animationsfilm" value="Animationsfilm">
								<label for="Animationsfilm">Animationsfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Anime" name="sub-Animationsfilm[]" id="sub-Animationsfilm-1">
									<label for="sub-Animationsfilm-1">Anime</label>
									<br>
									<input type="checkbox" value="Computeranimation" name="sub-Animationsfilm[]" id="sub-Animationsfilm-2">
									<label for="sub-Animationsfilm-2">Computeranimation</label>
									<br>
									<input type="checkbox" value="Klassischer Zeichentrick" name="sub-Animationsfilm[]" id="sub-Animationsfilm-3">
									<label for="sub-Animationsfilm-3">Klassischer Zeichentrick</label>
									<br>
									<input type="checkbox" value="Objektanimation" name="sub-Animationsfilm[]" id="sub-Animationsfilm-4">
									<label for="sub-Animationsfilm-4">Objektanimation</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" id="Dokumentarfilm" value="Dokumentarfilm">
								<label for="Dokumentarfilm">Dokumentarfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Ereignisdokumentation" name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-1">
									<label for="sub-Dokumentarfilm-1">Ereignisdokumentation</label>
									<br>
									<input type="checkbox" value="Essay-Film" name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-2">
									<label for="sub-Dokumentarfilm-2">Essay-Film</label>
									<br>
									<input type="checkbox" value="Inszenierter Dokumentarfilm" name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-3">
									<label for="sub-Dokumentarfilm-3">Inszenierter Dokumentarfilm</label>
									<br>
									<input type="checkbox" value="Investigativer Dokumentarfilm" name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-4">
									<label for="sub-Dokumentarfilm-4">Investigativer Dokumentarfilm</label>
									<br>
									<input type="checkbox" value="Kulturfilm" name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-5">
									<label for="sub-Dokumentarfilm-5">Kulturfilm</label>
									<br>
									<input type="checkbox" value="Langzeitdokumentation" name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-6">
									<label for="sub-Dokumentarfilm-6">Langzeitdokumentation</label>
									<br>
									<input type="checkbox" value="Making-Of-Dokumentation" name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-7">
									<label for="sub-Dokumentarfilm-7">Making-Of-Dokumentation</label>
									<br>
									<input type="checkbox" value="Naturdokumentation" name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-8">
									<label for="sub-Dokumentarfilm-8">Naturdokumentation</label>
									<br>
									<input type="checkbox" value="Politische Dokumentation" name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-9">
									<label for="sub-Dokumentarfilm-9">Politische Dokumentation</label>
									<br>
									<input type="checkbox" value="Reisedokumentation" name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-10">
									<label for="sub-Dokumentarfilm-10">Reisedokumentation</label>
									<br>
									<input type="checkbox" value="Sozialstudie" name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-11">
									<label for="sub-Dokumentarfilm-11">Sozialstudie</label>
									<br>
									<input type="checkbox" value="Wissenschaftlicher Dokumentarfilm" name="sub-Dokumentarfilm[]" id="sub-Dokumentarfilm-12">
									<label for="sub-Dokumentarfilm-12">Wissenschaftlicher Dokumentarfilm</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" id="Drama" value="Drama">
								<label for="Drama">Drama</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Biopic" name="sub-Drama[]" id="sub-Drama-1">
									<label for="sub-Drama-1">Biopic</label>
									<br>
									<input type="checkbox" value="Blaxploitation" name="sub-Drama[]" id="sub-Drama-2">
									<label for="sub-Drama-2">Blaxploitation</label>
									<br>
									<input type="checkbox" value="Buddy-Film" name="sub-Drama[]" id="sub-Drama-3">
									<label for="sub-Drama-3">Buddy-Film</label>
									<br>
									<input type="checkbox" value="Coming of Age-Film" name="sub-Drama[]" id="sub-Drama-4">
									<label for="sub-Drama-4">Coming of Age-Film</label>
									<br>
									<input type="checkbox" value="Familiendrama" name="sub-Drama[]" id="sub-Drama-5">
									<label for="sub-Drama-5">Familiendrama</label>
									<br>
									<input type="checkbox" value="Gerechtigkeitsdrama" name="sub-Drama[]" id="sub-Drama-6">
									<label for="sub-Drama-6">Gerechtigkeitsdrama</label>
									<br>
									<input type="checkbox" value="Heimatfilm" name="sub-Drama[]" id="sub-Drama-7">
									<label for="sub-Drama-7">Heimatfilm</label>
									<br>
									<input type="checkbox" value="Liebesfilm" name="sub-Drama[]" id="sub-Drama-8">
									<label for="sub-Drama-8">Liebesfilm</label>
									<br>
									<input type="checkbox" value="Politdrama" name="sub-Drama[]" id="sub-Drama-9">
									<label for="sub-Drama-9">Politdrama</label>
									<br>
									<input type="checkbox" value="Psychodrama" name="sub-Drama[]" id="sub-Drama-10">
									<label for="sub-Drama-10">Psychodrama</label>
									<br>
									<input type="checkbox" value="Schicksalsdrama" name="sub-Drama[]" id="sub-Drama-11">
									<label for="sub-Drama-11">Schicksalsdrama</label>
									<br>
									<input type="checkbox" value="Sozialdrama" name="sub-Drama[]" id="sub-Drama-12">
									<label for="sub-Drama-12">Sozialdrama</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" id="Eastern" value="Eastern">
								<label for="Eastern">Eastern</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Martial-Arts-Film" name="sub-Eastern[]" id="sub-Eastern-1">
									<label for="sub-Eastern-1">Martial-Arts-Film</label>
									<br>
									<input type="checkbox" value="Ninjafilm" name="sub-Eastern[]" id="sub-Eastern-2">
									<label for="sub-Eastern-2">Ninjafilm</label>
									<br>
									<input type="checkbox" value="Samuraifilm" name="sub-Eastern[]" id="sub-Eastern-3">
									<label for="sub-Eastern-3">Samuraifilm</label>
									<br>
									<input type="checkbox" value="Wuxiafilm" name="sub-Eastern[]" id="sub-Eastern-4">
									<label for="sub-Eastern-4">Wuxiafilm</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" id="Erotikfilm" value="Erotikfilm">
								<label for="Erotikfilm">Erotikfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Aufklärungsfilm" name="sub-Erotikfilm[]" id="sub-Erotikfilm-1">
									<label for="sub-Erotikfilm-1">Aufklärungsfilm</label>
									<br>
									<input type="checkbox" value="Lederhosenfilm" name="sub-Erotikfilm[]" id="sub-Erotikfilm-2">
									<label for="sub-Erotikfilm-2">Lederhosenfilm</label>
									<br>
									<input type="checkbox" value="Nudie-Film" name="sub-Erotikfilm[]" id="sub-Erotikfilm-3">
									<label for="sub-Erotikfilm-3">Nudie-Film</label>
									<br>
									<input type="checkbox" value="Sex-Film" name="sub-Erotikfilm[]" id="sub-Erotikfilm-4">
									<label for="sub-Erotikfilm-4">Sex-Film</label>
									<br>
									<input type="checkbox" value="Sexploitation-Film" name="sub-Erotikfilm[]" id="sub-Erotikfilm-5">
									<label for="sub-Erotikfilm-5">Sexploitation-Film</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" id="Fantasyfilm" value="Fantasyfilm">
								<label for="Fantasyfilm">Fantasyfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Bangsian Fantasy" name="sub-Fantasyfilm[]" id="sub-Fantasyfilm-1">
									<label for="sub-Fantasyfilm-1">Bangsian Fantasy</label>
									<br>
									<input type="checkbox" value="Gegenwartsfantasy" name="sub-Fantasyfilm[]" id="sub-Fantasyfilm-2">
									<label for="sub-Fantasyfilm-2">Gegenwartsfantasy</label>
									<br>
									<input type="checkbox" value="High Fantasy" name="sub-Fantasyfilm[]" id="sub-Fantasyfilm-3">
									<label for="sub-Fantasyfilm-3">High Fantasy</label>
									<br>
									<input type="checkbox" value="Low Fantasy" name="sub-Fantasyfilm[]" id="sub-Fantasyfilm-4">
									<label for="sub-Fantasyfilm-4">Low Fantasy</label>
									<br>
									<input type="checkbox" value="Märchenfilm" name="sub-Fantasyfilm[]" id="sub-Fantasyfilm-5">
									<label for="sub-Fantasyfilm-5">Märchenfilm</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" id="Historienfilm" value="Historienfilm">
								<label for="Historienfilm">Historienfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Anti-Kriegsfilm" name="sub-Historienfilm[]" id="sub-Historienfilm-1">
									<label for="sub-Historienfilm-1">Anti-Kriegsfilm</label>
									<br>
									<input type="checkbox" value="Kriegsfilm" name="sub-Historienfilm[]" id="sub-Historienfilm-2">
									<label for="sub-Historienfilm-2">Kriegsfilm</label>
									<br>
									<input type="checkbox" value="Monumentalfilm" name="sub-Historienfilm[]" id="sub-Historienfilm-3">
									<label for="sub-Historienfilm-3">Monumentalfilm</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" id="Horrorfilm" value="Horrorfilm">
								<label for="Horrorfilm">Horrorfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Monsterfilm" name="sub-Horrorfilm[]" id="sub-Horrorfilm-1">
									<label for="sub-Horrorfilm-1">Monsterfilm</label>
									<br>
									<input type="checkbox" value="Okkulthorrorfilm" name="sub-Horrorfilm[]" id="sub-Horrorfilm-2">
									<label for="sub-Horrorfilm-2">Okkulthorrorfilm</label>
									<br>
									<input type="checkbox" value="Slasherfilm" name="sub-Horrorfilm[]" id="sub-Horrorfilm-3">
									<label for="sub-Horrorfilm-3">Slasherfilm</label>
									<br>
									<input type="checkbox" value="Splatterfilm" name="sub-Horrorfilm[]" id="sub-Horrorfilm-4">
									<label for="sub-Horrorfilm-4">Splatterfilm</label>
									<br>
									<input type="checkbox" value="Spukhausfilm" name="sub-Horrorfilm[]" id="sub-Horrorfilm-5">
									<label for="sub-Horrorfilm-5">Spukhausfilm</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" id="Katastrophenfilm" value="Katastrophenfilm">
								<label for="Katastrophenfilm">Katastrophenfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Naturkatastrophe" name="sub-Katastrophenfilm[]" id="sub-Katastrophenfilm-1">
									<label for="sub-Katastrophenfilm-1">Naturkatastrophe</label>
									<br>
									<input type="checkbox" value="Terrorismus" name="sub-Katastrophenfilm[]" id="sub-Katastrophenfilm-2">
									<label for="sub-Katastrophenfilm-2">Terrorismus</label>
									<br>
									<input type="checkbox" value="Unglücksfilm" name="sub-Katastrophenfilm[]" id="sub-Katastrophenfilm-3">
									<label for="sub-Katastrophenfilm-3">Unglücksfilm</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" id="Komödie" value="Komödie">
								<label for="Komödie">Komödie</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Erotikkomödie" name="sub-Komödie[]" id="sub-Komödie-1">
									<label for="sub-Komödie-1">Erotikkomödie</label>
									<br>
									<input type="checkbox" value="Familienkomödie" name="sub-Komödie[]" id="sub-Komödie-2">
									<label for="sub-Komödie-2">Familienkomödie</label>
									<br>
									<input type="checkbox" value="Gaunerkomödie" name="sub-Komödie[]" id="sub-Komödie-3">
									<label for="sub-Komödie-3">Gaunerkomödie</label>
									<br>
									<input type="checkbox" value="Gross-Out-Film" name="sub-Komödie[]" id="sub-Komödie-4">
									<label for="sub-Komödie-4">Gross-Out-Film</label>
									<br>
									<input type="checkbox" value="Groteske" name="sub-Komödie[]" id="sub-Komödie-5">
									<label for="sub-Komödie-5">Groteske</label>
									<br>
									<input type="checkbox" value="Horrorkomödie" name="sub-Komödie[]" id="sub-Komödie-6">
									<label for="sub-Komödie-6">Horrorkomödie</label>
									<br>
									<input type="checkbox" value="Klamaukfilm" name="sub-Komödie[]" id="sub-Komödie-7">
									<label for="sub-Komödie-7">Klamaukfilm</label>
									<br>
									<input type="checkbox" value="Krimikomödie" name="sub-Komödie[]" id="sub-Komödie-8">
									<label for="sub-Komödie-8">Krimikomödie</label>
									<br>
									<input type="checkbox" value="Parodie" name="sub-Komödie[]" id="sub-Komödie-9">
									<label for="sub-Komödie-9">Parodie</label>
									<br>
									<input type="checkbox" value="Romantische Komödie" name="sub-Komödie[]" id="sub-Komödie-10">
									<label for="sub-Komödie-10">Romantische Komödie</label>
									<br>
									<input type="checkbox" value="Satire" name="sub-Komödie[]" id="sub-Komödie-11">
									<label for="sub-Komödie-11">Satire</label>
									<br>
									<input type="checkbox" value="Schwarze Komödie" name="sub-Komödie[]" id="sub-Komödie-12">
									<label for="sub-Komödie-12">Schwarze Komödie</label>
									<br>
									<input type="checkbox" value="Screwball-Komödie" name="sub-Komödie[]" id="sub-Komödie-13">
									<label for="sub-Komödie-13">Screwball-Komödie</label>
									<br>
									<input type="checkbox" value="Slapstickkomödie" name="sub-Komödie[]" id="sub-Komödie-14">
									<label for="sub-Komödie-14">Slapstickkomödie</label>
									<br>
									<input type="checkbox" value="Teenie-Komödie" name="sub-Komödie[]" id="sub-Komödie-15">
									<label for="sub-Komödie-15">Teenie-Komödie</label>
									<br>
									<input type="checkbox" value="Tragikomödie" name="sub-Komödie[]" id="sub-Komödie-16">
									<label for="sub-Komödie-16">Tragikomödie</label>
									<br>
									<input type="checkbox" value="Verwechslungskomödie" name="sub-Komödie[]" id="sub-Komödie-17">
									<label for="sub-Komödie-17">Verwechslungskomödie</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" id="Kriminalfilm" value="Kriminalfilm">
								<label for="Kriminalfilm">Kriminalfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Detektivfilm" name="sub-Kriminalfilm[]" id="sub-Kriminalfilm-1">
									<label for="sub-Kriminalfilm-1">Detektivfilm</label>
									<br>
									<input type="checkbox" value="Film Noir" name="sub-Kriminalfilm[]" id="sub-Kriminalfilm-2">
									<label for="sub-Kriminalfilm-2">Film Noir</label>
									<br>
									<input type="checkbox" value="Gangsterfilm" name="sub-Kriminalfilm[]" id="sub-Kriminalfilm-3">
									<label for="sub-Kriminalfilm-3">Gangsterfilm</label>
									<br>
									<input type="checkbox" value="Mafiafilm" name="sub-Kriminalfilm[]" id="sub-Kriminalfilm-4">
									<label for="sub-Kriminalfilm-4">Mafiafilm</label>
									<br>
									<input type="checkbox" value="Polizeifilm" name="sub-Kriminalfilm[]" id="sub-Kriminalfilm-5">
									<label for="sub-Kriminalfilm-5">Polizeifilm</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" id="Musikfilm" value="Musikfilm">
								<label for="Musikfilm">Musikfilm</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Konzert" name="sub-Musikfilm[]" id="sub-Musikfilm-1">
									<label for="sub-Musikfilm-1">Konzert</label>
									<br>
									<input type="checkbox" value="Musical" name="sub-Musikfilm[]" id="sub-Musikfilm-2">
									<label for="sub-Musikfilm-2">Musical</label>
									<br>
									<input type="checkbox" value="Tanzfilm" name="sub-Musikfilm[]" id="sub-Musikfilm-3">
									<label for="sub-Musikfilm-3">Tanzfilm</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" id="SciFi" value="SciFi">
								<label for="SciFi">SciFi</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Apokalypse" name="sub-SciFi[]" id="sub-SciFi-1">
									<label for="sub-SciFi-1">Apokalypse</label>
									<br>
									<input type="checkbox" value="Cyberpunk" name="sub-SciFi[]" id="sub-SciFi-2">
									<label for="sub-SciFi-2">Cyberpunk</label>
									<br>
									<input type="checkbox" value="Hard SF" name="sub-SciFi[]" id="sub-SciFi-3">
									<label for="sub-SciFi-3">Hard SF</label>
									<br>
									<input type="checkbox" value="Retro SF" name="sub-SciFi[]" id="sub-SciFi-4">
									<label for="sub-SciFi-4">Retro SF</label>
									<br>
									<input type="checkbox" value="Space Opera" name="sub-SciFi[]" id="sub-SciFi-5">
									<label for="sub-SciFi-5">Space Opera</label>
									<br>
									<input type="checkbox" value="Utopie" name="sub-SciFi[]" id="sub-SciFi-6">
									<label for="sub-SciFi-6">Utopie</label>
									<br>
									<input type="checkbox" value="Zeitreise-Film" name="sub-SciFi[]" id="sub-SciFi-7">
									<label for="sub-SciFi-7">Zeitreise-Film</label>
									<br>
								</fieldset>
							</fieldset>
							<!--  -->
							<fieldset class="genre-wrap">
								<input type="checkbox" name="hauptgenre[]" id="Thriller" value="Thriller">
								<label for="Thriller">Thriller</label>
								<fieldset class="subgenre">
									<input type="checkbox" value="Erotikthriller" name="sub-Thriller[]" id="sub-Thriller-1">
									<label for="sub-Thriller-1">Erotikthriller</label>
									<br>
									<input type="checkbox" value="Mysterythriller" name="sub-Thriller[]" id="sub-Thriller-2">
									<label for="sub-Thriller-2">Mysterythriller</label>
									<br>
									<input type="checkbox" value="Politthriller" name="sub-Thriller[]" id="sub-Thriller-3">
									<label for="sub-Thriller-3">Politthriller</label>
									<br>
									<input type="checkbox" value="Psychothriller" name="sub-Thriller[]" id="sub-Thriller-4">
									<label for="sub-Thriller-4">Psychothriller</label>
									<br>
									<input type="checkbox" value="Verschwörungsthriller" name="sub-Thriller[]" id="sub-Thriller-5">
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