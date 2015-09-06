<?php
require_once("../includes/classes/bootstrap.php");
$Database = $_GLOBALS['Database'];
$sessionID = $_GLOBALS['sessionID'];
header("Content-Type: text/event-stream");

function pushToClient($message) {
	echo "data: {$message}" . PHP_EOL;
	echo PHP_EOL;

	ob_end_flush();
	flush();
}

for($i = 0; $i < 60; $i++) {
	if(!empty($sessionID)) {
		pushToClient($Database->getGameData($sessionID,$_GET['passcode']));
	} else {
		pushToClient($Database->getGameSessions());
	}
	
	sleep(1);
}