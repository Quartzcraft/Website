<?php
	require_once("Database.php");
			
	function getNumPlayers() {
		$con = QC_Database::getQuartzcoreDatabase();
		if($number_results = mysqli_query($con, 'SELECT COUNT(DISTINCT id) FROM PlayerData;')) {
			return array('number' => mysqli_fetch_row($number_results)[0]);
		}
		
		return array("error" => "No players");
	}
	
	function getPlayer($id) {
		$con = QC_Database::getQuartzcoreDatabase();
		if (isset($id)) {
			if($player_result = mysqli_query($con, 'SELECT * FROM PlayerData WHERE id=' . $id . ';')) {
				$player = mysqli_fetch_array($player_result, true);
				
				return $player;
			} else {
				return array("error" => "No player");
			}
		} 
	}
	
	function getPlayerByName($username) {
		$con = QC_Database::getQuartzcoreDatabase();
		if (isset($username)) {
			if($player_result = mysqli_query($con, 'SELECT * FROM PlayerData WHERE DisplayName="' . $username . '";')) {
				$player = mysqli_fetch_array($player_result, true);
				
				return $player;
			} else {
				return array("error" => "No player");
			}
		} 
	}
	
	function reportPlayer($id, $reason, $reporting_id) {
		$con = QC_Database::getQuartzcoreDatabase();
		if(isset($id) && isset($reason)) {
			if($player = getPlayer($id)) {

				if(mysqli_query($con, 'INSERT INTO Reports (reported_user_id, reporting_user_id, report_content) VALUES (' . $id . ', ' . $reporting_id . ', "' . $reason . '");')) {
				    return array("reported" => true);
				} else {
				    return array("reported" => false);
				}
			} else {
				return array("error" => "No player");
			}
		} 
	}
		
	function getMods($value) {
		$con = QC_Database::getQuartzcoreDatabase();
		$mods = array();
		if(isset($value)) {
			switch ($value) {
				case "name":
					if($mod_results = mysqli_query($con, 'SELECT * FROM PlayerData WHERE PrimaryGroupId=95;')) {
						while($mod = mysqli_fetch_array($mod_results)) {
							array_push($mods, $mod['DisplayName']);
						}
					} else {
						$mods['error'] = 'No mods';
					}
					break;
			}
		}  else {
			if($mod_results = mysqli_query($con, 'SELECT * FROM PlayerData WHERE PrimaryGroupId=95;')) {
				while($mod = mysqli_fetch_array($mod_results)) {
					array_push($mods, $mod['id']);
				}
			} else {
				$mods['error'] = 'No mods';
			}
		}
		return $mods;
	}
	
	function getSeniorStaff($value) {
		$con = QC_Database::getQuartzcoreDatabase();
		$ss = array();
		if(isset($value)) {
			switch ($value) {
				case "name":
					if($ss_results = mysqli_query($con, 'SELECT * FROM PlayerData WHERE PrimaryGroupId=97;')) {
						while($sss = mysqli_fetch_array($ss_results)) {
							array_push($ss, $sss['DisplayName']);
						}
					} else {
						$ss['error'] = 'No ss';
					}
					break;
			}
		}  else {
			if($ss_results = mysqli_query($con, 'SELECT * FROM PlayerData WHERE PrimaryGroupId=97;')) {
				while($sss = mysqli_fetch_array($ss_results)) {
					array_push($ss, $sss['id']);
				}
			} else {
				$ss['error'] = 'No ss';
			}
		}
		return $ss;
	}
	
	function getNewestPlayers($limit, $value) {
		$con = QC_Database::getQuartzcoreDatabase();
		$newest = array();
		if(isset($limit)) {
			if($newest_results = mysqli_query($con, 'SELECT * FROM PlayerData ORDER BY id DESC LIMIT ' . $limit . ';')) {
				while($player = mysqli_fetch_array($newest_results, true)) {
					if(isset($value)) {
						switch ($value) {
							case 'name':
								array_push($newest, $player['DisplayName']);
						}
					} else {
						array_push($newest, $player['DisplayName']);
					}
					
				}
			} else {
				$newest['error'] = 'No newest players';
			}
		}  else {
			if($newest_results = mysqli_query($con, 'SELECT * FROM PlayerData ORDER BY id DESC LIMIT 20;')) {
				while($player = mysqli_fetch_array($newest_results, true)) {
					if(isset($value)) {
						switch ($value) {
							case 'name':
								array_push($newest, $player['DisplayName']);
						}
					} else {
						array_push($newest, $player['DisplayName']);
					}
				}
			} else {
				$newest['error'] = 'No newest players';
			}
		}
		return $newest;
	}
	
?>