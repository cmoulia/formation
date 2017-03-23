<?php
namespace OCFram;

class Router {
	const NO_ROUTE = 1;
	protected $routes = [];
	
	public function addRoute( Route $route ) {
		if ( !in_array( $route, $this->routes ) ) {
			$this->routes[] = $route;
		}
	}
	
	public function getRoute( $url ) {
		/** @var Route $route */
		foreach ( $this->routes as $route ) {
			// If route match the url
			if ( ( $varsValues = $route->match( $url ) ) !== false ) {
				// If there are variables
				if ( $route->hasVars() ) {
					$varsNames = $route->varsNames();
					$listVars  = [];
					
					/** @var array $varsValues */
					foreach ( $varsValues as $key => $match ) {
						/* First value is the whole captured string.*/ /** @see preg_match() */
						if ( $key !== 0 ) {
							$listVars[ $varsNames[ $key - 1 ] ] = $match;
						}
					}
					
					// We set a new array of routes
					$route->setVars( $listVars );
				}
				
				return $route;
			}
		}
		
		throw new \RuntimeException( 'Aucune route ne correspond à l\'URL', self::NO_ROUTE );
	}
}