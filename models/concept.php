<?php

//Auto-generated file
class Concept extends Model{

	static public $tableName = "concept";
	private $id;
	private $nom;

	public function __construct($pNom, $pId = null){
		$this->id = $pId;
		$this->nom = $pNom;
	}

	static public function findById($pId){
		$query = db()->prepare("SELECT * FROM ".self::$tableName." WHERE id = ".$pId."");
		$query->execute();
		if ($query->rowCount() > 0){
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];
			$nom = $row['nom'];
			return new Concept($nom, $id);
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

	static public function insert($concept) {
		$requete = "INSERT INTO ".self::$tableName." VALUES (DEFAULT, '".$concept->nom."')";
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function update($concept){
		$requete = "UPDATE ".self::$tableName." SET nom='".$concept->nom."' WHERE id=".$concept->id;
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function delete($pId){
		$query = db()->prepare("DELETE FROM ".self::$tableName." WHERE id=".$concept->id);
		$query->execute();
	}
}

?>