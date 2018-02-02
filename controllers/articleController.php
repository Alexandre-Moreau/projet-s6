<?php

class ArticleController extends Controller{
	
	public function create(){
		$data=[];
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
			echo(json_encode($data['erreursSaisie']));
		}else{
			echo(json_encode('succes'));
			if(move_uploaded_file($_FILES['0']['tmp_name'], 'articles\\' . $_FILES['0']['name'])){
				$newArticle = new Article($_POST['nom'], 'articles\\\\' . $_FILES['0']['name'], $fileType);
				Article::insert($newArticle);
				//var_dump($newArticle);
				//header('Location: ./?r=Article/showById&id='.db()->lastInsertId());
			}else{
				array_push($data['erreursSaisie'],'erreur upload file');
				echo(json_encode($data['erreursSaisie']));
			}
		}
	}
	
	public function showAll(){
		$articles = Article::FindAll();
		$data['articles'] = $articles;
		$this->render("tableshowAll", $data);
	}
	
	public function showById(){
		$article = Article::FindById($_GET['id']);
		$data['article'] = $article;
		$this->render("tableshowById", $data);
	}
}

?>