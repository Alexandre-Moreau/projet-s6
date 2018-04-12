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
		// [r1, r2, r3, ...] avec r1 la liste des articlesScore de la première recherche, r2 la liste renvoyée par la 2e recherche...
		$listeSortieRecherche = [];
		// [a1, a2, a3, ...] avec a1 = ['articleA', 14], a2 = ['articleB', 5], a3 = ['articleC', 12] ...
		$listeArticlesScore = [];
		
		$data = [];
		$data['log'] = [];
		$data['articlesScoreContexte'] = [];
		
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
		
		// $l = liste d'articles pour chaque concept
		foreach($listeSortieRecherche as $l){
			// $articleScore = ['articleA', 14]
			foreach($l as $articleScore){
				$trouve = false;
				// On ajoute l'articleScore à la liste d'articleScore, si il est déjà dedans on ajoute juste le score
				foreach($listeArticlesScore as $key => $value){
					if($listeArticlesScore[$key][0] == $articleScore[0]){
						$listeArticlesScore[$key][1] += $articleScore[1];
						$trouve = true;
						break;
					}
				}
				if(!$trouve){
					array_push($listeArticlesScore, [$articleScore[0], $articleScore[1], 'contexte lorem ipsum']);
				}
			}
		}
		
		// On fait la moyenne des scores (division par le nombre de concepts qu'on a cherché), on arrondit et on renvoie les articles avec leur score
		$nbConcepts = count($conceptSearched);
		foreach($listeArticlesScore as $key => $value){		
			$listeArticlesScore[$key][1] = round($listeArticlesScore[$key][1]/$nbConcepts, 1);
			array_push($data['articlesScoreContexte'], $listeArticlesScore[$key]);
		}
		
		usort($data['articlesScoreContexte'], "self::compareScore");
		
		return $data;
		
	}
	
	static private function findByConceptCalcScore($concept){
		$requete = "SELECT article_id, nombreRef FROM reference WHERE concept_id = ".$concept->id;
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
		$returnList = [];
		$maxNbRef = 0;
		
		// Récupération des objets
		if ($query->rowCount() > 0){
			$results = $query->fetchAll();
			foreach ($results as $row) {
				array_push($returnList, [self::FindById($row['article_id']), $row['nombreRef']]);
				if($row['nombreRef'] > $maxNbRef){
					$maxNbRef = $row['nombreRef'];
				}
			}
		}
		
		// Calcul du score
		foreach ($returnList as $key => $value){
			// On regarde le nombre d'occurences par rapport au max
			//$returnList[$key][1] = ($returnList[$key][1]/$maxNbRef)*100;
			
			// On regarde le nombre d'occurences par nombre de mots
			$returnList[$key][1] = self::calculeScoreContexte($returnList[$key][0], $concept);
		}
		
		return $returnList;
	}
	
	static private function compareScore($articleScore0, $articleScore1){
		return ($articleScore0[1] > $articleScore1[1]) ? -1 : 1;
	}
	
	static public function calculeScoreContexte($article, $concept){
		$score = 0;
		//Basé sur le référencement (articleController::reference)
		$text = processContent($article);		
		if($article->langue->nom == 'cn'){
			$textArray = separeMotsChinois($text);
		}else{
			$textArray = explode(' ', $text);
		}
		$langue = $article->langue;
		
		$termes = Terme::findByMotCleLangue($textArray, $langue);
		$termesEspace = Terme::findByMotCleLangueSpace($textArray, $langue);
		
		$concepts = [];
		
		$i = 0;		
		while($i < count($textArray)){
			$motEspaceTraite = false;			
			$mot = $textArray[$i];
			
			foreach($termesEspace as $termeEspace){
				$j = 0;				
				foreach(explode(' ', $termeEspace->motCle) as $motCourantTermeEspace){
					if($i+$j < count($textArray) && strtolower($textArray[$i+$j]) == strtolower($motCourantTermeEspace)){
						if($j == count(explode(' ', $termeEspace->motCle))-1){
							if(!isset($concepts[$termeEspace->concept->id])){
								// On ajoute la longueur du terme ($j) et non 1 (pour après regarder le pourcentage de couverture du terme dans l'article)
								$concepts[$termeEspace->concept->id] = $j;
							}else{
								$concepts[$termeEspace->concept->id] = $termeEspace[$terme->concept->id]+$j;
							}
							$i = $i+$j;
							$motEspaceTraite = true;
							break;
						}
						$j++;						
					}else{
						break;
					}
				}
			}
			
			if(!$motEspaceTraite){
				foreach($termes as $terme){
					if (strtolower($mot) == strtolower($terme->motCle)){
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
			if($conceptId == $concept->id){
				$score+=$nombreOccurence;
			}else{
				//On regade si le concept de la boucle fait partie des sous concept du concept à calculer
				if(Concept::verticalDistance($concept, Concept::findById($conceptId))>0){
					$score+=$nombreOccurence*1000;
				}
			}
		}
		
		$score = $score/$article->nbMots*100;
		
		return $score;
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
		// $langue = $article->langue;
		//$array['langue'] = (array) $langue;
		return $array;
	}
}

?>
