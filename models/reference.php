<?php

//Auto-generated file
class Reference extends Model{

	static public $tableName = "reference";
	private $id;
	private $nombreRef;
	private $article;
	private $concept;

	public function __construct($pNombreRef, $pArticle, $pConcept, $pId = null){
		$this->id = $pId;
		$this->nombreRef = $pNombreRef;
		$this->article = $pArticle;
		$this->concept = $pConcept;
	}

	static public function findById($pId){
		$query = db()->prepare("SELECT * FROM ".self::$tableName." WHERE id = ".$pId."");
		$query->execute();
		if ($query->rowCount() > 0){
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];
			$nombreRef = $row['nombreRef'];
			$article = Article::FindById($row['article_id']);
			$concept = Concept::FindById($row['concept_id']);
			return new Reference($nombreRef, $article, $concept, $id);
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

	static public function insert($reference) {
		$requete = "INSERT INTO ".self::$tableName." VALUES (DEFAULT, ".$reference->nombreRef.", ".$reference->article->id.", ".$reference->concept->id.")";
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function update($reference){
		$requete = "UPDATE ".self::$tableName." SET nombreRef=".$reference->nombreRef.", article_id=".$reference->article->id.", concept_id=".$reference->concept->id." WHERE id=".$reference->id;
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function delete($pId){
		$query = db()->prepare("DELETE FROM ".self::$tableName." WHERE id=".$reference->id);
		$query->execute();
	}
}

?>