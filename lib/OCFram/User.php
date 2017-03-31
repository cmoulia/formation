<?php

namespace OCFram;

session_start();

class User {
	const DEFAULTROLE = 'visitor';
	const AUTHENTICATEDROLE = 'user';
	const ADMINROLE = 'admin';
	
	public function getAttribute( $attr ) {
		return isset( $_SESSION[ $attr ] ) ? $_SESSION[ $attr ] : null;
	}
	
	public function setAttribute( $attr, $value ) {
		$_SESSION[ $attr ] = $value;
	}
	
	public function getFlash() {
		$flash = $_SESSION[ 'flash' ];
		unset( $_SESSION[ 'flash' ] );
		
		return $flash;
	}
	
	public function hasFlash() {
		return isset( $_SESSION[ 'flash' ] );
	}
	
	public function setFlash( $value ) {
		$_SESSION[ 'flash' ] = $value;
	}
	
	public function isAuthenticated() {
		return isset( $_SESSION[ 'auth' ] ) && $_SESSION[ 'auth' ] === true;
	}
	
	public function isAdmin() {
		return $_SESSION[ 'role' ] == $this->encrypt(self::ADMINROLE);
	}
	
	public function getEncrypted($value){
		return $this->encrypt($value);
	}
	
	public function setAuthenticated( $authenticated = true ) {
		if ( !is_bool( $authenticated ) ) {
			throw new \InvalidArgumentException( 'La valeur spécifiée à la méthode OCFram\User::setAuthenticated() doit être un boolean' );
		}
		$_SESSION[ 'auth' ] = $authenticated;
	}
	
	public function isRole($role){
		return $_SESSION['role'] == $this->encrypt($role);
	}
	
	public function getRole(){
		return $_SESSION['role'];
	}
	
	public function setRole( $role = self::AUTHENTICATEDROLE ) {
		if ( !is_string( $role ) ) {
			throw new \InvalidArgumentException( 'La valeur spécifiée à la méthode OCFram\User::setRole() doit être un string' );
		}
		$_SESSION[ 'role' ] = $this->encrypt( $role );
	}
	
	private function encrypt( $value ) {
		return base64_encode( $value );
	}
}