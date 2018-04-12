<?php

//Auto-generated file
class MaintenanceController extends Controller{

	public function index(){
		$data = [];
		$this->render('index', $data);
	}

	public function ajaxTestStatut(){
		return true;
	}

	public function ajaxTestBd(){

		return true;
	}

	public function mainStatut(){
		$data = [];

		$data['emplacement'] = str_replace('\\','/', GLOB_ARTICLESFODER);
		$data['nbArticles'] = count(Article::findall());
		$data['articlesNRef'] = [];
		$data['fichiersNonCorrespondantsDisque'] = [];
		$data['fichiersNonCorrespondantsBdd'] = [];
		$data['racinesOnto'] = Concept::findRoots();
		
		$filesOnDisk = Article::getNameAllOnDisk();
		$articles = Article::findall();
		$articlesNRef = Article::findAllWithoutRef();
		
		foreach($articlesNRef as $articleNRef){
			array_push($data['articlesNRef'], $articleNRef->nom);
		}

		foreach($filesOnDisk as $fileOnDisk){
			foreach($articles as $article){
				if(str_replace('\\','/', $article->chemin) == str_replace('\\','/', GLOB_ARTICLESFODER.$fileOnDisk)){
					unset($filesOnDisk[array_search ($fileOnDisk, $filesOnDisk)]);
					unset($articles[array_search ($article, $articles)]);
				}
			}
		}
		
		foreach($filesOnDisk as $fileOnDisk){
			array_push($data['fichiersNonCorrespondantsDisque'], str_replace('\\','/', $fileOnDisk));
		}
		
		foreach($articles as $article){
			array_push($data['fichiersNonCorrespondantsBdd'], str_replace('\\','/', Article::toArray($article)));
		}
		
		$data['nbArticlesDisqueNBdd'] = -1;
		
		//$data['serverUser'] = utf8_encode(exec('whoami'));
		// https://stackoverflow.com/questions/28548743/php-get-current-user-vs-execwhoami
		$data['serverUser'] = utf8_encode(get_current_user());
		// http://itman.in/en/how-to-get-client-ip-address-in-php/
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
			//check ip from share internet
			$data['ipClient'] = $_SERVER['HTTP_CLIENT_IP'];
		}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//to check ip is pass from proxy
			$data['ipClient'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$data['ipClient'] = $_SERVER['REMOTE_ADDR'];
		}
		
		if($data['ipClient'] == '::1'){
			//$data['ipClient'] .= ' (localhost)';
			$data['ipClient'] = 'localhost';
		}
		
		$data['ipServeur'] = $_SERVER['SERVER_ADDR'].':'.$_SERVER['SERVER_PORT'];
		
		if($_SERVER['SERVER_ADDR'] == '::1'){
			//$data['ipServeur'] .= ' (localhost)';
			$data['ipServeur'] = 'localhost'.':'.$_SERVER['SERVER_PORT'];
		}
		
		// - Articles dans la bdd mais pas sur le disque
		
		// - Articles sur le disque non référencés
		
		$this->render("statut", $data);
	}

	public function gestionBaseDeDonnees(){
		$data = [];

		global $errorCodes;

		$statut = dbTest();

		// si la connexion à la bdd a échoué
		if($statut['reussite'] == 0){
			// on teste la connexion directement sur le serveur
			$statut = dbTest(false);
		}else{
			$statut['reussite'] = 2;
		}
		//Statut réussite:
		// 2 -> bdd trouvée
		// 1 -> bdd non trouvée, mais serveur ok
		// 0 -> serveur ok

		$data['statut'] = $statut;

		$this->render("gereBd", $data);
	}

	// Pouvoir tout re-référencer, ou juste certains articles
	
}

?>
