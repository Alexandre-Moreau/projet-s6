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

?>