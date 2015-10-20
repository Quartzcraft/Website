<?php

/**
 * Route prefix handler
 */
class QCPlayers_Route_Prefix_Player implements XenForo_Route_Interface {

	/**
	 * Match a specific route for an already matched prefix.
	 *
	 * @see XenForo_Route_Interface::match()
	 */
	public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router) {
		$controller = 'QCPlayers_ControllerPublic_Player';
		
		$routePath .= '/';
		$action = $router->resolveActionWithStringParam($routePath, $request, 'username');
		return $router->getRouteMatch($controller, $action, 'players', $routePath);
	}
	
	public function buildLink($originalPrefix, $outputPrefix, $action, $extension, $data, array &$extraParams) {
		return XenForo_Link::buildBasicLinkWithStringParam($outputPrefix, $action, $extension, $data, 'username');
	}
}

?>