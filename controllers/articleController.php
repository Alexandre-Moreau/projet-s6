<?php

class ArticleController extends Controller{
	
	public function create(){
		$data=[];
		$data['langues'] = Langue::FindAll();
		$data['langueDefaut'] = $_ENV['langue'];
		$this->render("formCreate",$data, ['backButton']);
	}
	
	public function ajaxCreate(){
		header('Content-type: application/json');
		$data['erreursSaisie']=[];
		$data['log'] = [];
		$newName = "";
		
		if(!isset($_POST['nom']) || $_POST['nom'] == ''){
			array_push($data['erreursSaisie'],_composeMisingError(_NAME));
		}
		if($_FILES == []){
			array_push($data['erreursSaisie'],_composeMisingError(_FILE));
		}else{
			if(sizeof($_FILES) > 1){
				array_push($data['erreursSaisie'],'trop de fichiers');
			}else{
				$fileType = explode("/", $_FILES['0']['type'])[1]; // application/pdf -> pdf, text/html -> html
				// html, pdf, txt (text/plain)
				if($fileType != 'html' && $fileType != 'htm' && $fileType != 'pdf' && $fileType != 'plain' && $fileType != ''){
					array_push($data['erreursSaisie'],"le type de fichier n'est pas reconnu (".$fileType.")");
				}
				//Nom de l'article sans caractère spéciaux
				$newName = cleanString(str_replace(' ', '_', $_FILES['0']['name']));
				if(Article::findByChemin('articles\\' . $newName) != null){
					array_push($data['erreursSaisie'],'ce fichier est déjà dans la base de données');
				}
			}
		}

		if($data['erreursSaisie']!=[]){
			$data['statut'] = 'echec';
			echo(json_encode($data));
		}else{
			if(move_uploaded_file($_FILES['0']['tmp_name'], 'articles\\' . $newName)){
				if($fileType == 'plain'){$fileType = 'txt';}
				$newArticle = new Article($_POST['nom'], 'articles\\\\' . $newName, $fileType, -1, Langue::FindByName($_POST['langue']));
				$text = processContent($newArticle);
				if($text == 'encoding_error'){
					$data['statut'] = 'echec';
					array_push($data['erreursSaisie'], _ENCODINGERROR);
				}else if($text == 'parsing_error'){
					$data['statut'] = 'echec';
					array_push($data['erreursSaisie'],_PARSEERROR);
				}else{
					$count = countWords($text, $newArticle->langue);
					$newArticle->nbMots = $count;
					Article::insert($newArticle);
					global $db;
					$newArticle->id = $db->lastInsertId();
					$log = self::reference($text, $_POST['langue'], $newArticle);
					$data['statut'] = 'succes';
					$articleId = $newArticle->id;
					$data['articleId'] = $articleId;
				}
			}else{
				$data['statut'] = 'echec';
				array_push($data['erreursSaisie'],'erreur upload file');
			}
			echo(json_encode($data));
		}
	}
	
	public function modifier(){
		$data = [];
		$data['langues'] = Langue::FindAll();
 		$data['article'] = Article::FindById($_GET['id']);
		$this->render("formModifier", $data, ['backButton']);
	}

	public function ajaxModifier(){
		header('Content-type: application/json');
		$data = [];
		$data['erreursSaisie']=[];
		$data['log'] = $_POST;
		$article = Article::FindById($_POST['id']);
		
		//print_r($f)
		
		//controle de saisie
		if(!isset($_POST['nom']) || $_POST['nom'] == ''){
			array_push($data['erreursSaisie'],'aucun nom n\'a été spécifié');
		}
		if($data['erreursSaisie']!=[]){
			$data['statut'] = 'echec';
			echo(json_encode($data));
		}else{
			//modification du nom de l'objet article
			$article->nom = $_POST['nom'];
			//utilisation de article::update
			Article::update($article);
			$data['statut'] = 'succes';
			echo(json_encode($data));
		}
		
	}	

