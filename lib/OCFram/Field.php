<?php

namespace OCFram;

abstract class Field {
	use Hydrator;
	protected $errorMessage;
	protected $id;
	protected $label;
	protected $length;
	protected $name;
	protected $required;
	protected $validators = [];
	protected $value;
	
	public function __construct( array $options = [] ) {
		if ( !empty( $options ) ) {
			$this->hydrate( $options );
		}
	}
	
	abstract public function buildWidget();
	
	public function isValid() {
		foreach ( $this->validators as $validator ) {
			if ( !$validator->isValid( $this->value ) ) {
				$this->errorMessage = $validator->errorMessage();
				
				return false;
			}
		}
		
		return true;
	}
	
	// SETTERS //
	
	public function setId( $id ) {
		if (is_string($id)){
			$this->id = $id;
		}
	}
	
	public function setLabel( $label ) {
		if ( is_string( $label ) ) {
			$this->label = $label;
		}
	}
	
	public function setLength( $length ) {
		$length = (int)$length;
		
		if ( $length > 0 ) {
			$this->length = $length;
		}
	}
	
	public function setName( $name ) {
		if ( is_string( $name ) ) {
			$this->name = $name;
		}
	}
	
	public function setRequired( $required ) {
		if (is_bool($required)){
			$this->required = $required;
		}
	}
	
	public function setValidators( array $validators ) {
		foreach ( $validators as $validator ) {
			if ( $validator instanceof Validator && !in_array( $validator, $this->validators ) ) {
				$this->validators[] = $validator;
			}
		}
	}
	
	public function setValue( $value ) {
		if ( is_string( $value ) ) {
			$this->value = $value;
		}
	}
	
	// GETTERS //
	
	public function id() {
		return $this->id;
	}
	
	public function label() {
		return $this->label;
	}
	
	public function length() {
		return $this->length;
	}
	
	public function name() {
		return $this->name;
	}
	
	public function required(){
		return $this->required;
	}
	
	public function validators() {
		return $this->validators;
	}
	
	public function value() {
		return $this->value;
	}
	
	public function errorMessage() {
		return $this->errorMessage;
	}
}