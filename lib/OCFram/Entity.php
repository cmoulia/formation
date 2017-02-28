<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 27/02/2017
 * Time: 18:30
 */

namespace OCFram;


/**
 * Class Entity
 *
 * @package OCFram
 */
abstract class Entity implements \ArrayAccess {
	/**
	 * @var array
	 */
	protected $erreurs = [], $id;
	
	/**
	 * Entity constructor.
	 *
	 * @param array $donnees
	 */
	public function __construct( array $donnees = [] ) {
		if ( !empty( $donnees ) ) {
			$this->hydrate( $donnees );
		}
	}
	
	/**
	 * @param array $donnees
	 */
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
	
	/**
	 * @return bool
	 */
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
	
	/**
	 * @param mixed $offset
	 *
	 * @return mixed
	 */
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
	
	/**
	 * @param mixed $offset
	 * @param mixed $value
	 */
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
	
	/**
	 * @param mixed $offset
	 *
	 * @return bool
	 */
	public function offsetExists( $offset ) {
		return isset( $this->$offset )
			   && is_callable( [
				$this,
				$offset,
			] );
	}
	
	/**
	 * @param mixed $offset
	 *
	 * @throws \Exception
	 */
	public function offsetUnset( $offset ) {
		throw new \Exception( 'Impossible de supprimer une quelconque valeur' );
	}
}