<?php

//Auto-generated file
class SiteController extends Controller{

	public function index(){
		$this->render("index");
	}

	public function ajaxChangeLanguage(){
		$_SESSION['langue'] = $_POST['langue'];
	}
	
	public function rechercher(){
		$data['onto'] = Concept::findAllWithChildrens();
		$data['termes'] = Terme::findAllPrefered(Langue::findByName($_SESSION['langue']));
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
		
		Reference::deleteAll();		
		Article::deleteAll();
		Relation::deleteAll();		
		Terme::deleteAll();
		Concept::deleteAll();		
		Langue::deleteAll();

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

					/*if (isset($term->definition)) {
						// Traitement definition
					}*/
					
					if(isset($term->status) && (string)$term->status=='preferred'){
						$newTerm = new Terme((string) $term['name'], $languageId, $conceptId, true);
					}else{
						$newTerm = new Terme((string) $term['name'], $languageId, $conceptId, false);
					}

					Terme::insert($newTerm);

					// Traitement inflectedForm
					foreach ($term->inflectedForm as $inflectedForm) {
						$newInflectedTerm = new Terme((string) $inflectedForm, $languageId, $conceptId, false);
						Terme::insert($newInflectedTerm);
					}
				}
			}
		}
	}

	public function ajaxCreate(){
		$data['log'] = [];
		$data['error'] = '';
		header('Content-type: application/json');
		if(isset($_FILES['file0'])){
			$statut = self::creationOnto($_FILES['file0']['tmp_name']);
			if($statut == 'erreur_parsing'){
				$data['statut'] = 'echec';
				$data['errorMessage'] = 'parseError';
			}
		}else{
			$data['statut'] = 'echec';
			$data['errorMessage'] = 'noFile';
		}
		echo(json_encode($data));
	}
	

	public function creerOntoterminologie(){
		$this->render("formCreerOntoterminologie");
	}

}

?>
