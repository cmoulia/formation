<?php

namespace OCFram;

class ExistingUserValidator extends Validator {
	protected $user_a;
	protected $currentuser;
	
	public function __construct( $errorMessage, array $user_a, \Entity\User $currentuser ) {
		parent::__construct( $errorMessage );
		
		$this->setUser_a( $user_a );
		$this->currentuser = $currentuser;
	}
	
	public function setUser_a( $user_a ) {
		if ( !is_array( $user_a ) )
			throw new \InvalidArgumentException( 'La variable renseignée doit être un tableau' );
		$this->user_a = $user_a;
	}
	
	public function isValid( $value ) {
		$userinfo = [];
		$currentuserinfo = [
			$this->currentuser->username(),
			$this->currentuser->email(),
		];
		foreach ( $this->user_a as $key => $user ) {
			$userinfo[] = $user[ 'username' ];
			$userinfo[] = $user[ 'email' ];
		}
		
		return ( in_array( $value, $currentuserinfo ) || !in_array( $value, $userinfo ) );
	}
}