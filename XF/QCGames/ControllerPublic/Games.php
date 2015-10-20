<?php

class QCGames_ControllerPublic_Games extends XenForo_ControllerPublic_Abstract {

	public function actionIndex() {
		$options = XenForo_Application::get('options');

		if(!XenForo_Visitor::getInstance()->hasPermission('games', 'view') || !$options->displayGames && !XenForo_Visitor::getInstance()->isSuperAdmin() || !$options->displayGamesPage && !XenForo_Visitor::getInstance()->isSuperAdmin()) {
			return $this->responseNoPermission();
		}
			
		$viewParams = array(
			'null' => null
		);

		return $this->responseView('QCGames_ViewPublic_Games_Index', 'game_index', $viewParams);
	}
	
	public function actionKingdoms() {
		$options = XenForo_Application::get('options');
		
		if(!XenForo_Visitor::getInstance()->hasPermission('games', 'view') && !XenForo_Visitor::getInstance()->hasPermission('games', 'kingdoms') || !$options->displayKingdoms && !XenForo_Visitor::getInstance()->isSuperAdmin() || !$options->displayGames && !XenForo_Visitor::getInstance()->isSuperAdmin()) {
			return $this->responseNoPermission();
		}
		
		$viewParams = array(
			'null' => null
		);
			
		return $this->responseView('QCGames_ViewPublic_Kingdoms_Index', 'kingdom_index', $viewParams);
	}
	
	public static function getSessionActivityDetailsForList(array $activities) {
			
		$output = array();
		foreach ($activities AS $key => $activity) {
			$action = $activity['controller_action'];

			switch ($action) {
				case 'Index':
					$output[$key] = new XenForo_Phrase('viewing_games');
				case 'Kingdoms':
					$output[$key] = new XenForo_Phrase('viewing_kingdoms');
			}
		}
		return $output;
	}
}