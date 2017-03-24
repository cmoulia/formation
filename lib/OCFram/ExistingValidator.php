<?php

namespace OCFram;

class ExistingValidator extends Validator {
	protected $manager;
	protected $attribute;
	protected $current;
	
	public function __construct( $errorMessage, Manager $manager, $attribute, $current ) {
		parent::__construct( $errorMessage );
		
		$this->manager = $manager;
		$this->setAttribute($attribute);
		$this->current = $current;
	}
	
	private function setAttribute( $attribute ) {
		if (!is_string($attribute) || empty($attribute)){
			throw new \InvalidArgumentException('L\'attribut renseignée doit être une string valide');
		}
		$this->attribute = $attribute;
	}
	
	public function isValid( $value ) {
		return ( $value == $this->current || !$this->manager->checkExistency($this->attribute, $value) );
	}
}