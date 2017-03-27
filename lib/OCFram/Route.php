<?php
namespace OCFram;

class Route {
	protected $url;
	protected $module;
	protected $action;
	protected $pattern;
	protected $format;
	protected $varsNames;
	protected $vars = [];
	
	public function __construct( $url, $module, $action, $pattern, $format, array $varsNames ) {
		$this->setUrl( $url );
		$this->setModule( $module );
		$this->setAction( $action );
		$this->setPattern( $pattern );
		$this->setFormat( $format );
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
	
	// SETTERS //
	
	public function setUrl( $url ) {
		if ( is_string( $url ) ) {
			$this->url = $url;
		}
	}
	
	public function setModule( $module ) {
		if ( is_string( $module ) ) {
			$this->module = $module;
		}
	}
	
	public function setAction( $action ) {
		if ( is_string( $action ) ) {
			$this->action = $action;
		}
	}
	
	public function setPattern( $pattern ) {
		if ( is_string( $pattern ) ) {
			$this->pattern = $pattern;
		}
	}
	
	public function setFormat( $format ) {
		if ( is_string( $format ) ) {
			$this->format = $format;
		}
	}
	
	public function setVars( array $vars ) {
		$this->vars = $vars;
	}
	
	public function setVarsNames( array $varsNames ) {
		$this->varsNames = $varsNames;
	}
	
	// GETTERS //
	
	public function url() {
		return $this->url;
	}
	
	public function module() {
		return $this->module;
	}
	
	public function action() {
		return $this->action;
	}
	
	public function pattern() {
		return $this->pattern;
	}

	public function format() {
		return $this->format;
	}
	
	public function vars() {
		return $this->vars;
	}
	
	public function varsNames() {
		return $this->varsNames;
	}
}