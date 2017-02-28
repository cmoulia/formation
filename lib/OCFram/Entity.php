<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 27/02/2017
 * Time: 18:30
 */

namespace OCFram;


abstract class Entity implements \ArrayAccess {
	protected $erreurs = [], $id;
	
	public function __construct( array $donnees = [] ) {
		if ( !empty( $donnees ) ) {
			$this->hydrate( $donnees );
		}
	}
	
	public function hydrate( array $donnees ) {
		foreach ( $donnees as $attribut => $valeur ) {
			$method = 'set' . ucfirst( $attribut );
			
			if ( is_callable( [
				$this,
				$method,
			] ) ) {
				$this->$method( $valeur );
			}
		}
	}
	
	public function isNew() {
		return empty( $this->id );
	}
	
	/**
	 * @return array
	 */
	public function getErreurs() {
		return $this->erreurs;
	}
	
	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @param mixed $id
	 */
	public function setId( $id ) {
		$this->id = (int)$id;
	}
	
	public function offsetGet( $offset ) {
		if ( isset( $this->$offset )
			 && is_callable( [
				$this,
				$offset,
			] )
		) {
			return $this->$offset();
		}
	}
	
	public function offsetSet( $offset, $value ) {
		$method = 'set' . ucfirst( $offset );
		
		if ( isset( $this->$offset )
			 && is_callable( [
				$this,
				$method,
			] )
		) {
			$this->$method( $value );
		}
	}
	
	public function offsetExists( $offset ) {
		return isset( $this->$offset )
			   && is_callable( [
				$this,
				$offset,
			] );
	}
	
	public function offsetUnset( $offset ) {
		throw new \Exception( 'Impossible de supprimer une quelconque valeur' );
	}
}