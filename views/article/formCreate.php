
<?php
	if(isset($data['erreursSaisie'])){
		echo "<p class='erreursSaisie'>Il y a des erreurs:<br/>";
		foreach($data['erreursSaisie'] as $erreurSaisie){
			echo "-".$erreurSaisie."<br/>";
		}
	echo "</p>";
}
?>
<form action='./?r=Article/create' method='post' enctype="multipart/form-data">
	<!--<label for='nom'>nom : <span class='requis'>*</span></label>
	<input type='text' name='nom' id='nom' <?php if(isset($_POST['nom'])){echo "value='".$_POST['nom']."'";} ?> />
	<label for='chemin'>chemin : <span class='requis'>*</span></label>
	<input type='text' name='chemin' id='chemin' <?php if(isset($_POST['chemin'])){echo "value='".$_POST['chemin']."'";} ?> />
	<label for='type'>type : <span class='requis'>*</span></label>
	<input type='text' name='type' id='type' <?php if(isset($_POST['type'])){echo "value='".$_POST['type']."'";} ?> />-->
	<input name="file" type="file" accept=".pdf,.html,.htm">
	<div class="form_boutons">
		<input type='submit' name='submit' value='Confirmer' id='submit'/><!--
		--><input type='submit' name='cancel' value='Annuler' id='cancel'/>
	</div>

</form>
<span class='requis'>*</span> Champ requis
