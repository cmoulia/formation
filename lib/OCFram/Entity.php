<?php

namespace OCFram;

use JsonSerializable;

abstract class Entity implements \ArrayAccess, JsonSerializable {
	protected $errors = [], $id, $prefix, $References = [];
	
	public function __construct( array $data_a = [] ) {
		if ( !empty( $data_a ) ) {
			foreach ( $data_a as $key => $data ) {
				if ( $key != str_replace( $this->prefix, '', $key ) ) {
					$data_a[ str_replace( $this->prefix, '', $key ) ] = $data;
					unset( $data_a[ $key ] );
				}
			}
			$this->hydrate( $data_a );
		}
	}
	
	// Use of the Hydrator trait, so each of our entities can be hydrated
	use Hydrator;
	
	public function isNew() {
		return empty( $this->id );
	}
	
	public function errors() {
		return $this->errors;
	}
	
	public function id() {
		return $this->id;
	}
	
	public function setId( $id ) {
		$this->id = (int)$id;
	}
	
	//region ArrayAccess
	public function offsetGet( $var ) {
		if ( isset( $this->$var )
			 && is_callable( [
				$this,
				$var,
			] )
		) {
			return $this->$var();
		}
		
		return null;
	}
	
	public function offsetSet( $var, $value ) {
		$method = 'set' . ucfirst( $var );
		
		if ( isset( $this->$var )
			 && is_callable( [
				$this,
				$method,
			] )
		) {
			$this->$method( $value );
		}
	}
	
	public function offsetExists( $var ) {
		return isset( $this->$var )
			   && is_callable( [
				$this,
				$var,
			] );
	}
	
	public function offsetUnset( $var ) {
		throw new \Exception( 'Unable to delete the value' );
	}
	//endregion
}