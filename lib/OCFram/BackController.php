<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 27/02/2017
 * Time: 18:06
 */

namespace OCFram;


class BackController extends ApplicationComponent {
	protected $action   = '';
	protected $module   = '';
	protected $page     = null;
	protected $view     = '';
	protected $managers = null;
	
	public function __construct( Application $app, $module, $action ) {
		parent::__construct( $app );
		
		$this->managers = new Managers( 'PDO', PDOFactory::getMysqlConnexion() );
		$this->page     = new Page( $app );
		
		$this->setModule( $module );
		$this->setAction( $action );
		$this->setView( $action );
	}
	
	/**
	 * @param string $module
	 */
	public function setModule( $module ) {
		if ( !is_string( $module ) || empty( $module ) ) {
			throw new \InvalidArgumentException( 'Le module doit être une chaine de caractères valide' );
		}
		$this->module = $module;
	}
	
	/**
	 * @param string $action
	 */
	public function setAction( $action ) {
		if ( !is_string( $action ) || empty( $action ) ) {
			throw new \InvalidArgumentException( 'L\'action doit être une chai nde caractères valide' );
		}
		$this->action = $action;
	}
	
	/**
	 * @param string $view
	 */
	public function setView( $view ) {
		if ( !is_string( $view ) || empty( $view ) ) {
			throw new \InvalidArgumentException( 'La vue doit être une chaine de caractères valide' );
		}
		$this->view = $view;
		
		$this->page->setContentFile( __DIR__ . '/../../app/' . $this->app->getName() . '/modules/' . $this->module . 'views' . $this->view . '.php' );
	}
	
	public function execute() {
		$method = 'execute' . ucfirst( $this->action );
		
		if ( !is_callable( [
			$this,
			$method,
		] )
		) {
			throw new \RuntimeException( 'L\'action "' . $this->action . '" n\'est pas définie sur ce module' );
		}
		
		$this->$method( $this->app->getHttpRequest() );
	}
	
	/**
	 * @return Page
	 */
	public function getPage() {
		return $this->page;
	}
}