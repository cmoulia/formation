<?php

namespace OCFram;

class TextField extends Field {
	protected $cols;
	protected $rows;
	
	public function buildWidget() {
		$widget = '';
		
		if ( !empty( $this->errorMessage ) ) {
			$widget .= $this->errorMessage . '<br />';
		}
		
		$widget .= '<label>' . $this->label . '</label><textarea name="' . $this->name . '"';
		
		if ( !empty( $this->cols ) ) {
			$widget .= ' cols="' . $this->cols . '"';
		}
		
		if ( !empty( $this->rows ) ) {
			$widget .= ' rows="' . $this->rows . '"';
		}
		
		$widget .= '>';
		
		if ( !empty( $this->value ) ) {
			$widget .= htmlentities( $this->value );
		}
		
		return $widget . '</textarea>';
	}
	
	public function setCols( $cols ) {
		if ( !is_int( $cols ) || $cols <= 0 ) {
			throw new \InvalidArgumentException('Column attribute should be an integer and greater than 0');
		}
		$this->cols = $cols;
	}
	
	public function setRows( $rows ) {
		if ( !is_int( $rows ) || $rows <= 0 ) {
			throw new \InvalidArgumentException('Rows attribute should be an integer and greater than 0');
		}
		$this->cols = $rows;
	}
}