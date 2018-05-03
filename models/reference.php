<?php

class Reference extends Model{

	static public $tableName = "reference";
	protected $id;
	protected $position;
	protected $nombreMot;
	protected $contexte;
	protected $article;
	protected $concept;

	public function __construct($pPosition, $pNombreMot, $pContexte, $pArticle, $pConcept, $pId = null){
		$this->id = $pId;
		$this->position = $pPosition;
		$this->nombreMot = $pNombreMot;
		$this->contexte = $pContexte;
		$this->article = $pArticle;
		$this->concept = $pConcept;
	}

	static public function findById($pId){
		$query = db()->prepare("SELECT * FROM ".self::$tableName." WHERE id = ".$pId."");
		$query->execute();
		if ($query->rowCount() > 0){
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];
			$position = $row['position'];
			$nombreMot = $row['nombreMot'];
			$contexte = $row['contexte'];
			$article = Article::findById($row['article_id']);
			$concept = Concept::findById($row['concept_id']);
			return new Reference($position, $nombreMot, $contexte, $article, $concept, $id);
		}
		return null;
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

	static public function findByArticle($article){
		$query = db()->prepare("SELECT id FROM ".self::$tableName." WHERE article_id=".$article->id." ORDER BY position");
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

	static public function insert($reference) {
		$requete = "INSERT INTO ".self::$tableName." VALUES (DEFAULT, ".$reference->position.", ".$reference->nombreMot.", '".$reference->contexte."', ".$reference->article->id.", ".$reference->concept->id.")";
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function update($reference){
		$requete = "UPDATE ".self::$tableName." SET position=".$reference->position.", nombreMot=".$reference->nombreMot.", contexte='".$reference->contexte."', article_id=".$reference->article->id.", concept_id=".$reference->concept->id." WHERE id=".$reference->id;
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function delete($pId){
		$query = db()->prepare("DELETE FROM ".self::$tableName." WHERE id=".$reference->id);
		$query->execute();
	}
	
	static public function deleteAll(){
		$query = db()->prepare("DELETE FROM ".self::$tableName);
		$query->execute();
	}
}

?>
