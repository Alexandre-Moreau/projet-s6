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

	public function ajaxChargeFichiers(){
		$data = [];
		$data['log'] = [];
		$data['erreursForm'] = [];
		$data['statut'] = 'echec';
	
		if($_FILES == []){
			array_push($data['erreursForm'],_composeMisingError(_FILE));
		}else{
			if(sizeof($_FILES) > 1){
				array_push($data['erreursForm'],'trop de fichiers');
			}else{
				$fileType = $_FILES['0']['type'];
				// .sql ou .txt
				if($fileType != 'application/sql' && $fileType != 'text/plain' && $fileType != 'application/octet-stream'){
					array_push($data['erreursForm'], 'format de fichier incorrect ('.$fileType.')');
				}else{
					// Faire une sauvegarde de la base de données pour faire un rollback si le fichier est foireux?
					$content = file_get_contents($_FILES['0']['tmp_name']);
					// Remplace les suites d'espace/tab/entrée par un espace
					$content = preg_replace('!\s+!', ' ', $content);
					$queries = explode(';', $content);
					$queries = array_filter($queries);
					foreach($queries as $key => $value){
						if($value == ' '){
							unset($queries[$key]);
						}
					}
					foreach($queries as $q){
						$query = db()->prepare($q);
						$query->execute();
					}
					$data['statut'] = 'succes';
				}
			}
		}
		echo(json_encode($data));
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
		
		if (isset($_SERVER['SERVER_ADDR'])) {
			$data['ipServeur'] = $_SERVER['SERVER_ADDR'].':'.$_SERVER['SERVER_PORT'];
			
			if($_SERVER['SERVER_ADDR'] == '::1'){
				//$data['ipServeur'] .= ' (localhost)';
				$data['ipServeur'] = 'localhost'.':'.$_SERVER['SERVER_PORT'];
			}
		}else{
			$data['ipServeur'] = '?';
		}
		
		// - Articles dans la bdd mais pas sur le disque
		
		// - Articles sur le disque non référencés
		
		$this->render('statut', $data, ['backButton']);
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

		$this->render("gereBd", $data, ['backButton']);
	}

	// Pouvoir tout re-référencer, ou juste certains articles
	
}

?>
