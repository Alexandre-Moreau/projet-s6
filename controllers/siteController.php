<?php

//Auto-generated file
class SiteController extends Controller{

	public function index(){
		$this->render("index");
	}
	
	public function rechercher(){
		$data['onto'] = Concept::findAllWithChildrens();
		$this->render('rechercher', $data);
	}

	private static function creationOnto($fichier){
		$data = [];

		// Traitement des erreurs de parsing
		libxml_use_internal_errors(true);

		$xml = simplexml_load_file($fichier);
		if(!$xml){
			return 'erreur_parsing';
		}
		
		// Début du parsing
		$data['nom'] = $xml['name'];
		$data['domaine'] = $xml->domain;
		$data['auteur'] = $xml->author;
		$data['dateCreation'] = $xml->creationDate;
		$data['derniereModification'] = $xml->lastVersionDate;

		$data['xml'] = $xml;
		$data['concepts'] = [];

		Concept::deleteAll();
		Langue::deleteAll();
		Terme::deleteAll();

		$languages = [];

		//1er passage pour les concepts et les langues
		foreach($xml->concept as $concept){
			// 1 - créer des objets concepts
			$newConcept = new Concept((string) $concept['name']);
			array_push($data['concepts'], $newConcept);

			// 2 - faire les insert
			Concept::insert($newConcept);

			// 3 - gérer les mots clés

			foreach($concept->language as $language){
				if (!in_array((string) $language['name'], $languages)){
					array_push($languages, (string) $language['name']);
					Langue::insert(new Langue((string) $language['name']));
				}
			}
		}


		//2ème passage pour les termes et les relations isA
		foreach($xml->concept as $concept){

			$conceptFrom = Concept::findByName((string) $concept['name']);
			include_once "models/Relation.php";

			// Traitement des relations isA
			foreach ($concept->isa as $isa) {
				$conceptTo = Concept::findByName((string) $isa);
				
				$relation = new Relation('isA', $conceptFrom, $conceptTo);
				Relation::insert($relation);
			}

			foreach($concept->language as $language){
				// Traitement des termes
				foreach ($language->term as $term) {

					$languageId = Langue::findByName((string) $language['name']);
					$conceptId = Concept::findByName((string) $concept['name']);
					
					$newTerm = new Terme((string) $term['name'], $languageId, $conceptId);

					/*if (isset($term->definition)) {
						// Traitement definition
					}
					if (isset($term->status)) {
						// Traitement status
					}*/

					Terme::insert($newTerm);

					// Traitement inflectedForm
					foreach ($term->inflectedForm as $inflectedForm) {
						$newInflectedTerm = new Terme((string) $inflectedForm, $languageId, $conceptId);
						Terme::insert($newInflectedTerm);
					}
				}
			}
		}
	}

	public function ajaxCreate(){
		$data['log'] = [];
		header('Content-type: application/json');
		$statut = self::creationOnto($_FILES['file0']['tmp_name']);
		if($statut == 'erreur_parsing'){
			$data['statut'] = 'echec';
		}
		echo(json_encode($data));
	}
	

	public function creerOntoterminologie(){
		$this->render("formCreerOntoterminologie");
	}
	
}

?>
