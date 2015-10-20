<?php

class QCGames_Listener_Listener {
	
    public static function navigationTabs(&$extraTabs, $selectedTabId) {
		$options = XenForo_Application::get('options');
		
		if (XenForo_Visitor::getInstance()->hasPermission('games', 'view') && $options->displayGamesTab && $options->displayGames && $options->displayGamesPage) {
			$extraTabs['games'] = array(
				'title' => new XenForo_Phrase('games'),
				'href' => XenForo_Link::buildPublicLink('full:games'),
				'position' => 'home',
				'linksTemplate' => 'games_tab_links'
			);
		} else if(XenForo_Visitor::getInstance()->hasPermission('games', 'view') && $options->displayGamesTab && $options->displayGames && !$options->displayGamesPage) {
			$extraTabs['games'] = array(
				'title' => new XenForo_Phrase('games'),
				'position' => 'home',
				'linksTemplate' => 'games_tab_links'
			);
		}
		
		if (XenForo_Visitor::getInstance()->hasPermission('games', 'view') && XenForo_Visitor::getInstance()->hasPermission('games', 'kingdoms') && $options->displayKingdomsTab && $options->displayKingdoms) {
			$extraTabs['kingdoms'] = array(
				'title' => new XenForo_Phrase('kingdoms'),
				'href' => XenForo_Link::buildPublicLink('full:kingdoms'),
				'position' => 'home'
			);
		}
		
		if (XenForo_Visitor::getInstance()->hasPermission('games', 'view') && XenForo_Visitor::getInstance()->hasPermission('games', 'heist') && $options->displayHeistTab && $options->displayHeist) {
			$extraTabs['heist'] = array(
				'title' => new XenForo_Phrase('the_heist'),
				'href' => XenForo_Link::buildPublicLink('full:the-heist'),
				'position' => 'home'
			);
		}
		
		if (XenForo_Visitor::getInstance()->hasPermission('games', 'view') && XenForo_Visitor::getInstance()->hasPermission('games', 'labdefence') && $options->displayLabDefenceTab && $options->displayLabDefence) {
			$extraTabs['labdefence'] = array(
				'title' => new XenForo_Phrase('lab_defence'),
				'href' => XenForo_Link::buildPublicLink('full:lab-defence'),
				'position' => 'home'
			);
		}
	}
}

?>