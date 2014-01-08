<?php 
	include "inc/inc.php";
	include "inc/database.php";
	$abfrage = "SELECT * FROM dvd";
	$ergebnis = mysql_query($abfrage);
	// Connection-close hinzufügen!
?>
<!doctype html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>
	<meta name="author" content="<?php echo $authors ?>">
	<meta name="date" content="<?php echo $last_mod ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="css/dvd.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
</head>
<body>
	<header>
		<section class="innerwrap">
			<div id="search" class="left">
				<!-- <i class="fa fa-search fa-2x"></i> -->
				<input id="titel" name="search" type="text" placeholder="Titel">
				<input id="genre" type="text" placeholder="Genre">
				<input id="fsk" type="text" placeholder="FSK">
			</div>
			<!-- <div id="add-item" class="right">
				<i class="fa fa-plus fa-2x"></i>
			</div> -->
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
	<script src="//code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="js/vague.js"></script>
	<script>
		var vague = $(".blur").Vague({
		  intensity:6, //blur intensity,
		  forceSVGUrl: false // force the absolute path to the svg filter
		});
		vague.blur();
	</script>
</body>
</html>