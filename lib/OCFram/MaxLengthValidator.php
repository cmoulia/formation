<?php

namespace OCFram;

class MaxLengthValidator extends Validator {
	protected $maxLength;
	
	public function __construct( $errorMessage, $maxLength ) {
		parent::__construct( $errorMessage );
		
		$this->setMaxLength( $maxLength );
	}
	
	public function setMaxLength( $maxLength ) {
		if ( !is_int( $maxLength ) || $maxLength <= 0 ) {
			throw new \InvalidArgumentException( 'MaxLength attribute should be an integer and greater than 0' );
		}
		$this->maxLength = $maxLength;
	}
	
	public function isValid( $value ) {
		return strlen( $value ) <= $this->maxLength;
	}
}