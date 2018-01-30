<?php

//Auto-generated file
class ArticleController extends Controller{
	public function create(){
		$data=[];
		if(!isset($_POST['submit'])){
			$this->render("formCreate",$data);
		}else{
			$data['erreursSaisie']=[];
			//var_dump($_FILES);

			if($_FILES['file']['name']==''){
				array_push($data['erreursSaisie'],"aucun fichier n'a été déposé");
			}else{
				$fileType = explode("/", $_FILES['file']['type'])[1]; // application/pdf -> pdf
				if($fileType != 'html' && $fileType != 'htm' && $fileType != 'pdf' && $fileType != ''){
					array_push($data['erreursSaisie'],"le type de fichier n'est pas reconnu (".$fileType.")");
				}
			}

			if($data['erreursSaisie']!=[]){
				$this->render("formCreate",$data);
			}else{
				if(move_uploaded_file($_FILES['file']['tmp_name'], 'articles\\' . $_FILES['file']['name'])){
					$newArticle = new Article('TODO name', 'articles\\\\'.$_FILES['file']['name'], $fileType);
					Article::insert($newArticle);
					//var_dump($newArticle);
					header('Location: ./?r=Article/showById&id='.db()->lastInsertId());
				}else{
					echo 'Erreur upload file';
				}
			}
		}
		$this->render("formcreate");
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