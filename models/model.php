<?php

//Auto-generated file
abstract class Model{
	public function __construct(){
	}

	public function __get($fieldName) {
		$varName = $fieldName;
		if (property_exists(get_class($this), $varName))
			return $this->$varName;
		else
			throw new Exception("Unknown attribute: ".$fieldName);
	}

	public function __set($fieldname,$value) {
		$this->$fieldname = $value;
	}
}

?>