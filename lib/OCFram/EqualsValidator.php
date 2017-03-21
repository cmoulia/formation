<?php

namespace OCFram;

class EqualsValidator extends Validator {
	protected $value;
	
	public function __construct( $errorMessage, $manager ) {
		parent::__construct( $errorMessage );
		
		$this->value = $manager->value();
	}
	
	public function isValid( $value ) {
		return $value == $this->value;
	}
}