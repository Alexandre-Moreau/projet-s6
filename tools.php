<?php

//Auto-generated file
function __autoload($name) {
	$dir = "models";
	if (strpos($name,"Controller") !== FALSE)
		$dir = "controllers";
	include_once $dir."/".$name.".php";
}

?>