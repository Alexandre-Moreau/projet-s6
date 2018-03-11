<?php

class ArticleController extends Controller{
	
	public function create(){
		$data=[];
		$data['langues'] = Langue::FindAll();
		$data['langueDefaut'] = $_ENV['langue'];
		$this->render("formCreate",$data);
	}
	
	public function ajaxCreate(){
		header('Content-type: application/json');
		$data['erreursSaisie']=[];
		$data['log'] = [];
		$newName = "";
		
		if(!isset($_POST['nom']) || $_POST['nom'] == ''){
			array_push($data['erreursSaisie'],'aucun nom n\'a été spécifié');
		}
		if($_FILES == []){
			array_push($data['erreursSaisie'],'aucun fichier n\'a été spécifié');
		}else{
			if(sizeof($_FILES) > 1){
				array_push($data['erreursSaisie'],'trop de fichiers');
			}else{
				$fileType = explode("/", $_FILES['0']['type'])[1]; // application/pdf -> pdf, text/html -> html
				if($fileType != 'html' && $fileType != 'htm' && $fileType != 'pdf' && $fileType != ''){
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
				$newArticle = new Article($_POST['nom'], 'articles\\\\' . $newName, $fileType, -1, Langue::FindByName($_POST['langue']));
				$text = self::processContent($newArticle);
				if($text == 'encoding_error'){
					$data['statut'] = 'echec';
					array_push($data['erreursSaisie'],'erreur d\'encodage: les doivent être encodé en UTF-8');
				}else if($text == 'parsing_error'){
					$data['statut'] = 'echec';
					array_push($data['erreursSaisie'],'erreur de parsing: le document n\'est pas correct');
				}else{
					$count = self::countWords($text);
					$newArticle->nbMots = $count;
					Article::insert($newArticle);
					$newArticle->id = db()->lastInsertId();
					$log = self::reference($text, $_POST['langue'], $newArticle);
					$data['log'] = $log;
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
		$data['articles'] = [];
		$articles = Article::findAll();
		foreach($articles as $article){
			array_push($data['articles'], Article::toArray($article));
		}
		echo(json_encode($data));
	}
	
	public function ajaxOverview(){
		header('Content-type: application/json');
		$data['log'] = [];
		$data['references'] = [];
		$references = Reference::findByArticle(Article::FindById($_POST['articleId']));
		foreach($references as $reference){
			array_push($data['references'], Reference::toArray($reference));
		}
		echo(json_encode($data));
	}
	
	public function showAll(){
		$articles = Article::FindAll();
		$data['articles'] = $articles;
		$this->render("tableShowAll", $data);
	}
	
	public function showById(){
		$article = Article::FindById($_GET['id']);
		$data['article'] = $article;
		$data['references'] = Reference::FindByArticle($article);
		$this->render('tableShowById', $data);
	}
	
	public function modifier(){
		$data = [];
		$data['langues'] = Langue::FindAll();
 		$data['article'] = Article::FindById($_GET['id']);
		$this->render("formModifier", $data);
	}
	
	private static function processContent($article){
		if($article->type == "pdf"){
			$parser = new Smalot\PdfParser\Parser();
			$pdf = $parser->parseFile($article->chemin);
			$text = $pdf->getText();
			$text = self::parseContentPdf($text);
		}elseif($article->type == "html"){
			//Non testé
			$text = file_get_contents($article->chemin);
			// Si le fichier est mal encodé
			if(!mb_detect_encoding($text, 'UTF-8', true)){
				return 'encoding_error';
			}else{
				$text = self::parseContentHtml($text);
			}
		}
		return $text;
	}
	
	private static function parseContentPdf($pText){
		//Il faudrait grace à une regex identifier les titres, les identifier grace a des caractères [[titre]] par exemple pour qu'ils montent dans le référencement (1 occurence dans le titre = 2 occurences par exemple)
		//Remplacer les \n par des ' ' pour espacer les titres
		
		$text = str_replace(["'","&#39;"], "' ", $pText); // on ajoute un ' ' derrière les "'" (avec le caractère html)
		$text = preg_replace('/\n+/', '', $text); // on efface les retours à la ligne
		$text = preg_replace('(\(|\))', '', $text); // on efface les parenthèses
		$text = preg_replace('(\.)', '', $text); // on efface les points
		$textArray = explode(' ', $text);
		$textArray = array_filter($textArray); // on retire les éléments vides du tableau (revient à supprimer les suite d'espace)
		$text = implode(' ', $textArray);
		return $text;
	}
	
	private static function parseContentHtml($pText){
		//Gérer d'autres trucs que juste le contenu des balises p du body?
		//Gérer les listes peut être
		//Gérer les <h> avec des [[ ]] ( voir parseContentPdf)
		
		// Traitement des erreurs de parsing
		libxml_use_internal_errors(true);
		
		$xml = simplexml_load_string($pText);
		
		if(!$xml) {
			return 'parsing_error';
		}
		
		$text = '';
		foreach($xml->body->p as $p){
			$text .= (string)$p.' ';
		}
		
		$text = str_replace(["'","&#39;"], "' ", $text); // on ajoute un ' ' derrière les "'" (avec le caractère html)
		$text = preg_replace('/\n+/', '', $text); // on efface les retours à la ligne
		$text = preg_replace('(\(|\))', '', $text); // on efface les parenthèses
		$text = preg_replace('(\.)', '', $text); // on efface les points
		$textArray = explode(' ', $text);
		$textArray = array_filter($textArray); // on retire les éléments vides du tableau (revient à supprimer les suite d'espace)
		$text = implode(' ', $textArray);
		
		return $text;
	}
	
	private static function countWords($text){
		//return str_word_count($text); // ? -> compte bizarrement
		return count(explode(' ', $text));
	}
	
	private static function reference($text, $pLangue, $article){
		$log = [];
		$textArray = explode(' ', $text);
		// Récupérer les termes avec des espaces qui commencent par chacun des mots du texte
		
		$langue = Langue::findByName($pLangue);
		
		// On récupère les termes qui correspondent au texte pour travailler sur un nombre réduit d'élément (et pas faire de requête à chaque mot du texte)
		$termes = Terme::findByMotCleLangue($textArray, $langue);
		$termesEspace = Terme::findByMotCleLangueSpace($textArray, $langue);
		
		$concepts = [];
		
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
							// on ajoute $termeEspace aux concepts si il n'y est pas deja, on incrémente le compteur sinon 
							if(!isset($concepts[$termeEspace->concept->id])){
								$concepts[$termeEspace->concept->id] = 1;
							}else{
								$concepts[$termeEspace->concept->id] = $termeEspace[$terme->concept->id]+1;
							}
							// On sort, on a identifié le mot, on va sauter j prochains mots
							$i = $i+$j;
							$motEspaceTraite = true;
							break;
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
						if(!isset($concepts[$terme->concept->id])){
							$concepts[$terme->concept->id] = 1;
						}else{
							$concepts[$terme->concept->id] = $concepts[$terme->concept->id]+1;
						}
						break;
					}
				}
			}
			
			$i++;
		}
		
		foreach($concepts as $conceptId => $nombreOccurence){
			$newRefenrence = new Reference($nombreOccurence, $article, Concept::findById($conceptId));
			Reference::insert($newRefenrence);
		}
		
		// Ajouter un correcteur de référence?
		
		return $log;
	}
}

?>
