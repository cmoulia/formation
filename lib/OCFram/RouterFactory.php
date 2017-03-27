<?php


namespace OCFram;


class RouterFactory {
	protected static $Router_a = [];
	
	/**
	 * @param $application_name
	 *
	 * @return Router
	 */
	public static function getRouter( $application_name ) {
		self::buildRouteur( $application_name );
		
		return self::$Router_a[ $application_name ];
	}
	
	/**
	 * @param $application_name
	 */
	private static function buildRouteur( $application_name ) {
		if ( isset( self::$Router_a[ $application_name ] ) ) {
			return;
		}
		$router = new Router;
		
		$xml = new \DOMDocument;
		$xml->load( __DIR__ . '/../../App/' . $application_name . '/Config/routes.xml' );
		
		$routes = $xml->getElementsByTagName( 'route' );
		
		// We browse through each route
		/** @var \DOMElement $route */
		foreach ( $routes as $route ) {
			$vars = [];
			
			// If $route has some attributes in the url
			if ( $route->hasAttribute( 'vars' ) ) {
				$vars = explode( ',', $route->getAttribute( 'vars' ) );
			}
			
			$format  = ( $route->getAttribute( 'format' ) ) ? $route->getAttribute( 'format' ) : 'html';
			$pattern = ( $route->getAttribute( 'pattern' ) ) ? $route->getAttribute( 'pattern' ) : $route->getAttribute( 'url' );
			if ( $format != 'html' ) {
				$pattern .= '.'.$format;
			}
			
			// We add the route to the router, its url, its module, its action, and its variables
			$router->addRoute( new Route( $route->getAttribute( 'url' ), $route->getAttribute( 'module' ), $route->getAttribute('action'), $pattern, $format, $vars ) );
		}
		
		self::$Router_a[ $application_name ] = $router;
	}
}