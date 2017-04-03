<?php

namespace OCFram;

class Menu extends ApplicationComponent {
	protected $authlevel;
	protected $elements = [];
	
	
	public function __construct( Application $app, array $elements = [] ) {
		parent::__construct( $app );
		$this->setElements($elements);
	}
	
	/**
	 * @param MenuElement $element
	 *
	 * @return $this
	 */
	public function addElement(MenuElement $element){
		$this->elements[] = $element;
		return $this;
	}
	
	public function elements(){
		return $this->elements;
	}
	
	/**
	 * @param array $elements
	 */
	public function setElements( $elements ) {
		$this->elements = $elements;
	}
}