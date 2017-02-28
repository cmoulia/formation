<?php

namespace OCFram;

abstract class Validator {
	protected $errorMessage;
	
	public function __construct( $errorMessage ) {
		$this->setErrorMessage( $errorMessage );
	}
	
	public function setErrorMessage( $errorMessage ) {
		if ( is_string( $errorMessage ) ) {
			$this->errorMessage = $errorMessage;
		}
	}
	
	abstract public function isValid( $value );
	
	public function errorMessage() {
		return $this->errorMessage;
	}
}