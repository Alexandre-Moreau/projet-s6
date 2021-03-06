<?php

class Terme extends Model{

	static public $tableName = "terme";
	protected $id;
	protected $motCle;
	protected $langue;
	protected $concept;
	protected $prefered;

	public function __construct($pMotCle, $pLangue, $pConcept, $pPrefered = true, $pId = null){
		$this->id = $pId;
		$this->motCle = addslashes($pMotCle);
		$this->langue = $pLangue;
		$this->concept = $pConcept;
		$this->prefered = $pPrefered;
	}

	static public function findById($pId){
		$query = db()->prepare("SELECT * FROM ".self::$tableName." WHERE id = ".$pId."");
		$query->execute();
		if ($query->rowCount() > 0){
			$row = $query->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];
			$motCle = addslashes($row['motCle']);
			$langue = Langue::findById($row['langue_id']);
			$concept = Concept::findById($row['concept_id']);
			$prefered = ($row['prefered']!=0);
			return new Terme($motCle, $langue, $concept, $prefered, $id);
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
	
	static public function findAllPrefered($langue=null){
		$requete = "SELECT id FROM ".self::$tableName." WHERE prefered=1";
		if($langue!=null){
			$requete.=" AND langue_id=".$langue->id;
		}
		$query = db()->prepare($requete);
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
	
	//Basé sur le findAll (résultats multiples possibles)
	static public function FindByMotCleLangue($textArray, $langue){

		$requete = "SELECT id FROM ".self::$tableName." WHERE langue_id=".$langue->id;
		$i = 0;
		$len = count($textArray);
		$requete .= " AND (";
		if($len == 0){
			$requete .= "1 = 2"; //Ne retourne aucun élément
		}
		foreach($textArray as $word){
			if(substr($word, -1) == '.'){
				$word = substr($word, 0, -1);
			}
			$requete .= " LOWER(motCle) = LOWER('".addslashes($word)."')";
			if($i != $len-1){
				$requete .= " OR";
			}
			$i++;
		}
		$requete .= ")";
		//echo $requete;
		$query = db()->prepare($requete);
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
	
	static public function findByMotCleLangueSpace($textArray, $langue){
		$requete = "SELECT id FROM ".self::$tableName." WHERE langue_id=".$langue->id;
		$i = 0;
		$len = count($textArray);
		$requete .= " AND (";
		if($len == 0){
			$requete .= "1 = 2"; //Ne retourne aucun élément
		}
		foreach($textArray as $word){
			if(substr($word, -1) == '.'){
				$word = substr($word, 0, -1);
			}
			$requete .= " LOWER(motCle) LIKE LOWER('".addslashes($word)." %')";
			if($i != $len-1){
				$requete .= " OR";
			}
			$i++;
		}
		$requete .= ")";
		//echo $requete;
		$query = db()->prepare($requete);
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

	static public function insert($terme) {
		$requete = "INSERT INTO ".self::$tableName." VALUES (DEFAULT, '".addslashes($terme->motCle)."', ".$terme->langue->id.", ".$terme->concept->id.", ".(int)$terme->prefered.")";
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function update($terme){
		$requete = "UPDATE ".self::$tableName." SET motCle='".addslashes($terme->motCle)."', langue_id=".$terme->langue->id.", ".$terme->concept->id." WHERE id=".$terme->id;
		//echo $requete;
		$query = db()->prepare($requete);
		$query->execute();
	}

	static public function delete($pId){
		$query = db()->prepare("DELETE FROM ".self::$tableName." WHERE id=".$terme->id);
		$query->execute();
	}

	static public function deleteAll(){
		$query = db()->prepare("DELETE FROM ".self::$tableName);
		$query->execute();
	}
}

?>