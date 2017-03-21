<?php
namespace OCFram;

abstract class Entity implements \ArrayAccess {
	protected $errors = [], $id;
	protected               $prefix;
	
	public function __construct( array $donnees = [] ) {
		if ( !empty( $donnees ) ) {
			$this->hydrate( $donnees );
		}
	}
	
	// Utilisation du trait Hydrator pour que nos entités puissent être hydratées
	use Hydrator;
	
	/*// Essai pour changer la colonne en setter correct
	public function __set( $name, $value ) {
		$var = str_replace($this->prefix,'',$name);
		$method = 'set' . ucfirst( $var );
		
		var_dump('prefix: '.$this->prefix);
		var_dump('$name: '.$name);
		var_dump('$var: '.$var);
		var_dump('$method: '.$method);
		var_dump('$value: '.$value);
		var_dump(isset($this->$var));
		var_dump(is_callable([$this, $method]));
		var_dump($this);
		die;
		
		if ( isset( $this->$var )
			 && is_callable( [
				$this,
				$method,
			] )
		) {
			$this->$method( $value );
		}
	}
	
	public function prefix() {
		return $this->prefix;
	}
	*/
	
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