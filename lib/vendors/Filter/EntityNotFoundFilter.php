<?php

namespace Filter;

use OCFram\Filter;
use OCFram\Manager;
use OCFram\User;

class EntityNotFoundFilter extends Filter {
	protected $manager;
	protected $method;
	protected $additionnal_method_params;
	
	public function __construct( $redirect_or_callback, User $User, Manager $manager, $method, $additionnal_method_params = null ) {
		parent::__construct( $redirect_or_callback, $User );
		if ( $additionnal_method_params === null ) {
			$additionnal_method_params = [];
		}
		elseif ( !is_array( $additionnal_method_params ) ) {
			$additionnal_method_params = [ $additionnal_method_params ];
		}
		
		$this->manager = $manager;
		$this->setMethod( $method );
		$this->additionnal_method_params = $additionnal_method_params;
	}
	
	private function setMethod( $method ) {
		if ( !is_string( $method ) || empty( $method ) ) {
			throw new \InvalidArgumentException( 'La méthode renseignée doit être une string valide' );
		}
		if ( !is_callable( [
			$this->manager,
			$method,
		] )
		) {
			throw new \InvalidArgumentException( 'La méthode appelé n\'existe pas' );
		}
		$this->method = $method;
	}
	
	public function check() {
		return !call_user_func_array( [
			$this->manager,
			$this->method,
		], $this->additionnal_method_params );
	}
}