<?php

namespace OCFram;

class ExistingUserValidator extends Validator {
	protected $user_a;
	
	public function __construct( $errorMessage, $user_a ) {
		parent::__construct( $errorMessage );
		
		$this->user_a = $user_a;
	}
	
	public function isValid( $value ) {
		$userinfo = [];
		foreach ( $this->user_a as $key => $user ) {
			$userinfo[] = $user['username'];
			$userinfo[] = $user['email'];
		}
		return !in_array($value,$userinfo);
		
	}
}