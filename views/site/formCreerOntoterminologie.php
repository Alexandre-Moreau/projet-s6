	<div class="container">
		<h3>Créer une nouvelle ontoterminologie</h3>
		<hr style="border-top: 3px double grey"><br>
		<div id="formStatus" >
		</div>
		<form method="post" action =".?r=Site/ajaxCreate" enctype="multipart/form-data" class="col">
			<div class="form-group">
				<label for="nom">Nom : <span class="requis">*</span></label>
				<input type="text" name="nom" id="nom" class="form-control" placeholder="Entrer un nom" />
			</div>
			<div class="form-group">
				<input type="file" name='file' id='file' accept=".pdf,.html,.htm" class="form-control">
			</div>
			<div class="form-group form_boutons">
				<input id="submit" type="submit" value="Confirmer" class="btn btn-primary" disabled="true"><!--
				--><input id="reset" type="reset" name="annuler" class="btn btn-secondary"></input>
			</div>
		</form>
		<br>
		<span class='requis'>*</span> Champ requis
	</div>

<?php
	// Le fichier test.xml contient un document XML avec un élément racine
	// et au moins un élément /[racine]/title.

	if (file_exists('sieges.xml')) {

		$xml = simplexml_load_file('sieges.xml');
		
		// Début du parsing
		$nom = $xml['name'];
		echo "<h3>Nom: " . $nom . "</h3><br/><br/><h4>Liste des concepts (" . count($xml->concept) . ")</h4>";
		$domaine = $xml->domain;
		$auteur = $xml->author;
		$dateCreation = $xml->creationDate;
		$derniereModification = $xml->lastVersionDate;

		$i = 1;
		foreach($xml->concept as $concept){
			echo $i . ") " . $concept['name'] . "<br/>";

			foreach($concept->isa as $isa){
				echo ".....est un " . $isa . "<br/>";
			}

			foreach($concept->essChar as $essChar){
				echo ".....caractéristique principale: " . $essChar . "<br/>";
			}

			foreach($concept->language as $language){
				echo ".....langage: " . $language['name'] . "<br/>";
				foreach ($language->term as $term) {
					echo "..........terme: " . $term['name'] . "<br/>";
					if (isset($term->definition)) {
						echo "...............definition: " . $term->definition . "<br/>";
					}
					if (isset($term->inflectedForm)) {
						echo "...............inflectedForm: " . $term->inflectedForm . "<br/>";
					}
					if (isset($term->status)) {
						echo "................status: " . $term->status . "<br/>";
					}
				}
			}

			echo "<br/>";
			$i++;
		}
		//Fin du parsing

	} else {
		exit('Echec lors de l\'ouverture du fichier .xml.');
	}
?>