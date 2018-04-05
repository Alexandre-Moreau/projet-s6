<?php

//Debug. Désactiver en prod
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

session_start();

require 'vendor/autoload.php';

include_once 'env.php';
include_once 'global.php';
include_once 'session.php';

include_once 'db.php';
include_once 'tools.php';

require_once('vendor/autoload.php');

date_default_timezone_set('Europe/Paris');
include_once 'controllers/route.php';

?>