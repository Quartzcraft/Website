<?php
	header('Content-Type: application/json');
	require_once('index.php');
	require_once('classes/group.php');
	
	$value = array("error" => "Missing argument");
	
	if (isset($_GET["action"])) {
		switch ($_GET["action"]) {
	    	case "getGroup":
				if (isset($_GET["id"])) {
					//Get player by id
					$value = getGroup($_GET["id"]);
					if($value == false)
						$value = array("error" => "No group");
				} else {
					$value = array("error" => "Missing argument");
				}
			   	break;
			case "getAllGroups":
				$value = getAllGroups();
				if($value == false)
					$value = array("error" => "No groups");
				break;
	    }
	}
	
	exit(json_encode($value));
?>