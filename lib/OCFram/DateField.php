<?php

namespace OCFram;

class DateField extends Field {
	public function buildWidget() {
		$widget = '';
		
		if ( !empty( $this->errorMessage ) ) {
			$widget .= $this->errorMessage . '<br />';
		}
		
		$widget .= '<label>' . $this->label . '</label><input type="date" name="' . $this->name . '" ';
		if ( !empty( $this->value ) ) {
			$widget .= ' value="' . date_format( new \DateTime( $this->value ), "Y-m-d" ) . '"';
		}
		
		$widget .= ' />';
		
		return $widget;
	}
}