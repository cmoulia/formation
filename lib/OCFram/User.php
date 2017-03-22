<?php
namespace OCFram;

session_start();

class User {
	public function getAttribute( $attr ) {
		return isset( $_SESSION[ $attr ] ) ? $_SESSION[ $attr ] : null;
	}
	
	public function getFlash() {
		$flash = $_SESSION[ 'flash' ];
		unset( $_SESSION[ 'flash' ] );
		
		return $flash;
	}
	
	public function hasFlash() {
		return isset( $_SESSION[ 'flash' ] );
	}
	
	public function isAuthenticated() {
		return isset( $_SESSION[ 'auth' ] ) && $_SESSION[ 'auth' ] === true;
	}
	
	public function isAdmin() {
		return $_SESSION['role'] == base64_encode('admin');
	}
	
	public function setAttribute( $attr, $value ) {
		$_SESSION[ $attr ] = $value;
	}
	
	public function setAuthenticated( $authenticated = true ) {
		if ( !is_bool( $authenticated ) ) {
			throw new \InvalidArgumentException( 'La valeur spécifiée à la méthode OCFram\User::setAuthenticated() doit être un boolean' );
		}
		
		$_SESSION[ 'auth' ] = $authenticated;
	}
	
	public function setRole( $role = 'user' ) {
		if ( !is_string( $role)){
			throw new \InvalidArgumentException( 'La valeur spécifiée à la méthode OCFram\User::setRole() doit être un string');
		}
		
		$_SESSION['role'] = base64_encode($role);
		
	}
	
	public function setFlash( $value ) {
		$_SESSION[ 'flash' ] = $value;
	}
}