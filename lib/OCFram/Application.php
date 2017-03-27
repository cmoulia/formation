<?php
namespace OCFram;

abstract class Application {
	protected $httpRequest;
	protected $httpResponse;
	protected $name;
	protected $user;
	protected $config;
	static $routes;
	
	public function __construct() {
		$this->httpRequest  = new HTTPRequest( $this );
		$this->httpResponse = new HTTPResponse( $this );
		$this->user         = new User( $this );
		$this->config       = new Config( $this );
		
		$this->name = '';
	}
	
	public function getController() {
		$router = RouterFactory::getRouter($this->name());
		
		try {
			// We try to get route corresponding to our url
			$matchedRoute = $router->getRoute( $this->httpRequest->requestURI() );
		}
		catch ( \RuntimeException $e ) {
			if ( $e->getCode() == Router::NO_ROUTE ) {
				// If no route match the url, it means the page doesn't exist.
				$this->httpResponse->redirect404();
			}
		}
		
		// We add our vars to the $_GET array
		$_GET = array_merge( $_GET, $matchedRoute->vars() );
		
		// We get our controller and instanciate it
		$controllerClass = 'App\\' . $this->name . '\\Modules\\' . $matchedRoute->module() . '\\' . $matchedRoute->module() . 'Controller';
		
		return new $controllerClass( $this, $matchedRoute->module(), $matchedRoute->action() );
	}
	
	abstract public function run();
	
	// GETTERS //
	
	public function httpRequest() {
		return $this->httpRequest;
	}
	
	public function httpResponse() {
		return $this->httpResponse;
	}
	
	public function name() {
		return $this->name;
	}
	
	public function config() {
		return $this->config;
	}
	
	public function user() {
		return $this->user;
	}
}
