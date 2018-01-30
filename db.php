<?php

//Auto-generated file
$host = "localhost";
$databaseName = "projet-s6";
$user = $_ENV["db_user"];
$password = $_ENV["db_password"];

$db = new PDO("mysql:host=".$host.";dbname=".$databaseName, $user, $password);
$db->exec("SET CHARACTER SET utf8");

function db(){
	global $db;
	return $db;
}

?>