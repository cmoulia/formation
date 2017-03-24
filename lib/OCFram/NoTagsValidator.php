<?php

namespace OCFram;

class NoTagsValidator extends Validator {
	public function __construct( $errorMessage ) {
		parent::__construct( $errorMessage );
	}
	
	public function isValid( $value ) {
		return ($value == strip_tags($value));
	}
}