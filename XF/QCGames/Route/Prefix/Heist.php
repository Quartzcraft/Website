<?php

/**
 * Route prefix handler
 */
class QCGames_Route_Prefix_Heist implements XenForo_Route_Interface {

	/**
	 * Match a specific route for an already matched prefix.
	 *
	 * @see XenForo_Route_Interface::match()
	 */
	public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router) {
		$controller = 'QCGames_ControllerPublic_Heist';
		
		return $router->getRouteMatch($controller, $routePath, 'games');
	}
}

?>