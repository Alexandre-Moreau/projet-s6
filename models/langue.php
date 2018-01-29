<?php

//Auto-generated file
class Langue extends Model{

	static public $tableName = "langue";
	protected $id;
	protected $nom;

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
			return new Langue($nom, $id);
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

	static public function insert($langue) {
		$requete = "INSERT INTO ".self::$tableName." VALUES (DEFAULT, '".$langue->nom."')";
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function update($langue){
		$requete = "UPDATE ".self::$tableName." SET nom='".$langue->nom."' WHERE id=".$langue->id;
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function delete($pId){
		$query = db()->prepare("DELETE FROM ".self::$tableName." WHERE id=".$langue->id);
		$query->execute();
	}
}

?>