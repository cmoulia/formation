<?php

namespace OCFram;

class Menu extends ApplicationComponent {
	protected $authlevel;
	protected $elements = [];
	
	public function __construct( Application $app, $authlevel, array $elements = [] ) {
		parent::__construct( $app );
		$this->setAuthlevel($authlevel);
		$this->setElements($elements);
	}
	/**
	 * @param MenuElement $element
	 */
	public function addElement(MenuElement $element){
		$this->elements[] = $element;
	}
	
	public function authlevel(){
		return $this->authlevel;
	}
	
	public function elements(){
		return $this->elements;
	}
	
	/**
	 * @param string $authlevel
	 */
	protected function setAuthlevel( $authlevel ) {
		$this->authlevel = $authlevel;
	}
	
	/**
	 * @param array $elements
	 */
	public function setElements( $elements ) {
		$this->elements = $elements;
	}
}

class MenuElement {
	protected $label;
	protected $link;
	protected $level;
	protected $children = [];
	
	public function __construct( $label, $link, $level ) {
		$this->setLabel($label);
		$this->setLink($link);
		$this->level=$level;
	}
	
	public function addChild($label, $link){
		$this->children[] = new MenuElement($label, $link, $this->level + 1);
	}
	
	/**
	 * @param string $label
	 */
	public function setLabel( $label ) {
		$this->label = $label;
	}
	
	/**
	 * @param string $link
	 */
	public function setLink( $link ) {
		$this->link = $link;
	}
	
	public function label(){
		return $this->label;
	}
	
	public function link(){
		return $this->link;
	}
	
	public function level(){
		return $this->level;
	}
}