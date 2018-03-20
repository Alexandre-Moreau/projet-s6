<?php

class Relation extends Model{

	static public $tableName = "relation";
	protected $id;
	protected $type;
	protected $conceptFrom;
	protected $conceptTo;

	public function __construct($pType, $pConceptFrom, $pConceptTo, $pId = null){
		$this->id = $pId;
		$this->type = $pType;
		$this->conceptFrom = $pConceptFrom;
		$this->conceptTo = $pConceptTo;
	}

	static public function findById($pId){
		$query = db()->prepare("SELECT * FROM ".self::$tableName." WHERE id = ".$pId."");
		$query->execute();
		if ($query->rowCount() > 0){
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];
			$type = $row['type'];
			$conceptFrom = Concept::findById($row['conceptFrom_id']);
			$conceptTo = Concept::findById($row['conceptTo_id']);
			return new Relation($type, $conceptFrom, $conceptTo, $id);
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

	static public function insert($relation) {
		$requete = "INSERT INTO ".self::$tableName." VALUES (DEFAULT, '".$relation->type."', ".$relation->conceptFrom->id.", ".$relation->conceptTo->id.")";
		//var_dump($relation);
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function update($relation){
		$requete = "UPDATE ".self::$tableName." SET type='".$relation->type."', conceptFrom_id=".$relation->conceptFrom->id.", conceptTo_id=".$relation->conceptTo->id." WHERE id=".$relation->id;
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function delete($relation){
		$query = db()->prepare("DELETE FROM ".self::$tableName." WHERE id=".$relation->id);
		$query->execute();
	}
}

?>
