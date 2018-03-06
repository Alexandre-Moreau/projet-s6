<?php

//Auto-generated file
class Concept extends Model{

	static public $tableName = "concept";
	protected $id;
	protected $nom;
	protected $conceptsFils;

	public function __construct($pNom, $pId = null, $conceptsFils=null){
		$this->id = $pId;
		$this->nom = $pNom;
		$this->conceptsFils = $conceptsFils;
	}

	static public function findById($pId){
		$query = db()->prepare("SELECT * FROM ".self::$tableName." WHERE id = ".$pId."");
		$query->execute();
		if ($query->rowCount() > 0){
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];
			$nom = $row['nom'];
			$conceptsFils = [];
			return new Concept($nom, $id, $conceptsFils);
		}
		return null;
	}
	
	static public function findByIdWithChildrens($pId){
		$query = db()->prepare("SELECT * FROM ".self::$tableName." WHERE id = ".$pId."");
		$query->execute();
		if ($query->rowCount() > 0){
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];
			$nom = $row['nom'];
			//récupération des concepts fils
			$query = db()->prepare("SELECT conceptFrom_id FROM relation WHERE type=\"isA\" and conceptTo_id=".$pId);
			$query->execute();
			$conceptsFils = [];
			if ($query->rowCount() > 0){
				$results = $query->fetchAll();
				foreach ($results as $row) {
					array_push($conceptsFils, self::findByIdWithChildrens($row["conceptFrom_id"]));
				}
			}
			return new Concept($nom, $id, $conceptsFils);
		}
		return null;
	}

	static public function findByName($pNom){
		$query = db()->prepare("SELECT * FROM ".self::$tableName." WHERE nom = '".$pNom."'");
		$query->execute();
		if ($query->rowCount() > 0){
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];
			$nom = $row['nom'];
			return new Concept($nom, $id);
		}
		return null;
	}

	static public function findAll(){
		$query = db()->prepare("SELECT id FROM ".self::$tableName);
		$query->execute();
		$returnList = [];
		if ($query->rowCount() > 0){
			$results = $query->fetchAll();
			foreach ($results as $row) {
				array_push($returnList, self::FindById($row["id"]));
			}
		}
		return $returnList;
	}
	
	static public function findAllWithChildrens(){
		$requete = "SELECT id FROM concept WHERE concept.id NOT IN(SELECT conceptFrom_id FROM relation WHERE type=\"isA\")";
		$query = db()->prepare($requete);
		$query->execute();
		$returnList = [];
		if ($query->rowCount() > 0){
			$results = $query->fetchAll();
			foreach ($results as $row) {
				array_push($returnList, self::findByIdWithChildrens($row["id"]));
			}
		}
		return $returnList;
	}
	
	static public function findRoots(){
		$requete = "SELECT id FROM concept WHERE concept.id NOT IN(SELECT conceptFrom_id FROM relation WHERE type=\"isA\")";
		echo $requete;
		$query = db()->prepare($requete);
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

	static public function deleteAll(){
		$query = db()->prepare("DELETE FROM ".self::$tableName);
		$query->execute();
	}
}

?>