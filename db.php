<?php

$host = $_ENV['host'];
$databaseName = $_ENV['databaseName'];
$user = $_ENV['db_user'];
$password = $_ENV['db_password'];

$db;

$errorCodes = [
	1 => 'succes',
	1045 => 'error nom utilisateur/mdp incorrect',
	1049 => 'error nom db inconnu',
	2002 => 'error hote inconnu',
	2003 => 'error connexion hote',
	2005 => 'error hote inconnu'
];

function db(){
	global $host;
	global $databaseName;
	global $user;
	global $password;

	global $db;

	$db = new PDO("mysql:host=".$host.";dbname=".$databaseName, $user, $password, array(
				PDO::ATTR_EMULATE_PREPARES=>false,
				PDO::MYSQL_ATTR_DIRECT_QUERY=>false,
				PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

	$db->exec("SET CHARACTER SET utf8");

	return $db;
}

function dbTest($existing = true){
	$statut = [];

	global $host;
	global $databaseName;
	global $user;
	global $password;
	global $errorCodes;
	
	try{
		if($existing){
			@$dbh = new PDO("mysql:host=".$host.";dbname=".$databaseName, $user, $password, array(
				PDO::ATTR_EMULATE_PREPARES=>false,
				PDO::MYSQL_ATTR_DIRECT_QUERY=>false,
				PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
		}else{
			@$dbh = new PDO("mysql:host=".$host, $user, $password, array(
				PDO::ATTR_EMULATE_PREPARES=>false,
				PDO::MYSQL_ATTR_DIRECT_QUERY=>false,
				PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
		}
		$statut['reussite'] = 1;
		$statut['message'] = $errorCodes[1];
	}
	catch(PDOException $ex){
		$statut['reussite'] = 0;
		$statut['message'] = $errorCodes[$ex->getCode()] ;
	}
	return $statut;
}

?>
