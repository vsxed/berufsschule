<!-- Modal für Eingabemaske um Film zu suchen -->
	<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog search">
	    <div class="modal-content">
	    	<form action="<?php echo $_SERVER["PHP_SELF"]?>" method="GET">
	      <div class="modal-header">
	        <fieldset class="invis-radio">
	        	<input type="radio" name="type" id="filmtitle" checked value="title">
		        <label for="filmtitle">Filmtitel </label>
		        <input type="radio" name="type" data-extend="0" id="filmgenre" value="genre">
		        <label for="filmgenre"><abbr title="Mit einem Klick kannst du zwischen Genre und Subgenre wechseln">Genre</abbr> </label>
		        <input type="radio" name="type" id="filmfsk" value="fsk">
		        <label for="filmfsk">Altersbeschränkung</label>
	        </fieldset>
	      </div>
	      <div class="modal-body">
	      	<!-- Unsere Eingabemaske -->
			  	<fieldset>
			  		<input type="text" class="form-control" name="query" placeholder="Wähle oben aus, wonach du suchen willst und gib hier deinen Suchbegriff ein…">
			  	</fieldset>
			  	<div class="genre-help">
			  		<a href="#" class="blue" id="genre-help-toggle"><small>Brauchst du Hilfe bei der Genre-Auswahl?</small></a>
			  		<div class="genre-help-container">
			  			<small>Klicke einfach auf ein Genre um es ins Feld zu schreiben.</small>
			  			<ul class="choose-from-list list-unstyled list-inline">
			  				<li class="headliner"><strong>Abenteuerfilm</strong></li>
			  				<li>Mantel-und-Degen-Film</li>
			  				<li>Piratenfilm</li>
			  				<li>Ritterfilm</li>
			  				<li>Schatzsucherfilm</li>
			  			</ul>
			  			<ul class="choose-from-list list-unstyled list-inline">
			  				<li class="headliner"><strong>Actionfilm</strong></li>
			  				<li>Action-Superhelden-Film</li>
							<li>Agentenfilm</li>
							<li>Bad Cop</li>
							<li>Buddy Cop-Film</li>
							<li>Girls with Guns</li>
							<li>Heroic Bloodshed</li>
							<li>Militärfilm</li>
			  			</ul>
			  			<ul class="choose-from-list list-unstyled list-inline">
			  				<li class="headliner"><strong>Animationsfilm</strong></li>
			  				<li>Anime</li>
			  				<li>Computeranimation</li>
			  				<li>Klassischer Zeichentrick</li>
			  				<li>Objektanimation</li>
			  			</ul>
			  			<ul class="choose-from-list list-unstyled list-inline">
			  				<li class="headliner"><strong>Dokumentarfilm</strong></li>
			  				<li>Ereignisdokumentation</li>
							<li>Essay-Film</li>
							<li>Inszenierter Dokumentarfilm</li>
							<li>Investigativer Dokumentarfilm</li>
							<li>Kulturfilm</li>
							<li>Langzeitdokumentation</li>
							<li>Making-Of-Dokumentation</li>
							<li>Naturdokumentation</li>
							<li>Politische Dokumentation</li>
							<li>Reisedokumentation</li>
							<li>Sozialstudie</li>
							<li>Wissenschaftlicher Dokumentarfilm</li>
			  			</ul>
			  			<ul class="choose-from-list list-unstyled list-inline">
			  				<li class="headliner"><strong>Drama</strong></li>
			  				<li>Biopic</li>
							<li>Blaxploitation</li>
							<li>Buddy-Film</li>
							<li>Coming of Age-Film</li>
							<li>Familiendrama</li>
							<li>Gerechtigkeitsdrama</li>
							<li>Heimatfilm</li>
							<li>Liebesfilm</li>
							<li>Politdrama</li>
							<li>Psychodrama</li>
							<li>Schicksalsdrama</li>
							<li>Sozialdrama</li>
			  			</ul>
			  			<ul class="choose-from-list list-unstyled list-inline">
			  				<li class="headliner"><strong>Eastern</strong></li>
			  				<li>Martial-Arts-Film</li>
			  				<li>Ninjafilm</li>
			  				<li>Samuraifilm</li>
			  				<li>Wuxiafilm</li>
			  			</ul>
			  			<ul class="choose-from-list list-unstyled list-inline">
			  				<li class="headliner"><strong>Erotikfilm</strong></li>
			  				<li>Aufklärungsfilm</li>
							<li>Lederhosenfilm</li>
							<li>Nudie-Film</li>
							<li>Sex-Film</li>
							<li>Sexploitation-Film</li>
			  			</ul>
			  			<ul class="choose-from-list list-unstyled list-inline">
			  				<li class="headliner"><strong>Fantasyfilm</strong></li>
			  				<li>Bangsian Fantasy</li>
							<li>Gegenwartsfantasy</li>
							<li>High Fantasy</li>
							<li>Low Fantasy</li>
							<li>Märchenfilm</li>
			  			</ul>
			  			<ul class="choose-from-list list-unstyled list-inline">
			  				<li class="headliner"><strong>Horrorfilm</strong></li>
			  				<li>Monsterfilm</li>
							<li>Okkulthorrorfilm</li>
							<li>Slasherfilm</li>
							<li>Splatterfilm</li>
							<li>Spukhausfilm</li>
			  			</ul>
			  			<ul class="choose-from-list list-unstyled list-inline">
			  				<li class="headliner"><strong>Katastrophenfilm</strong></li>
			  				<li>Naturkatastrophe</li>
			  				<li>Terrorismus</li>
			  				<li>Unglücksfilm</li>
			  			</ul>
			  			<ul class="choose-from-list list-unstyled list-inline">
			  				<li class="headliner"><strong>Komödie</strong></li>
			  				<li>Erotikkomödie</li>
							<li>Familienkomödie</li>
							<li>Gaunerkomödie</li>
							<li>Gross-Out-Film</li>
							<li>Groteske</li>
							<li>Horrorkomödie</li>
							<li>Klamaukfilm</li>
							<li>Krimikomödie</li>
							<li>Parodie</li>
							<li>Romantische Komödie</li>
							<li>Satire</li>
							<li>Schwarze Komödie</li>
							<li>Screwball-Komödie</li>
							<li>Slapstickkomödie</li>
							<li>Teenie-Komödie</li>
							<li>Tragikomödie</li>
							<li>Verwechslungskomödie</li>
			  			</ul>
			  			<ul class="choose-from-list list-unstyled list-inline">
			  				<li class="headliner"><strong>Kriminalfilm</strong></li>
			  				
			  			</ul>
			  			<ul class="choose-from-list list-unstyled list-inline">
			  				<li class="headliner"><strong>Erotikfilm</strong></li>
			  				<li>Detektivfilm</li>
			  				<li>Film Noir</li>
			  				<li>Gangsterfilm</li>
			  				<li>Mafiafilm</li>
			  				<li>Polizeifilm</li>
			  			</ul>
			  			<ul class="choose-from-list list-unstyled list-inline">
			  				<li class="headliner"><strong>Musikfilm</strong></li>
			  				<li>Konzert</li>
			  				<li>Musical</li>
			  				<li>Tanzfilm</li>
			  			</ul>
			  			<ul class="choose-from-list list-unstyled list-inline">
			  				<li class="headliner"><strong>SciFi</strong></li>
			  				<li>Apokalypse</li>
							<li>Cyberpunk</li>
							<li>Hard SF</li>
							<li>Retro SF</li>
							<li>Space Opera</li>
							<li>Utopie</li>
							<li>Zeitreise-Film</li>
			  			</ul>
			  			<ul class="choose-from-list list-unstyled list-inline">
			  				<li class="headliner"><strong>Thriller</strong></li>
							<li>Erotikthriller</li>
							<li>Mysterythriller</li>
							<li>Politthriller</li>
							<li>Psychothriller</li>
							<li>Verschwörungsthriller</li>
			  			</ul>
			  		</div>
			  	</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
		        <input type="submit" class="btn btn-primary" value="Film suchen &raquo;">
		      </div>
		    </form>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->