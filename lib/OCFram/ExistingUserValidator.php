<?php

namespace OCFram;

class ExistingUserValidator extends Validator {
	protected $users;
	
	public function __construct( $errorMessage, $manager ) {
		parent::__construct( $errorMessage );
		
		$users = $manager->getList();
		$this->users = $users;
	}
	
	public function isValid( $value ) {
		return in_array($value, $this->users);
	}
}