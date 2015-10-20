<?php

class QCPlayers_Listener_Listener {
	
    public static function navigationTabs(&$extraTabs, $selectedTabId) {
		$options = XenForo_Application::get('options');
		
		if (XenForo_Visitor::getInstance()->hasPermission('players', 'view')  && $options->displayPlayersTab && $options->displayPlayers) {
			$extraTabs['players'] = array(
				'title' => new XenForo_Phrase('players'),
				'href' => XenForo_Link::buildPublicLink('full:players'),
				'position' => 'home',
				'linksTemplate' => 'player_tab_links'
			);
		}
	}
}

?>