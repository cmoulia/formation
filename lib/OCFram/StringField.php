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
		
		$widget .= '<label>' . $this->label . '</label><input ';
		
		if ( !empty( $this->type ) ) {
			$widget .= ' type="' . htmlspecialchars( $this->type ) . '"';
		}
		
		$widget .= ' name="' . $this->name . '"';
		
		if ( !empty( $this->value ) ) {
			$widget .= ' value="' . htmlspecialchars( $this->value ) . '"';
		}
		
		if ( !empty( $this->maxLength ) ) {
			$widget .= ' maxlength="' . $this->maxLength . '"';
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