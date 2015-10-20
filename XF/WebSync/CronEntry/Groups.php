<?php

class WebSync_CronEntry_Groups {

    public static function runSyncGroups() {
		$QCDB = WebSync_Database_Core::getQuartzcoreDatabase();
        $options = XenForo_Application::get('options');
		$userModel = XenForo_Model::create('XenForo_Model_User');
		$userFieldModel = XenForo_Model::create('XenForo_Model_UserField');
		
		if($options->syncGroups) {
			$fetchOptions = array('validOnly' => true);
			$users = $userModel->getAllUsers($fetchOptions);
					
			foreach ($users as $user) {
				$hasUpdated = false;
				$coreId = $userFieldModel->getUserFieldValues($user['user_id'])['CoreID'];
				$secondaryGroups = $user['secondary_group_ids'];
				
				$groups_raw = file_get_contents($options->restApiUrl . 'group.php?action=getAllGroups');
				$groups = json_decode($groups_raw, true);
				while($groupId = mysqli_fetch_array($groups)) {
					$group_raw = file_get_contents($options->restApiUrl . 'group.php?action=getGroup&id=' . $groupId);
					$group = json_decode($group_raw);
					
					foreach ($userGroups as $userGroup) {
						if($userGroup == $group['site_group_id']) {
							$player_raw = file_get_contents($options->restApiUrl . 'player.php?action=updatePlayer&id=' . $coreId . '&primaryGroupID=' . $group['id'] . '&apikey=07af7e75676eab410d1f83937d7afb62');
							$player = json_decode($player_raw, true);
							
							$hasUpdated = $player['hasUpdated'];
						}
					}
				}
						
				if($hasUpdated == false) {
					$player_raw = file_get_contents($options->restApiUrl . 'player.php?action=updatePlayer&id=' . $coreId . '&primaryGroupID=2&apikey=07af7e75676eab410d1f83937d7afb62');
					$player = json_decode($player_raw, true);
					
					$hasUpdated = $player['hasUpdated'];
				} 
			}
		}
	}
}