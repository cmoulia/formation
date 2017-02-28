<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 27/02/2017
 * Time: 17:11
 */

namespace OCFram;


/**
 * Class Route
 *
 * @package OCFram
 */
class Route {
	protected $action;
	protected $module;
	protected $url;
	protected $varsNames;
	protected $vars = [];
	
	public function __construct( $url, $module, $action, array $varsNames ) {
		$this->setUrl( $url );
		$this->setModule( $module );
		$this->setAction( $action );
		$this->setVarsNames( $varsNames );
	}
	
	public function hasVars() {
		return !empty( $this->varsNames );
	}
	
	public function match( $url ) {
		if ( preg_match( '`^' . $this->url . '$`', $url, $matches ) ) {
			return $matches;
		}
		else {
			return false;
		}
	}
	
	/**
	 * @return mixed
	 */
	public function getAction() {
		return $this->action;
	}
	
	/**
	 * @param mixed $action
	 */
	public function setAction( $action ) {
		if ( is_string( $action ) ) {
			$this->action = $action;
		}
	}
	
	/**
	 * @return mixed
	 */
	public function getModule() {
		return $this->module;
	}
	
	/**
	 * @param mixed $module
	 */
	public function setModule( $module ) {
		if ( is_string( $module ) ) {
			$this->module = $module;
		}
	}
	
	/**
	 * @return mixed
	 */
	public function getUrl() {
		return $this->url;
	}
	
	/**
	 * @param mixed $url
	 */
	public function setUrl( $url ) {
		if ( is_string( $url ) ) {
			$this->url = $url;
		}
	}
	
	/**
	 * @return mixed
	 */
	public function getVarsNames() {
		return $this->varsNames;
	}
	
	/**
	 * @param mixed $varsNames
	 */
	public function setVarsNames( array $varsNames ) {
		$this->varsNames = $varsNames;
	}
	
	/**
	 * @return array
	 */
	public function getVars() {
		return $this->vars;
	}
	
	/**
	 * @param array $vars
	 */
	public function setVars( array $vars ) {
		$this->vars = $vars;
	}
}