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
		// execute trim() sur chaque element de listeConcepts
		array_walk($listeConcepts, 'trim');
		/*foreach($listeConcepts as $listeConcepts){
			
		}*/
		$requete = "SELECT article_id, nombreRef FROM reference WHERE concept_id IN (SELECT id FROM concept WHERE nom='".$listeConcepts[0]."')";
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
			$returnList[$key][1] = self::calculeScoreContexte($returnList[$key][0], Concept::findByName($listeConcepts[0]));
		}
		
		// Liste ordonnée par score
		usort($returnList, "self::compareScore");
		
		return $returnList;
	}
	
	static private function compareScore($articleScore0, $articleScore1){
		return ($articleScore0[1] > $articleScore1[1]) ? -1 : 1;
	}
	
	static public function calculeScoreContexte($article, $concept){
		$score = 0;
		//Basé sur le référencement (articleController::reference)
		$text = processContent($article);
		$textArray = explode(' ', $text);
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
		
		$score = round($score/$article->nbMots*100, 1);
		
		
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
		return $returnList;
	}
	
	static public function deleteFile($article){
		unlink("./".$article->chemin);
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
