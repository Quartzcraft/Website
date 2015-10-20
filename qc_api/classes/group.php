<?php
	require_once("Database.php");
	
	function getGroup($id) {
		$con = QC_Database::getQuartzcoreDatabase();
		if (isset($id)) {
			if($group_result = mysqli_query($con, 'SELECT * FROM Groups WHERE id=' . $id . ';')) {
				$group = mysqli_fetch_array($group_result, true);
				
				return $group;
			} else {
				return array("error" => "No group");
			}
		} 
	}
	
	function getAllGroups($value) {
		$con = QC_Database::getQuartzcoreDatabase();
		$groups = array();
		
		if(isset($value)) {
			$groups_result = mysqli_query($con, 'SELECT * FROM Groups');
			
			if($value = "id") {
				while($group = mysqli_fetch_array($groups_result, true)) {
					array_push($groups, $group['id']);
				}
			}
			
			return $groups;
		}
	}
?>