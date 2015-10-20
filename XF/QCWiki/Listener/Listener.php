<?php

class QCWiki_Listener_Listener {
	
    public static function navigationTabs(&$extraTabs, $selectedTabId) {
		$options = XenForo_Application::get('options');
		
		if (XenForo_Visitor::getInstance()->hasPermission('wiki', 'viewTab')  && $options->displayWikiTab) {
			$extraTabs['wiki'] = array(
				'title' => new XenForo_Phrase('wiki'),
				'href' => $options->wikiLink,
				'position' => 'home',
				'linksTemplate' => 'wiki_tab_links'
			);
		}
	}
}

?>