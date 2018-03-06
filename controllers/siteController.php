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

		//2eme passage pour les termes
		foreach($xml->concept as $concept){
			foreach($concept->language as $language){
				foreach ($language->term as $term) {

					$languageId = Langue::findByName((string) $language['name']);
					$conceptId = Concept::findByName((string) $concept['name']);
					
					$newTerm = new Terme((string) $term['name'], $languageId, $conceptId);

					Terme::insert($newTerm);

					/*if (isset($term->definition)) {
						// Traitement definition
					}
					if (isset($term->inflectedForm)) {
						// Traitement inflectedForm
					}
					if (isset($term->status)) {
						// Traitement status
					}*/
				}
			}

			// 4 - gérer les isA

		}

		$this->render("formCreerOntoterminologie", $data);
	}
	
}

?>
