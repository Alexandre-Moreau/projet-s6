<?php

//Auto-generated file
$data = null;
$option = null;

class Controller{

	public function __construct() {
	}

	public function render($view, $d=null, $componentsBefore=[], $componentsAfter=[], $option=null) {
		global $data;
		global $globOption;

		$controller = get_class($this);
		$model = substr($controller, 0,
		strpos($controller, "Controller"));
		$data = $d;
		$globOption = $option;
		foreach($componentsBefore as $c){
			include_once "views/components/".$c.".php";
		}
		include_once "views/".strtolower($model)."/".$view.".php";
		foreach($componentsAfter as $c){
			include_once "views/components/".$c.".php";
		}
	}
}

?>