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
			}
		}

		if($data['erreursSaisie']!=[]){
			$data['statut'] = 'echec';
			echo(json_encode($data));
		}else{
			$newName = cleanString(str_replace(' ', '_', $_FILES['0']['name']));
			if(move_uploaded_file($_FILES['0']['tmp_name'], 'articles\\' . $newName)){				
				$newArticle = new Article($_POST['nom'], 'articles\\\\' . $newName, $fileType, -1);
				$text = self::processContent($newArticle);
				$count = self::countWords($text);
				$newArticle->nbMots = $count;
				Article::insert($newArticle);
				//$data['log'] = self::processContent($newArticle)." [".$count." mots]";
				$references = self::reference($text);
				$data['log'] = $references;
				$data['statut'] = 'succes';
				$data['articleId'] = db()->lastInsertId();
				echo(json_encode($data));
			}else{
				$data['statut'] = 'echec';
				array_push($data['erreursSaisie'],'erreur upload file');
				echo(json_encode($data));
			}
		}
	}

	public function ajaxRecherche(){
		header('Content-type: application/json');
		$data = [];
		$data['log'] = $_POST['query'];
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
	
	private static function processContent($article){
		if($article->type == "pdf"){
			$parser = new Smalot\PdfParser\Parser();
			$pdf = $parser->parseFile($article->chemin);
			$text = $pdf->getText();
			$text = self::parseContentPdf($text);
		}elseif($article->type == "html"){
			//Non testé
			$text = file_get_contents($article->chemin);
			$text = self::parseContentHtml($text);
		}
		return $text;
	}
	
	private static function parseContentPdf($pText){
		//Il faudrait grace à une regex identifier les titres, les identifier grace a des caractères [[titre]] par exemple pour qu'ils montent dans le référencement (1 occurence dans le titre = 2 occurences par exemple)
		//Remplacer les \n par des ' ' pour espacer les titres
		
		$text = str_replace(["'","&#39;"], "' ", $pText); // on ajoute un ' ' derrière les "'" (avec le caractère html)
		$text = preg_replace('/\n+/', '', $text); // on efface les retours à la ligne
		$textArray = explode(' ', $text);
		$textArray = array_filter($textArray); // on retire les éléments vides du tableau (revient à supprimer les suite d'espace)
		$text = implode(' ', $textArray);
		return $text;
	}
	
	private static function parseContentHtml($pText){
		//Gérer d'autres trucs que juste le contenu des balises p du body?
		//Gérer les listes peut être
		//Gérer les <h> avec des [[ ]] ( voir parseContentPdf)
		
		$xml = simplexml_load_string($pText);
		$text = '';
		foreach($xml->body->p as $p){
			$text .= (string)$p.' ';
		}
		
		$text = str_replace(["'","&#39;"], "' ", $text); // on ajoute un ' ' derrière les "'" (avec le caractère html)
		$text = preg_replace('/\n+/', '', $text); // on efface les retours à la ligne
		$textArray = explode(' ', $text);
		$textArray = array_filter($textArray); // on retire les éléments vides du tableau (revient à supprimer les suite d'espace)
		$text = implode(' ', $textArray);
		
		return $text;
	}
	
	private static function countWords($text){
		//return str_word_count($text); // ?
		return count(explode(' ', $text));
	}
	
	private static function reference($pText){
		$references = [];
		return $references;
	}
}

?>
