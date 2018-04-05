<?php

//Auto-generated file
class MaintenanceController extends Controller{

	public function statut(){
		$data = [];
		
		$data['nbArticles'] = count(Article::findall());
		$data['articlesNRef'] = Article::findallWithoutRef();
		$data['fichiersNonCurrespondantsDisque'] = [];
		$data['fichiersNonCurrespondantsBdd'] = [];
		$data['racinesOnto'] = Concept::findRoots();
		
		$filesOnDisk = Article::getNameAllOnDisk();
		$articles = Article::findall();
		
		foreach($filesOnDisk as $fileOnDisk){
			foreach($articles as $article){
				if($article->chemin == GLOB_ARTICLESFODER.$fileOnDisk){
					unset($filesOnDisk[array_search ($fileOnDisk, $filesOnDisk)]);
					unset($articles[array_search ($article, $articles)]);
				}
			}
		}
		
		foreach($filesOnDisk as $fileOnDisk){
			array_push($data['fichiersNonCurrespondantsDisque'], $fileOnDisk);
		}
		
		foreach($articles as $article){
			array_push($data['fichiersNonCurrespondantsBdd'], $article->chemin);
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
			$data['ipClient'] .= ' (localhost)';
		}
		
		$data['ipServeur'] = $_SERVER['SERVER_ADDR'].':'.$_SERVER['SERVER_PORT'];
		
		if($_SERVER['SERVER_ADDR'] == '::1'){
			$data['ipServeur'] .= ' (localhost)';
		}
		
		// - Articles dans la bdd mais pas sur le disque
		
		// - Articles sur le disque non référencés
		
		$this->render("index",$data);
	}

	// Pouvoir tout re-référencer, ou juste certains articles
	
}

?>
