<?php

//Auto-generated file
class Terme extends Model{

	static public $tableName = "terme";
	private $id;
	private $motCle;
	private $langue;

	public function __construct($pMotCle, $pLangue, $pId = null){
		$this->id = $pId;
		$this->motCle = $pMotCle;
		$this->langue = $pLangue;
	}

	static public function findById($pId){
		$query = db()->prepare("SELECT * FROM ".self::$tableName." WHERE id = ".$pId."");
		$query->execute();
		if ($query->rowCount() > 0){
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];
			$motCle = $row['motCle'];
			$langue = Langue::FindById($row['langue_id']);
			return new Terme($motCle, $langue, $id);
		}
		return null;
	}

	static public function findAll($pId){
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

	static public function insert($terme) {
		$requete = "INSERT INTO ".self::$tableName." VALUES (DEFAULT, '".$terme->motCle."', ".$terme->langue->id.")";
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function update($terme){
		$requete = "UPDATE ".self::$tableName." SET motCle='".$terme->motCle."', langue_id=".$terme->langue->id." WHERE id=".$terme->id;
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function delete($pId){
		$query = db()->prepare("DELETE FROM ".self::$tableName." WHERE id=".$terme->id);
		$query->execute();
	}
}

?>