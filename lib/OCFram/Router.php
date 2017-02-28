<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 27/02/2017
 * Time: 17:10
 */

namespace OCFram;


/**
 * Class Router
 *
 * @package OCFram
 */
class Router {
	/**
	 *
	 */
	const NO_ROUTE = 1;
	/**
	 * @var array
	 */
	protected $routes = [];
	
	/**
	 * @param Route $route
	 */
	public function addRoute( Route $route ) {
		if ( !in_array( $route, $this->routes ) ) {
			$this->routes[] = $route;
		}
	}
	
	/**
	 * @param $url
	 *
	 * @return mixed
	 */
	public function getRoute( $url ) {
		foreach ( $this->routes as $route ) {
			//			Si correspond
			if ( ( $varsValues = $route->match( $url ) ) !== false ) {
				if ( $route->hasVars() ) {
					$varsNames = $route->getVarsNames();
					$listVars  = [];
					
					foreach ( $varsValues as $key => $match ) {
						if ( $key !== 0 ) {
							$listVars[ $varsNames[ $key - 1 ] ] = $match;
						}
					}
					
					$route->setVars( $listVars );
				}
				
				return $route;
			}
		}
		
		throw new \RuntimeException( 'Aucune route ne correspond à l\'URL', self::NO_ROUTE );
	}
}