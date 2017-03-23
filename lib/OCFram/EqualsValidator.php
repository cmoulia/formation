<?php

namespace OCFram;

class EqualsValidator extends Validator {
	protected $value;
	
	/**
	 * EqualsValidator constructor.
	 *
	 * @param string $errorMessage
	 * @param TextField $field
	 */
	public function __construct( $errorMessage, $field ) {
		parent::__construct( $errorMessage );
		
		$this->value = $field->value();
	}
	
	public function isValid( $value ) {
		return $value == $this->value;
	}
}