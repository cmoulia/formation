<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 28/02/2017
 * Time: 10:05
 */

namespace OCFram;


/**
 * Class Config
 *
 * @package OCFram
 */
class Config extends ApplicationComponent {
	/**
	 * @var array
	 */
	protected $vars = [];
	
	/**
	 * @param $var
	 *
	 * @return mixed|null
	 */
	public function get( $var ) {
		if ( !$this->vars ) {
			$xml = new \DOMDocument();
			$xml->load( __DIR__ . '/../../App/' . $this->app->getName() . '/Config/App.xml' );
			
			$elements = $xml->getElementsByTagName( 'define' );
			
			/** @var \DOMElement $element */
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