<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 27/02/2017
 * Time: 16:56
 */

namespace OCFram;


abstract class Application {
	protected $httpRequest;
	protected $httpResponse;
	protected $name;
	protected $user;
	protected $config;
	
	public function __construct() {
		$this->httpRequest  = new HTTPRequest( $this );
		$this->httpResponse = new HTTPResponse( $this );
		$this->user         = new User( $this );
		$this->config       = new Config( $this );
		
		$this->name         = '';
	}
	
	public function getController() {
		$router = new Router();
		
		$xml = new \DOMDocument();
		$xml->load( __DIR__ . '/../../app/' . $this->name . '/config/routes.xml' );
		
		$routes = $xml->getElementsByTagName( 'route' );
		
		foreach ( $routes as $route ) {
			$vars = [];
			
			if ( $route->hasAttribute( 'vars' ) ) {
				$vars = explode( ',', $route->getAttribute( 'vars' ) );
			}
			
			$router->addRoute( new Route( $route->getAttribute( 'url' ), $route->getAttribute( 'module' ), $route->getAttribute( 'action' ), $vars ) );
		}
		
		try {
			$matchedRoute = $router->getRoute( $this->httpRequest->requestURI() );
		}
		catch ( \RuntimeException $e ) {
			if ( $e->getCode() == Router::NO_ROUTE ) {
				$this->httpResponse->redirect404();
			}
		}
		
		$_GET = array_merge( $_GET, $matchedRoute->vars() );
		
		$controllerClass = 'app\\' . $this->name . '\\modules\\' . $matchedRoute->module() . '\\' . $matchedRoute->module() . 'Controller';
		
		return new $controllerClass( $this, $matchedRoute->module(), $matchedRoute->action() );
	}
	
	abstract public function run();
	
	/**
	 * @return HTTPRequest
	 */
	public function getHttpRequest() {
		return $this->httpRequest;
	}
	
	/**
	 * @return HTTPResponse
	 */
	public function getHttpResponse() {
		return $this->httpResponse;
	}
	
	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @return Config
	 */
	public function getConfig() {
		return $this->config;
	}
	
	/**
	 * @return User
	 */
	public function getUser() {
		return $this->user;
	}
}