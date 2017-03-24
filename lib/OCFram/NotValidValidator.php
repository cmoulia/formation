<?php

namespace OCFram;

class NotValidValidator extends Validator {
	public function __construct( $errorMessage, $type ) {
		parent::__construct( $errorMessage );
		$this->setType( $type );
	}
	
	public function isValid( $value ) {
		return $value != '';
	}
	
	private function setType( $type ) {
		if ( !is_string( $type ) || empty( $type ) ) {
			throw new \InvalidArgumentException( 'Le paramètre renseigné doit être un string valide' );
		}
		
		switch ( $type ):
			case 'email':
				break;
			case 'date':
				break;
			default:
				break;
		endswitch;
	}
}