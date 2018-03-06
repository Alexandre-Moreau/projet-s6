<?php

//Auto-generated file
class Article extends Model{

	static public $tableName = "article";
	protected $id;
	protected $nom;
	protected $chemin;
	protected $type;
	protected $nbMots;

	public function __construct($pNom, $pChemin, $pType, $pNbMots, $pId = null){
		$this->id = $pId;
		$this->nom = $pNom;
		$this->chemin = $pChemin;
		$this->type = $pType;
		$this->nbMots = $pNbMots;
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
			return new Article($nom, $chemin, $type, $nbMots, $id);
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
			return new Article($nom, $chemin, $type, $nbMots, $id);
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
	
	

	static public function insert($article){
		$requete = "INSERT INTO ".self::$tableName." VALUES (DEFAULT, '".$article->nom."', '".$article->chemin."', '".$article->type."', ".$article->nbMots.")";
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function update($article){
		$requete = "UPDATE ".self::$tableName." SET nom='".$article->nom."', chemin='".addslashes($article->chemin)."', type='".$article->type."' WHERE id=".$article->id;
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function delete($pId){
		$query = db()->prepare("DELETE FROM ".self::$tableName." WHERE id=".$article->id);
		$query->execute();
	}
}

?>
