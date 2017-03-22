<?php

namespace OCFram;

abstract class Entity implements \ArrayAccess {
	protected $errors = [];
	protected $id;
	protected $prefix;
	
	public function __construct( array $data_a = [] ) {
		if ( !empty( $data_a ) ) {
			foreach ( $data_a as $key => $data ) {
				if ($key != str_replace($this->prefix, '', $key)){
					$data_a[ str_replace($this->prefix, '', $key)] = $data;
					unset( $data_a[ $key]);
				}
			}
			$this->hydrate( $data_a );
		}
	}
	
	// Utilisation du trait Hydrator pour que nos entités puissent être hydratées
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
		throw new \Exception( 'Impossible de supprimer une quelconque valeur' );
	}
}