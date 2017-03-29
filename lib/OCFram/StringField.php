<?php

namespace OCFram;

class StringField extends Field {
	protected $maxLength;
	protected $type = 'text';
	
	public function buildWidget() {
		$widget = '';
		
		if ( !empty( $this->errorMessage ) ) {
			$widget .= $this->errorMessage . '<br />';
		}
		
		$widget .= '<label';
		
		if ( !empty( $this->id ) ) {
			$widget .= ' for="' . $this->id . '"';
		}
		$widget .= '>' . $this->label . '</label><input name="' . $this->name . '"';
		
		if ( !empty( $this->type ) ) {
			$widget .= ' type="' . htmlentities( $this->type ) . '"';
		}
		
		if ( !empty( $this->id ) ) {
			$widget .= ' id="' . $this->id . '"';
		}
		
		if ( !empty( $this->value ) && $this->type != 'password' ) {
			$widget .= ' value="' . htmlentities( $this->value ) . '"';
		}
		
		if ( !empty( $this->maxLength ) ) {
			$widget .= ' maxlength="' . $this->maxLength . '"';
		}
		
		if ($this->required){
			$widget .= ' required';
		}
		
		$widget .= ' />';
		
		return $widget;
	}
	
	public function setMaxLength( $maxLength ) {
		if ( !is_int( $maxLength ) || $maxLength <= 0 ) {
			throw new \InvalidArgumentException( 'MaxLength attribute should be an integer and greater than 0' );
		}
		$this->maxLength = $maxLength;
	}
	
	public function setType( $type ) {
		$this->type = $type;
	}
}