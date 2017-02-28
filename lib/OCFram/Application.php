<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 27/02/2017
 * Time: 16:56
 */

namespace OCFram;


/**
 * Class Application
 *
 * @package OCFram
 */
abstract class Application {
	/**
	 * @var HTTPRequest
	 */
	protected $httpRequest;
	/**
	 * @var HTTPResponse
	 */
	protected $httpResponse;
	/**
	 * @var string
	 */
	protected $name;
	/**
	 * @var User
	 */
	protected $user;
	/**
	 * @var Config
	 */
	protected $config;
	
	/**
	 * Application constructor.
	 */
	public function __construct() {
		$this->httpRequest  = new HTTPRequest( $this );
		$this->httpResponse = new HTTPResponse( $this );
		$this->user         = new User( $this );
		$this->config       = new Config( $this );
		
		$this->name = '';
	}
	
	/**
	 * @return mixed
	 */
	public function getController() {
		$router = new Router();
		
		$xml = new \DOMDocument();
		$xml->load( __DIR__ . '/../../App/' . $this->name . '/Config/routes.xml' );
		
		$routes = $xml->getElementsByTagName( 'route' );
		
		/** @var \DOMElement $route */
		foreach ( $routes as $route ) {
			$vars = [];
			
			if ( $route->hasAttribute( 'vars' ) ) {
				$vars = explode( ',', $route->getAttribute( 'vars' ) );
			}
			
			$router->addRoute( new Route( $route->getAttribute( 'url' ), $route->getAttribute( 'module' ), $route->getAttribute( 'action' ), $vars ) );
		}
		
		try {
			/** @var Route $matchedRoute */
			$matchedRoute = $router->getRoute( $this->httpRequest->requestURI() );
		}
		catch ( \RuntimeException $e ) {
			if ( $e->getCode() == Router::NO_ROUTE ) {
				$this->httpResponse->redirect404();
			}
		}
		
		$_GET = array_merge( $_GET, $matchedRoute->getVars() );
		
		$controllerClass = 'App\\' . $this->name . '\\Modules\\' . $matchedRoute->getModule() . '\\' . $matchedRoute->getModule() . 'Controller';
		
		return new $controllerClass( $this, $matchedRoute->getModule(), $matchedRoute->getAction() );
	}
	
	/**
	 * @return mixed
	 */
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