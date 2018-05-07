<?php

//Auto-generated file
class Article extends Model{

	static public $tableName = "article";
	public $id;
	public $nom;
	public $chemin;
	public $type;
	public $nbMots;
	public $langue;

	public function __construct($pNom, $pChemin, $pType, $pNbMots, $pLangue, $pId = null){
		$this->id = $pId;
		$this->nom = $pNom;
		$this->chemin = $pChemin;
		$this->type = $pType;
		$this->nbMots = $pNbMots;
		$this->langue = $pLangue;
	}

	static public function findById($pId){
		$query = db()->prepare("SELECT * FROM ".self::$tableName." WHERE id = ".$pId."");
		$query->execute();
		if ($query->rowCount() > 0){
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];
			$nom = $row['nom'];
			$chemin = $row['chemin'];
			$type = $row['type'];
			$nbMots = $row['nbMots'];
			$langue = Langue::findById($row['langue_id']);
			return new Article($nom, $chemin, $type, $nbMots, $langue, $id);
		}
		return null;
	}
	
	static public function findByChemin($pChemin){
		$query = db()->prepare("SELECT * FROM ".self::$tableName." WHERE chemin = '".addslashes($pChemin)."'");
		$query->execute();
		if ($query->rowCount() > 0){
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];
			$nom = $row['nom'];
			$chemin = $row['chemin'];
			$type = $row['type'];
			$nbMots = $row['nbMots'];
			$langue = Langue::findById($row['langue_id']);
			return new Article($nom, $chemin, $type, $nbMots, $langue, $id);
		}
		return null;
	}
	
	static public function findAllWithoutRef(){
		$query = db()->prepare("SELECT id FROM ".self::$tableName." WHERE id NOT IN (SELECT DISTINCT article_id FROM reference)");
		$query->execute();
		$returnList = array();
		if ($query->rowCount() > 0){
			$results = $query->fetchAll();
			foreach ($results as $row) {
				array_push($returnList, self::FindById($row["id"]));
			}
		}
		return $returnList;
	}
	
	static public function findAll(){
		$query = db()->prepare("SELECT id FROM ".self::$tableName);
		$query->execute();
		$returnList = array();
		if ($query->rowCount() > 0){
			$results = $query->fetchAll();
			foreach ($results as $row) {
				array_push($returnList, self::FindById($row["id"]));
			}
		}
		return $returnList;
	}
	
	static public function findByQuery($requeteConcept){
		$listeConcepts = explode(',', $requeteConcept);
		// On note les concepts qu'on a déjà recherché
		$conceptSearched = [];
		// [r1, r2, r3, ...] avec r1 la liste des articleRefsScore de la première recherche, r2 la liste renvoyée par la 2e recherche...
		$listeSortieRecherche = [];
		// [a1, a2, a3, ...] avec a1 = ['articleA', 14], a2 = ['articleB', 5], a3 = ['articleC', 12] ...
		$listeArticlesReferencesScore = [];
		
		$data = [];
		$data['log'] = [];
		$data['articlesRefScore'] = [];

		// execute trim() sur chaque element de listeConcepts
		$listeConcepts = array_map('trim',$listeConcepts);
		foreach($listeConcepts as $nomConcept){
			if(!in_array($nomConcept, $conceptSearched)){
				$concept = Concept::findByName($nomConcept);
				if($concept != null){
					array_push($listeSortieRecherche, self::findByConceptCalcScore($concept));
				}else{
					array_push($data['log'], 'Concept inconnu: '.$nomConcept);
				}
				array_push($conceptSearched, $nomConcept);
			}else{
				array_push($data['log'], 'Concept en double: '.$nomConcept);
			}
		}

		// $l = liste d'articleRefsScore pour chaque concept
		foreach($listeSortieRecherche as $l){
			// $articleRefScore : $idArticle => [article, [reference0, reference1], score]
			foreach($l as $idArticle => $articleRefScore){
				// On combine les résultats des différenctes recherches
				if(!isset($listeArticlesReferencesScore[$idArticle])){
					$listeArticlesReferencesScore[$idArticle] = $articleRefScore;
				}else{
					$listeArticlesReferencesScore[$idArticle]['score'] = $listeArticlesReferencesScore[$idArticle]['score'] +  $articleRefScore['score'];
				}
			}
		}
		
		// On fait la moyenne des scores (division par le nombre de concepts qu'on a cherché), on arrondit et on renvoie les articles avec leur score
		$nbConcepts = count($conceptSearched);
		foreach($listeArticlesReferencesScore as $key => $value){
			$listeArticlesReferencesScore[$key]['score'] = round($listeArticlesReferencesScore[$key]['score']/$nbConcepts, 1);
		}

		$data['articlesRefScore'] = $listeArticlesReferencesScore;
		usort($data['articlesRefScore'], "self::compareScore");
		
		return $data;
		
	}
	
	static private function findByConceptCalcScore($concept){
		// Retourne [ articleId0 => [article, references, score], articleId1 => [article, references, score], articleId2 => [article, references, score] ]

		$requete = "SELECT id, nombreMot, article_id FROM reference WHERE concept_id = ".$concept->id;
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
		$returnList = [];
		$maxNbRef = 0;
		
		// Récupération des objets
		if ($query->rowCount() > 0){
			$results = $query->fetchAll();
			foreach ($results as $row) {
				if(!isset($returnList[$row['article_id']])){
					$returnList[$row['article_id']] = [];

					$returnList[$row['article_id']]['article'] = Article::findById($row['article_id']);

					$returnList[$row['article_id']]['references'] = [];
					array_push($returnList[$row['article_id']]['references'], Reference::findById($row['id']));

					$returnList[$row['article_id']]['score'] = $row['nombreMot'];
				}else{
					array_push($returnList[$row['article_id']]['references'], Reference::findById($row['id']));
					$returnList[$row['article_id']]['score'] = $returnList[$row['article_id']]['score'] + $row['nombreMot'];
				}
			}
		}

		// Calcul du score
		foreach ($returnList as $key => $value){			
			// On regarde le nombre d'occurences par nombre de mots
			$returnList[$key]['score'] = $returnList[$key]['score'] / $returnList[$key]['article']->nbMots;
		}

		return $returnList;
	}
	
	static private function compareScore($articleRefScore0, $articleRefScore1){
		return ($articleRefScore0['score'] > $articleRefScore1['score']) ? -1 : 1;
	}
	
	static public function getNameAllOnDisk(){
		$namesOnDisk = scandir('./articles/');
		// On enlève les dossiers . et .. et index.php
		unset($namesOnDisk[array_search ('.', $namesOnDisk)]);
		unset($namesOnDisk[array_search ('..', $namesOnDisk)]);
		unset($namesOnDisk[array_search ('index.html', $namesOnDisk)]);
		// On enlève les dossiers éventuels
		foreach($namesOnDisk as $nameOnDisk){
			if(!strpos($nameOnDisk,'.')){
				unset($namesOnDisk[array_search ($nameOnDisk, $namesOnDisk)]);
			}
		}
		return $namesOnDisk;
	}
	
	static public function insert($article){
		$requete = "INSERT INTO ".self::$tableName." VALUES (DEFAULT, '".$article->nom."', '".$article->chemin."', '".$article->type."', ".$article->nbMots.", ".$article->langue->id.")";
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function update($article){
		$requete = "UPDATE ".self::$tableName." SET nom='".$article->nom."', chemin='".addslashes($article->chemin)."', type='".$article->type."', langue_id='".$article->langue->id."' WHERE id=".$article->id;
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function delete($article){
		$query = db()->prepare("DELETE FROM reference WHERE article_id=".$article->id);
		$query->execute();
		$query = db()->prepare("DELETE FROM ".self::$tableName." WHERE id=".$article->id);
		$query->execute();
		self::deleteFile($article);
	}
	
	static public function deleteAll(){
		$query = db()->prepare("SELECT id FROM ".self::$tableName);
		$query->execute();
		if ($query->rowCount() > 0){
			$results = $query->fetchAll();
			foreach ($results as $row) {
				self::delete(self::FindById($row["id"]));
			}
		}
	}
	
	static public function deleteFile($article){
		if(file_exists("./".$article->chemin)){
			unlink("./".$article->chemin);
		}
	}
	
	static public function toArray($article){
		$array = (array) $article;
		$array['langue'] = $article->langue->nom;
		$langue = $article->langue;
		$array['langue'] = $langue;
		return $array;
	}
}

?>
