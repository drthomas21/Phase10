<?php
require_once("../includes/classes/bootstrap.php");
$Database = $_GLOBALS['Database'];
$sessionID = $_GLOBALS['sessionID'];


if($_SERVER['REQUEST_METHOD'] == "PUT") {
	$_PUT = $_GLOBALS['_PUT'];
	if(array_key_exists("data",$_PUT)) {
		$Database->setGameData($sessionID,json_encode($_PUT['data']));
	}
} elseif($_SERVER['REQUEST_METHOD'] == "GET") {
	echo($Database->getGameData($sessionID));
}

exit;