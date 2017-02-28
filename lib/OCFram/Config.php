<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 28/02/2017
 * Time: 10:05
 */

namespace OCFram;


class Config extends ApplicationComponent {
	protected $vars = [];
	
	public function get( $var ) {
		if ( !$this->vars ) {
			$xml = new \DOMDocument();
			$xml->load( __DIR__ . '/../../app/' . $this->app->getName() . '/config/app.xml' );
			
			$elements = $xml->getElementsByTagName( 'define' );
			
			foreach ( $elements as $element ) {
				$this->vars[ $element->getAttribute( 'var' ) ] = $element->getAttribute( 'value' );
			}
		}
		
		if ( isset( $this->vars[ $var ] ) ) {
			return $this->vars[ $var ];
		}
		
		return null;
	}
}