	public function ajaxRechercher(){
		header('Content-type: application/json');
		$data['log'] = [];
		$data['articlesRefsScore'] = [];
		$articlesRefsScore = Article::findByQuery($_POST['query']);
		foreach($articlesRefsScore['articlesRefScore'] as $articleRefsScore){
			//print_r($articleRefsScore);
			$row = [];
			$row['article'] = Model::toArray($articleRefsScore['article']);
			$row['references'] = [];
			foreach ($articleRefsScore['references'] as $ref) {
				array_push($row['references'], Model::toArray($ref));
			}
			$articleRefsScore['references'];
			$row['score'] = $articleRefsScore['score'];
			array_push($data['articlesRefsScore'], $row);
		}
		foreach($articlesRefsScore['log'] as $log){
			array_push($data['log'], $log);
		}
		echo(json_encode($data));
	}
	
	public function ajaxOverview(){
		header('Content-type: application/json');
		$data['log'] = [];
		$data['references'] = [];
		$references = Reference::findByArticle(Article::findById($_POST['articleId']));
		foreach($references as $reference){
			array_push($data['references'], Model::toArray($reference));
		}
		echo(json_encode($data));
	}
	
	public function showAll(){
		$data['articles'] = Article::FindAll();
		$this->render('tableShowAll', $data);
	}
	
	public function showById(){
		$article = Article::findById($_GET['id']);
		$data['article'] = $article;
		$data['references'] = Reference::findByArticle($article);
		$this->render('tableShowById', $data, ['backButton']);
	}
	
	public function supprimer(){
		Article::delete(Article::findById($_GET['id']));
		header("Location: .?r=article/showAll");
	}
	
	private static function reference($text, $pLangue, $article){
		$log = [];
		if($article->langue->nom == 'cn'){
			$textArray = separeMotsChinois($text);
		}else{
			$textArray = explode(' ', $text);
		}
		// Récupérer les termes avec des espaces qui commencent par chacun des mots du texte
		
		$langue = Langue::findByName($pLangue);
		
		// On récupère les termes qui correspondent au texte pour travailler sur un nombre réduit d'élément (et pas faire de requête à chaque mot du texte)
		$termes = Terme::findByMotCleLangue($textArray, $langue);
		$termesEspace = Terme::findByMotCleLangueSpace($textArray, $langue);

		$concepts = [];

		$references = [];
		
		$i = 0;
		
		while($i < count($textArray)){
			
			// Si le mot courant a été traité dans le traitement des termes avec espace
			$motEspaceTraite = false;
			
			$mot = $textArray[$i];
			
			// Traitement des termes avec espace: on regarde si chaque mot du terme avec des espace concorde avec le texte depuis $mot
			foreach($termesEspace as $termeEspace){
				$j = 0;				
				foreach(explode(' ', $termeEspace->motCle) as $motCourantTermeEspace){
					// si chaque mot du terme avec des espace concorde avec le texte depuis $mot
					if($i+$j < count($textArray) && strtolower($textArray[$i+$j]) == strtolower($motCourantTermeEspace)){						
						// si on a réussi à faire concorder jusqu'à la fin du terme
						if($j == count(explode(' ', $termeEspace->motCle))-1){
							/*
							// on ajoute $termeEspace aux concepts si il n'y est pas deja, on incrémente le compteur sinon 
							if(!isset($concepts[$termeEspace->concept->id])){
								$concepts[$termeEspace->concept->id] = 1;
							}else{
								$concepts[$termeEspace->concept->id] = $termeEspace[$terme->concept->id]+1;
							}
							// On sort, on a identifié le mot, on va sauter j prochains mots
							$i = $i+$j;
							$motEspaceTraite = true;
							break;*/
							array_push($references, new Reference($i, $j, '...'. $termeEspace->motCle .'...', $article, $termeEspace->concept));
							// On sort, on a identifié le mot, on va sauter j prochains mots
							$i = $i+$j;
							$motEspaceTraite = true;
						}
						$j++;						
					}else{
						// On sort, le mot n' a pas été identifié
						break;
					}
				}
			}
			
			// Traitement des termes sans espace
			if(!$motEspaceTraite){
				foreach($termes as $terme){
					if (strtolower($mot) == strtolower($terme->motCle)){
						// on ajoute $terme aux concepts si il n'y est pas deja, on incrémente le compteur sinon 
						array_push($references, new Reference($i, 1, '...'. $terme->motCle .'...', $article, $terme->concept));
						break;
					}
				}
			}
			
			$i++;
		}
		
		foreach($references as $reference){
			Reference::insert($reference);
		}
		
		// Ajouter un correcteur de référence?
		
		return $log;
	}
}

?>
