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