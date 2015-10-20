<?php

/**
 * Route prefix handler
 */
class QCPlayers_Route_Prefix_Players implements XenForo_Route_Interface {

	/**
	 * Match a specific route for an already matched prefix.
	 *
	 * @see XenForo_Route_Interface::match()
	 */
	public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router) {
		$controller = 'QCPlayers_ControllerPublic_Players';
		
		$action = $router->resolveActionWithStringParam($routePath, $request, 'username');
		return $router->getRouteMatch($controller, $action, 'players');
	}
}

?>