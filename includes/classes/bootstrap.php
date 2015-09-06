<?php
function createSession() {
	$alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	
	$key = str_shuffle($alphanum);
	return sha1($key);
}

$sessionID = false;
if(preg_replace("/\?.*/","",$_SERVER['REQUEST_URI']) == "/ajax.php" || preg_replace("/\?.*/","",$_SERVER['REQUEST_URI']) == "/streaming.php") {
	if($_SERVER['REQUEST_METHOD'] == "PUT") {
		$_PUT = (array)json_decode(file_get_contents("php://input"));
		$_GLOBALS['_PUT'] = $_PUT;
		if(array_key_exists("sessionID",$_PUT)) {
			$sessionID = $_PUT['sessionID'];
		}
	} elseif($_SERVER['REQUEST_METHOD'] == "GET" && array_key_exists("sessionID", $_GET)) {
		$sessionID = $_GET['sessionID'];
	}
} else {
	$sessionID = trim(preg_replace("/(ajax|streaming)\.php/","",$_SERVER['REQUEST_URI']),"/");
}

if(empty($sessionID)) {	
	if($_SERVER['REQUEST_URI'] != "/ajax.php") {
		header("Location: ".createSession());
	}
}

$config = parse_ini_file("../config/database.ini");
require_once(__DIR__.'/drivers/MysqlDriver.php');
$Database = MysqlDriver::getInstance($config['username'], $config['password'],$config['host'],$config['database']);
$Database->connect();
$_GLOBALS['Database'] = $Database;
$_GLOBALS['sessionID'] = $sessionID;