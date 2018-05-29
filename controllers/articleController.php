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
		if(Langue::findAll() == []){
			array_push($data['erreursSaisie'], _ERRORLANGUAGES.'. '._IMPORTONTO.'.');
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
					array_push($data['erreursSaisie'],_ERRORFILETYPE." (".$fileType.")");
				}
				//Nom de l'article sans caractère spéciaux
				$newName = cleanString(str_replace(' ', '_', $_FILES['0']['name']));
				if(Article::findByChemin(GLOB_ARTICLESFODER . $newName) != null){
					array_push($data['erreursSaisie'], _ERRORFILEALREADYDB);
				}
			}
		}

		if($data['erreursSaisie']!=[]){
			$data['statut'] = 'echec';
			echo(json_encode($data));
		}else{
			if(move_uploaded_file($_FILES['0']['tmp_name'], GLOB_ARTICLESFODER . $newName)){
				if($fileType == 'plain'){$fileType = 'txt';}
				$newArticle = new Article($_POST['nom'], GLOB_ARTICLESFODER . $newName, $fileType, -1, Langue::FindByName($_POST['langue']));
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
		$article = Article::findById($_GET['id']);
		$data['langues'] = Langue::findAll();
 		$data['article'] = $article;
 		$data['references'] = Reference::findByArticle($article);
		$this->render("formModifier", $data, ['backButton']);
	}

	public function ajaxModifier(){
		header('Content-type: application/json');
		$data = [];
		$data['articleId'] = $_POST['id'];
		$data['erreursSaisie']=[];
		$data['log'] = [];
		$article = Article::findById($_POST['id']);
		$langue = Langue::findByName($_POST['langue']);
		
		//controle de saisie
		if(!isset($_POST['nom']) || $_POST['nom'] == ''){
			array_push($data['erreursSaisie'],'aucun nom n\'a été spécifié');
		}
		if(Langue::findAll() == []){
			array_push($data['erreursSaisie'], _ERRORLANGUAGES.'. '._IMPORTONTO.'.');
		}else if($langue == null){
			array_push($data['erreursSaisie'], 'langue null');
		}
		if($data['erreursSaisie'] != []){
			$data['statut'] = 'echec';
			echo(json_encode($data));
		}else{
			//modification du nom de l'objet article
			$article->nom = $_POST['nom'];
			//utilisation de article::update
			if($article->langue != $langue){
				$article->langue = $langue;
				$text = processContent($article);
				if($text == 'encoding_error'){
					$data['statut'] = 'echec';
					array_push($data['erreursSaisie'], _ENCODINGERROR);
				}else if($text == 'parsing_error'){
					$data['statut'] = 'echec';
					array_push($data['erreursSaisie'], _PARSEERROR);
				}else{
					Reference::deleteFromArticle($article);
					$log = self::reference($text, $_POST['langue'], $article);
					foreach($log as $l){
						array_push($data['log'], $l);
					}
				}
			}
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
	
	public static function reference($text, $pLangue, $article){
		$log = [];
		if($article->langue->nom == 'cn'){
			$textArray = separeMotsChinois($text);
		}else{
			$textArray = separeMots($text);
		}
		// Récupérer les termes avec des espaces qui commencent par chacun des mots du texte
		
		$langue = Langue::findByName($pLangue);
		
		// On récupère les termes qui correspondent au texte pour travailler sur un nombre réduit d'élément (et pas faire de requête à chaque mot du texte)
		$termes = Terme::findByMotCleLangue($textArray, $langue);
		$termesEspace = Terme::findByMotCleLangueSpace($textArray, $langue);

		foreach($termes as $key => $value){
			$termes[$key]->motCle = preg_replace('/\\\\{2,}/', '\\', $termes[$key]->motCle);
		}

		foreach($termesEspace as $key => $value){
			$termesEspace[$key]->motCle = preg_replace('/\\\\{2,}/', '\\', $termesEspace[$key]->motCle);
		}

		$concepts = [];

		$references = [];
		
		$i = 0;

		//echo $text;

		//echo "||||\n\n\n";
		
		while($i < count($textArray)){
			
			// Si le mot courant a été traité dans le traitement des termes avec espace
			$motEspaceTraite = false;
			
			$mot = $textArray[$i];
			
			// Traitement des termes avec espace: on regarde si chaque mot du terme avec des espace concorde avec le texte depuis $mot
			foreach($termesEspace as $termeEspace){
				$j = 0;				
				foreach(explode(' ', $termeEspace->motCle) as $motCourantTermeEspace){
					// si chaque mot du terme avec des espace concorde avec le texte depuis $mot
					if(isset($textArray[$i+$j])){
						$bool1 = strtolower($textArray[$i+$j]) == strtolower($motCourantTermeEspace);
						// même condition en enlevant le point final si il y en a un
						$bool2 = ( $i+$j == count($textArray)-1 ) && ( strtolower( substr($textArray[$i+$j], -1) ) == '.' ) && ( strtolower( substr($textArray[$i+$j], 0, -1) ) == strtolower($motCourantTermeEspace) );
						if($i+$j < count($textArray) && ($bool1 || $bool2)){
							// si on a réussi à faire concorder jusqu'à la fin du terme
							if($j == count(explode(' ', $termeEspace->motCle))-1){

								$contexte = '';
								$nbMotsAvant = 0;
								$nbMotsApres = 0;
								//Si on a coupé à cause de la longueur, on va donc mettre '...' au début
								$coupureLongueurAvant = true;
								$coupureLongueurApres = true;

								// On détermine nbMotsAvant et nbMotsApres (pour éviter les débordements et s'arrêter sur les points)
								while($nbMotsAvant<MAX_WORDS_BEFORE && $i-$nbMotsAvant>0 && substr($textArray[$i-$nbMotsAvant-1], -1)!='.' && substr($textArray[$i-$nbMotsAvant-1], -1)!='。'){
									$nbMotsAvant++;
								}

								if($nbMotsAvant<MAX_WORDS_BEFORE && $i-$nbMotsAvant>=0){
									$coupureLongueurAvant = false;
								}

								while($nbMotsApres<MAX_WORDS_AFTER && ($i+$j)+$nbMotsApres<count($textArray) && substr($textArray[($i+$j)+$nbMotsApres], -1)!='.' && substr($textArray[($i+$j)+$nbMotsApres], -1)!='。'){
									$nbMotsApres++;
								}

								if($nbMotsApres<MAX_WORDS_AFTER && ($i+$j)+$nbMotsApres<count($textArray)){
									$coupureLongueurApres = false;
								}

								//Création du contexte

								if($coupureLongueurAvant){
									$contexte .= '...';
								}

								// On ajoute les mots précédents au contexte
								for($l = $nbMotsAvant; $l>0; $l--){
									if(isset($textArray[$i-$l])){
										$contexte .= $textArray[$i-$l].' ';
									}
								}

								$contexte .= '||';

								for($k=$i; $k<=($i+$j); $k++){
									//$contexte .= $textArray[$k].'_';
									$contexte .= $textArray[$k];
									if($k != ($i+$j)){
										$contexte .= ' ';
									}
								}

								$contexte .= '||';

								// On ajoute les mots suivants au contexte
								for($l = 1; $l<=$nbMotsApres; $l++){
									if(isset( $textArray[($i+$j)+$l] )){
										$contexte .= ' '.$textArray[($i+$j)+$l];
									}
								}

								if($coupureLongueurApres){
									$contexte .= '...';
								}

								array_push($references, new Reference($i, $j, $contexte, $article, $termeEspace->concept));
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
			}
			
			// Traitement des termes sans espace
			if(!$motEspaceTraite){
				foreach($termes as $terme){
					// Si le mot corrrespond ou si le mot se finit par un '.' et si on le retire le mot correspond
					if ( strtolower($mot) == strtolower($terme->motCle) || ( substr($mot, -1) == '.' && strtolower(substr($mot, 0, -1)) == strtolower($terme->motCle) ) ){
						$contexte = '';
						$nbMotsAvant = 0;
						$nbMotsApres = 0;
						//Si on a coupé à cause de la longueur, on va donc mettre ... au début
						$coupureLongueurAvant = true;
						$coupureLongueurApres = true;
						$k = 0;

						// On détermine nbMotsAvant et nbMotsApres (pour éviter les débordements et s'arrêter sur les points)
						while($nbMotsAvant<MAX_WORDS_BEFORE && $i-$nbMotsAvant>0 && substr($textArray[$i-$nbMotsAvant-1], -1)!='.' && substr($textArray[$i-$nbMotsAvant-1], -1)!='。'){
							$nbMotsAvant++;
						}

						if($nbMotsAvant<MAX_WORDS_BEFORE && $i-$nbMotsAvant>=0){
							$coupureLongueurAvant = false;
						}

						while($nbMotsApres<MAX_WORDS_AFTER && $i+$nbMotsApres<count($textArray)-1 && substr($textArray[$i+$nbMotsApres], -1)!='.' && substr($textArray[$i+$nbMotsApres], -1)!='。'){
							$nbMotsApres++;
						}

						if($nbMotsApres<MAX_WORDS_AFTER && $i+$nbMotsApres<count($textArray)-1){
							$coupureLongueurApres = false;
						}

						//Création du contexte

						if($coupureLongueurAvant){
							$contexte .= '...';
						}

						// On ajoute les mots précédents au contexte
						for($l = $nbMotsAvant; $l>0; $l--){
							$contexte .= $textArray[$i-$l].' ';
						}

						$contexte .= '||'.$mot.'||';

						// On ajoute les mots suivants au contexte
						for($l = 1; $l<=$nbMotsApres; $l++){
							$contexte .= ' '.$textArray[$i+$l];
						}

						if($coupureLongueurApres){
							$contexte .= '...';
						}

						$k = 1;

						array_push($references, new Reference($i, 1, $contexte, $article, $terme->concept));
						break;
					}
				}
			}
			
			$i++;
		}

		foreach($references as $reference){
			Reference::insert($reference);
			//var_dump($reference);
		}
		
		// Ajouter un correcteur de référence?
		
		return $log;
	}
}

?>
