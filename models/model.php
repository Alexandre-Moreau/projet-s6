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

	public static function toArray($object){
		$arr = [];
		foreach ($object as $key => $value) {
			if(is_object($value) || gettype($value) === "object"){
				$arr[$key] = self::toArray($value);
			}else if(is_array($value) || gettype($value) === "array"){
				$arr[$key] = [];
				foreach($value as $k => $v){
					array_push($arr[$key], self::toArray($v));
				}
			}else{
				$arr[$key] = $value;
			}
		}
		return $arr;
	}
}

?>
