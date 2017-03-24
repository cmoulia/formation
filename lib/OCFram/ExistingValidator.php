<?php

namespace OCFram;

class ExistingValidator extends Validator {
	protected $existency;
	protected $current;
	
	public function __construct( $errorMessage, $existency, $current ) {
		parent::__construct( $errorMessage );
		
		$this->setExistency( $existency );
		$this->current = $current;
	}
	
	public function setExistency( $existency ) {
		if ( !is_bool( $existency ) ) {
			throw new \InvalidArgumentException( 'La variable renseignée doit être un booléen' );
		}
		$this->existency = $existency;
	}
	
	public function isValid( $value ) {
		return ( $value == $this->current || !$this->existency );
	}
}