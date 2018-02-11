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
		
		if($_POST['nom'] == ''){
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
				
				$newArticle = new Article($_POST['nom'], 'articles\\\\' . $newName, $fileType);
				Article::insert($newArticle);
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
	
	public function showAll(){
		$articles = Article::FindAll();
		$data['articles'] = $articles;
		$this->render("tableShowAll", $data);
	}
	
	public function showById(){
		$article = Article::FindById($_GET['id']);
		$data['article'] = $article;
		$this->render("tableShowById", $data);
	}
}

?>
