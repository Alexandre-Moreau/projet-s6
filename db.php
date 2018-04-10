<?php

$host = "localhost";
$databaseName = "projet-s6";
$user = $_ENV["db_user"];
$password = $_ENV["db_password"];

$db = new PDO("mysql:host=".$host.";dbname=".$databaseName, $user, $password, array(
			PDO::ATTR_EMULATE_PREPARES=>false,
			PDO::MYSQL_ATTR_DIRECT_QUERY=>false,
			PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

$db->exec("SET CHARACTER SET utf8");

function db(){
	global $db;
	return $db;
}

function dbTest($existing = true){
	$statut = [];
	global $host;
	global $databaseName;
	global $user;
	global $password;
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
		$statut['statut'] = 1;
	}
	catch(PDOException $ex){
		$statut['statut'] = 0;
		$statut['message'] = $ex->getCode() ;
	}
	return $statut;
}

$errorCodes = [
	1045 => 'error nom utilisateur/mdp incorrect',
	1049 => 'error nom db inconnu',
	2002 => 'error hote inconnu'
];

?>