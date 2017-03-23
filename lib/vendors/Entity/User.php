<?php

namespace Entity;

use OCFram\Entity;

class User extends Entity {
	const INVALID_FIRSTNAME = 1;
	const INVALID_LASTNAME  = 2;
	const INVALID_USERNAME  = 3;
	const INVALID_EMAIL     = 4;
	const INVALID_PASSWORD  = 5;
	const FK_ROLE_INVALID   = 6;
	/** @var string $prefix Table prefix (used in the constructor) */
	protected $prefix = 'MEM_';
	protected $firstname, $lastname, $fk_MRC, $email, $username, $password, $birthdate, $dateregister;
	
	public function isValid() {
		return !( empty( $this->username ) || empty( $this->firstname ) );
	}
	
	// SETTERS //
	
	public function setFirstname( $firstname ) {
		if ( !is_string( $firstname ) || empty( $firstname ) ) {
			$this->errors[] = self::INVALID_FIRSTNAME;
		}
		$this->firstname = $firstname;
	}
	
	public function setLastname( $lastname ) {
		if ( !is_string( $lastname ) || empty( $lastname ) ) {
			$this->errors[] = self::INVALID_LASTNAME;
		}
		$this->lastname = $lastname;
	}
	
	public function setFk_MRC( $id ) {
		if ( !is_int( $id ) || empty( $id ) ) {
			$this->errors[] = self::FK_ROLE_INVALID;
		}
		$this->fk_MRC = $id;
	}
	
	public function setEmail( $email ) {
		if ( !is_string( $email ) || empty( $email ) ) {
			$this->errors[] = self::INVALID_EMAIL;
		}
		$this->email = $email;
	}
	
	public function setUsername( $username ) {
		if ( !is_string( $username ) || empty( $username ) ) {
			$this->errors[] = self::INVALID_USERNAME;
		}
		$this->username = $username;
	}
	
	public function setPassword( $password ) {
		if ( !is_string( $password ) || empty( $password ) ) {
			$this->errors[] = self::INVALID_PASSWORD;
		}
		$this->password = $password;
	}
	
	public function setBirthdate( \DateTime $birthdate ) {
		$this->birthdate = $birthdate;
	}
	
	public function setDateRegister( \DateTime $dateRegister ) {
		$this->dateregister = $dateRegister;
	}
	
	// GETTERS //
	
	public function firstname() {
		return $this->firstname;
	}
	
	public function fk_MRC() {
		return $this->fk_MRC;
	}
	
	public function lastname() {
		return $this->lastname;
	}
	
	public function email() {
		return $this->email;
	}
	
	public function username() {
		return $this->username;
	}
	
	public function password() {
		return $this->password;
	}
	
	public function birthdate() {
		return $this->birthdate;
	}
	
	public function dateRegister() {
		return $this->dateregister;
	}
}