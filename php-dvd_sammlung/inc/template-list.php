<?php 
	function makelist($target) {
		echo '<article class="dvd-element">';
		echo '<img class="blur" src="'.$target["dvd_cover"].'" alt="" />';
		echo '<section class="innerwrap">
		<div class="cover"><img class="cover-img" src="'.$target["dvd_cover"].'" alt="'.$target["dvd_titel"].'"><img class="fsk" src="img/fsk-'.$target["dvd_fsk"].'.png" alt="FSK '.$target["dvd_fsk"].'" /></div>
		<div class="info">
		<h3 class="titel">'.$target["dvd_titel"].' <span class="jahr">('.$target["dvd_jahr"].')</span></h3>
		<p class="genre">'.$target["dvd_genre"].'</p>
		<p class="dauer">'.$target["dvd_dauer"].' Minuten</p>
		<p class="description">'.$target["dvd_beschreibung"].'</p>
		</div></section></article>';
	}

?>