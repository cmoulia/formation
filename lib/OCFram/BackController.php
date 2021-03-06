<?php

namespace OCFram;

abstract class BackController extends ApplicationComponent {
	protected $action     = '';
	protected $module     = '';
	protected $page       = null;
	protected $view       = '';
	protected $managers   = null;
	protected $authorizer = null;
	
	public function __construct( Application $app, $module, $action, $format ) {
		parent::__construct( $app );
		
		$this->managers = new Managers( 'PDO', PDOFactory::getMysqlConnexion() );
		$this->page     = new Page( $app, $format );
		
		$this->setModule( $module );
		$this->setAction( $action );
		$this->setView( $action, $format );
		$this->setAuthorizer( new Authorizer( $app ) );
		
		if ( $this instanceof Filterable ) {
			$filter = $this->getFilterableFilter();
			if ( null === $filter ) {
				throw new \Exception( 'Filter are not defined for action: ' . $action );
			}
			$this->authorizer()->addFilter( $filter );
		}
	}
	
	public function setModule( $module ) {
		if ( !is_string( $module ) || empty( $module ) ) {
			throw new \InvalidArgumentException( 'Module has to be a valid string' );
		}
		
		$this->module = $module;
	}
	
	public function setAction( $action ) {
		if ( !is_string( $action ) || empty( $action ) ) {
			throw new \InvalidArgumentException( 'Action has to be a valid string' );
		}
		
		$this->action = $action;
	}
	
	public function setView( $view, $format ) {
		if ( !is_string( $view ) || empty( $view ) ) {
			throw new \InvalidArgumentException( 'View has to be a valid string' );
		}
		if ( $format != 'html' ) {
			$view = str_replace( ucfirst( $format ), '', $view );
		}
		$this->view = $view;
		
		$this->page->setContentFile( __DIR__ . '/../../App/' . $this->app->name() . '/Modules/' . $this->module . '/Views/' . $this->view . '.' . $format . '.php' );
	}
	
	public function setAuthorizer(Authorizer $authorizer){
		$this->authorizer = $authorizer;
	}
	
	public function execute() {
		$method = 'execute' . ucfirst( $this->action );
		
		if ( !is_callable( [
			$this,
			$method,
		] )
		) {
			throw new \RuntimeException( 'Action "' . $this->action . '" is not defined for this module: ' . $this->module );
		}
		
		$this->$method( $this->app->httpRequest() );
	}
	
	public function authorizer(){
		return $this->authorizer;
	}
	
	public function page() {
		return $this->page;
	}
}