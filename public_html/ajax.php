<?php
require_once("../includes/classes/bootstrap.php");
$Database = $_GLOBALS['Database'];
$sessionID = $_GLOBALS['sessionID'];


if($_SERVER['REQUEST_METHOD'] == "PUT") {
	$_PUT = $_GLOBALS['_PUT'];
	if(array_key_exists("data",$_PUT)) {
		$Database->setGameData($sessionID,json_encode($_PUT['data']),$_PUT['numOfPlayers'], $_PUT['passcode'],$_PUT['name']);
	}
} elseif($_SERVER['REQUEST_METHOD'] == "GET") {
	if(!empty($sessionID)) {
		echo($Database->getGameData($sessionID,$_GET['passcode']));
	} else {
		echo($Database->getGameSessions());
	}
}

exit;