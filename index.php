<?php

//Auto-generated file
//Debug. Désactiver en prod
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

include_once "db.php";
include_once "tools.php";

session_start();

include_once "views/header.php";
date_default_timezone_set('Europe/Paris');
include_once "controllers/route.php";
include_once "views/footer.php";

?>