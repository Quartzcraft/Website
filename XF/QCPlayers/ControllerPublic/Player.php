<?php

class QCPlayers_ControllerPublic_Player extends XenForo_ControllerPublic_Abstract {

	public function actionIndex() {
		$options = XenForo_Application::get('options');
		
		$username = $this->_input->filterSingle('username', XenForo_Input::STRING);
		if($username !== '') {
			$player_raw = file_get_contents($options->restApiUrl . 'player.php?action=getPlayerByName&username=' . $username);
			$player = json_decode($player_raw, true);
			
			if(isset($player['error'])) {
				return $this->responseRedirect(4, XenForo_Link::buildPublicLink('full:players'));
			}
			
			$group_raw = file_get_contents($options->restApiUrl . 'group.php?action=getGroup&id=' . $player['PrimaryGroupId']);
			$group = json_decode($group_raw, true);
								
			$viewParams = array(
				'player' => $player,
				'group' => $group
			);
			return $this->responseView('QCPlayers_ViewPublic_Player_Index', 'player_view', $viewParams);
		} 
		
		return $this->responseRedirect(4, XenForo_Link::buildPublicLink('full:players'));
	}
	
	public function actionReport() {
		$options = XenForo_Application::get('options');
		
		$username = $this->_input->filterSingle('username', XenForo_Input::STRING);
		if ($username !== '') {
			$player_raw = file_get_contents($options->restApiUrl . 'player.php?action=getPlayerByName&username=' . $username);
			$player = json_decode($player_raw, true);
						
			if(isset($player['error'])) {
				return $this->responseRedirect(4, XenForo_Link::buildPublicLink('full:players'));
			}
			
			$viewParams = array(
				'player' => $player
			);
			return $this->responseView('QCPlayers_ViewPublic_Player_Report', 'player_report', $viewParams);
		} 
			
		//return $this->responseReroutePath('players');
		return $this->responseRedirect(4, XenForo_Link::buildPublicLink('full:players'));
	}
	
	public function actionReportSubmit() {
		$options = XenForo_Application::get('options');
		
		$username = $this->_input->filterSingle('username', XenForo_Input::STRING);
		if ($username !== '') {
			$player_raw = file_get_contents($options->restApiUrl . 'player.php?action=getPlayerByName&username=' . $username);
			$player = json_decode($player_raw, true);
										
			$input = $this->_input->filter(array(
				'report_content' => XenForo_Input::STRING,
				'reporting_id' => XenForo_Input::INT
			));
					
			if($input['report_content'] != null || $input['report_content'] != '') {
				if(isset($player['error'])) {
					return $this->responseRedirect(4, XenForo_Link::buildPublicLink('full:players'));
				}
				
				//when reporting use url_encode on content
				$report_raw = file_get_contents($options->restApiUrl . 'player.php?action=reportPlayer&id=' . $player['id'] . '&reporting_id=' . $input['reporting_id'] . '&report=' . urlencode($input['report_content']) . '&apikey=07af7e75676eab410d1f83937d7afb62');
				$report = json_decode($report_raw, true);
				
				if($report['reported']) {
					return $this->responseRedirect(
						XenForo_ControllerResponse_Redirect::SUCCESS,
						XenForo_Link::buildPublicLink('player', $username),
						new XenForo_Phrase('thank_you_for_reporting_this_player')
					);
				}
				
				$viewParams = array(
					'player' => $player
				);
				return $this->responseView('QCPlayers_ViewPublic_Player_Report', 'player_report', $viewParams);
			} 
			
			$viewParams = array(
				'player' => $player,
				'error' => new XenForo_Phrase('please_enter_a_reason_for_reporting_this_player')
			);
			return $this->responseView('QCPlayers_ViewPublic_Player_Report', 'player_report', $viewParams);
		} 
		
		//return $this->responseReroutePath('players');
		return $this->responseRedirect(4, XenForo_Link::buildPublicLink('full:players'));
	}
	
	public static function getSessionActivityDetailsForList(array $activities) {
		
		$output = array();
		foreach ($activities AS $key => $activity) {
			$action = $activity['controller_action'];

			switch ($action) {
				case 'Index':
					$output[$key] = array(
						new XenForo_Phrase('viewing_player_profile'),
						$activity['params']['username'],
						XenForo_Link::buildPublicLink('player', $activity['params']['username']),
						false
					);
				case 'Report':
					$output[$key] = array(
						new XenForo_Phrase('viewing_player_profile'),
						$activity['params']['username'],
						XenForo_Link::buildPublicLink('player', $activity['params']['username']),
						false
					);
			}
		}
		return $output;
	}
}