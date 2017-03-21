<?php

namespace Entity;

use OCFram\Entity;

class User extends Entity {
	const PRENOM_INVALIDE = 1;
	const NOM_INVALIDE    = 2;
	const PSEUDO_INVALIDE = 3;
	protected $prefix = 'MMC_';
	protected $firstname, $lastname, $email, $username, $password, $birthdate, $dateregister;
	
	public function isValid() {
		return !( empty( $this->username ) || empty( $this->firstname ) || empty( $this->dateregister ) );
	}
	
	// SETTERS //
	
	public function setFirstname( $firstname ) {
		if ( !is_string( $firstname ) || empty( $firstname ) ) {
			$this->errors[] = self::PRENOM_INVALIDE;
		}
		
		$this->firstname = $firstname;
	}
	
	public function setLastname( $lastname ) {
		if ( !is_string( $lastname ) || empty( $lastname ) ) {
			$this->errors[] = self::NOM_INVALIDE;
		}
		
		$this->lastname = $lastname;
	}
	
	public function setUsername( $username ) {
		if ( !is_string( $username ) || empty( $username ) ) {
			$this->errors[] = self::PSEUDO_INVALIDE;
		}
		
		$this->username = $username;
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