<!-- Modal für Eingabemaske um Film hinzuzufügen -->
	<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog search">
	    <div class="modal-content">
	    	<form action="<?php echo $_SERVER["PHP_SELF"]?>" method="GET">
	      <div class="modal-header">
	        <fieldset class="invis-radio">
	        	<input type="radio" name="type" id="filmtitle" checked value="title">
		        <label for="filmtitle">Filmtitel </label>
		        <input type="radio" name="type" id="filmgenre" value="genre">
		        <label for="filmgenre">Genre </label>
		        <input type="radio" name="type" id="filmfsk" value="fsk">
		        <label for="filmfsk">Altersbeschränkung</label>
	        </fieldset>
	        <!-- Wenn die Validierung etwas findet, was nicht passt, wird hier eine Fehlermeldung erstellt und unter dem Titel des Modals eingefügt. -->
	      </div>
	      <div class="modal-body">
	      	<!-- Unsere Eingabemaske -->
			  	<fieldset>
			  		<input type="text" class="form-control" name="query" placeholder="Wähle oben aus, wonach du suchen willst und gib hier deinen Suchbegriff ein…">
			  	</fieldset>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
		        <input type="submit" class="btn btn-primary" value="Film suchen &raquo;">
		      </div>
		    </form>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->