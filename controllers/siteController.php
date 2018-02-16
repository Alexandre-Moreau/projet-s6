<?php

//Auto-generated file
class SiteController extends Controller{

	public function index(){
		$this->render("index");
	}

	public function rechercher(){
		$data['onto'] = Concept::findAllWithChildrens();
		$this->render("rechercher", $data);
	}

	public function creerOntoterminologie(){
		$data = [];
		$xml = simplexml_load_file('sieges.ote');
		
		// Début du parsing
		$data['nom']= $xml['name'];
		$domaine = $xml->domain;
		$auteur = $xml->author;
		$dateCreation = $xml->creationDate;
		$derniereModification = $xml->lastVersionDate;

		$data['xml'] = $xml;
		$data['concepts'] = [];

		Concept::deleteAll();
		Langue::deleteAll();
		Terme::deleteAll();

		$languages = [];

		foreach($xml->concept as $concept){
			// 1 - créer des objets concepts
			$newConcept = new Concept((string) $concept['name']);
			array_push($data['concepts'], $newConcept);

			// 2 - faire les insert
			Concept::insert($newConcept);

			// 3 - gérer les mots clés
			foreach($concept->language as $language){
				if (!in_array($language['name'], $languages)){
					array_push($languages, $language['name']);
					Langue::insert(new Langue((string) $language['name']));
				}
				/*foreach ($language->term as $term) {

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
				}*/
			}

			// 4 - gérer les isA

		}

		$this->render("formCreerOntoterminologie", $data);
	}
	
}

?>