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
				<i class="fa fa-search fa-2x"></i>
				<input id="search" name="search" type="text" placeholder="Suchbegriff eingeben">
			</div>
			<div id="add-item" class="right">
				<i class="fa fa-plus fa-2x"></i>
			</div>
		</section>
	</header>
	<section class="wrapper">
		<?php 
			while ($film = mysql_fetch_array($ergebnis)) {
				echo '<article class="dvd-element">';
				// echo '<img class="blur" src="'.$film["dvd_cover"].'" alt="" />';
				echo '<section class="innerwrap">';
				echo '<div class="cover"><img src="'.$film["dvd_cover"].'" alt="'.$film["dvd_titel"].'"></div>';
				echo '<div class="info">';
				echo '<h3 class="titel">'.$film["dvd_titel"].' <span class="jahr">('.$film["dvd_jahr"].')</span></h3>';
				echo '<p class="genre">'.$film["dvd_genre"].'</p>';
				echo '<p class="dauer">'.$film["dvd_dauer"].' Minuten</p>';
				echo '<p class="fsk">Ab '.$film["dvd_fsk"].' Jahren</p>';
				echo '</div></section></article>';
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