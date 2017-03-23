<?php

namespace OCFram;

class NotNullValidator extends Validator {
	public function __construct( $errorMessage ) {
		parent::__construct( $errorMessage );
	}
	
	public function isValid( $value ) {
		return $value != '';
	}
}