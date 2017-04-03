<?php


namespace OCFram;


class ManagerCached {
	protected $name;
	protected $dao;
	/** @var bool $cache_enabled */
	protected $cache_enabled = true;
	/** @var Manager[] $managers */
	protected $managers = array();
	protected $cache    = array();
	
	public function __construct( $name, $dao ) {
		$this->setName( $name );
		$this->dao = $dao;
		$this->setManager( $name );
	}
	
	protected function setName( $name ) {
		if ( !is_string( $name ) || empty( $name ) ) {
			throw new \Exception( 'Le nom doit être une string' );
		}
		$this->name = $name;
	}
	
	protected function setManager( $name ) {
		if ( !isset( $this->managers[ $name ] ) ) {
			$this->managers[ $this->name ] = new $name( $this->dao );
		}
	}
	
	public function setCacheEnabled( $cache_enabled ) {
		$this->cache_enabled = $cache_enabled;
		
		return $this;
	}
	
	
	function __call( $method, $arguments ) {
		$arguments_list = implode( ',', $arguments );
		$key = $this->name . '::' . $method . '(' . $arguments_list . ')';
		if ( $this->cache_enabled ) {
//			var_dump( $key );
			if ( isset( $this->cache[ $key ] ) ) {
//				var_dump( 'Cache used' );
				
				return $this->cache[ $key ];
			}
		}
		
		return $this->cache[ $key ] = call_user_func_array( [
			$this->managers[ $this->name ],
			$method,
		], $arguments );
	}
}