<?php
//Gestion langues

if($_ENV["langue"] == "fr")
	include "traductions/fr.inc";
else if ($_ENV["langue"]== "en")
	include "traductions/en.inc";
else if ($_ENV["langue"] == "cn")
	include "traductions/cn.inc";
	
//Auto-generated file

// Accès POST ou GET indifférent
$parameters = array();
if (isset($_POST))
	foreach($_POST as $k=>$v)
		$parameters[$k] = $v;
if (isset($_GET))
	foreach($_GET as $k=>$v)
		$parameters[$k] = $v;

// Pour accès ultérieur sans "global"
function parameters() {
	global $parameters;
	return $parameters;
}

// Gestion de la route : paramètre r = controller/action
if (isset(parameters()["r"])) {
	$route = parameters()["r"];
	if (strpos($route,"/") === FALSE)
		list($controller, $action) = array($route, "index");
	else
		list($controller, $action) = explode("/", $route);
	$controller = ucfirst($controller)."Controller";
	if(strpos($action,"ajax") === FALSE){
		include_once "views/header.php";
		$c = new $controller();
		$c->$action();
		include_once "views/footer.php";
	}else{
		$c = new $controller();
		$c->$action();
	}
} else {
	include_once "views/header.php";
	$c = new SiteController();
	$c->index();
	include_once "views/footer.php";
}

?>