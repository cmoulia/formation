<?php

namespace Entity;

use OCFram\Entity;

class Role extends Entity {
	const INVALID_NAME        = 1;
	const INVALID_DESCRIPTION = 2;
	/** @var string $prefix Table prefix (used in the constructor) */
	protected $prefix = 'MRC_';
	protected $name, $description;
	
	public function isValid() {
		return !( empty( $this->name ) || empty( $this->description ) );
	}
	
	// SETTERS //
	
	public function setName( $name ) {
		if ( !is_string( $name ) || empty( $name ) ) {
			$this->errors[] = self::INVALID_NAME;
		}
		$this->name = $name;
	}
	
	public function setDescription( $description ) {
		if ( !is_string( $description ) || empty( $description ) ) {
			$this->errors[] = self::INVALID_DESCRIPTION;
		}
		$this->description = $description;
	}
	
	// GETTERS //
	
	public function name() {
		return $this->name;
	}
	
	public function description() {
		return $this->description;
	}
}