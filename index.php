<?php

//Auto-generated file
//Debug. Désactiver en prod
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

require 'vendor/autoload.php';
include_once 'env.php';
include_once 'db.php';
include_once 'tools.php';

require_once('vendor/autoload.php');

session_start();


date_default_timezone_set('Europe/Paris');
include_once 'controllers/route.php';

?>