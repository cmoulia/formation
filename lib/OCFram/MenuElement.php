<?php

namespace OCFram;

class MenuElement {
	protected $label;
	protected $link;
	protected $level;
	protected $children = [];
	
	public function __construct( $label, $link, $level = 0 ) {
		$this->setLabel( $label );
		$this->setLink( $link );
		$this->level = $level;
	}
	
	public function addChild( $label, $link ) {
		$this->children[] = new MenuElement( $label, $link, $this->level + 1 );
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
	
	public function label() {
		return $this->label;
	}
	
	public function link() {
		return $this->link;
	}
	
	public function level() {
		return $this->level;
	}
}