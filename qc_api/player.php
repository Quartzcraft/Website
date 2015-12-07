<?php
	header('Content-Type: application/json');
	require_once('index.php');
	require_once('classes/player.php');
	
	$value = array("error" => "Missing argument");
	
	if (isset($_GET["action"])) {
		switch ($_GET["action"]) {
	    	case "getPlayer":
				if (isset($_GET["id"])) {
					//Get player by id
					$value = getPlayer($_GET["id"]);
					if($value == false)
						$value = array("error" => "No player");
				} else {
					$value = array("error" => "Missing argument");
				}
			   	break;
			case "getPlayerByName":
				if (isset($_GET["username"])) {
					//Get player by name
					$value = getPlayerByName($_GET['username']);
				} else {
					$value = array("error" => "Missing argument");
				}
			   	break;
			case "reportPlayer":
				if(isset($_GET["id"]) && isset($_GET["reporting_id"]) && isset($_GET["report"]) && isset($_GET['apikey'])) {
					if($_GET['apikey'] == _API_KEY_) {
						//Get player by id
						$value = reportPlayer($_GET['id'], $_GET["report"], $_GET["reporting_id"]);
					} else {
						$value = array("error" => "Invalid API key");
					}
				} else {
					$value = array("error" => "Missing argument");
				}
			   	break;
			case "getMods":
				if(isset($_GET["value"])) {
					//Get player names
					$value = getMods($_GET["value"]);
				} else {
					$value = getMods(null);
				}
			   	break;
			case "getSS":
				if(isset($_GET["value"])) {
					//Get player names
					$value = getSeniorStaff($_GET["value"]);
				} else {
					$value = getSeniorStaff(null);
				}
			   	break;
			case "getNewestPlayers":
				if(isset($_GET["limit"]) && isset($_GET['value'])) {
					//Get player names
					$value = getNewestPlayers($_GET["limit"], $_GET['value']);
				} else {
					$value = getNewestPlayers(null, null);				}
			   	break;
			case "getNumPlayers":
				$value = getNumPlayers();
			   	break;
			case "updatePlayerGroup":
				if (isset($_GET["id"]) && isset($_GET['apikey']), isset($_GET['primaryGroupID'])) {
					if($_GET['apikey'] == _API_KEY_) {
						$value = updatePlayerGroup($_GET['id'], $_GET('primaryGroupID'));
					} else {
						$value = array("error" => "Invalid API key");
					}
				} else {
					$value = array("error" => "Missing argument");
				}
			   	break;
	    }
	}
	
	exit(json_encode($value));
?>