<?php

namespace OCFram;


abstract class FormBuilder {
	protected $form;
	protected $manager;
	protected $authenticated;
	
	public function __construct( Entity $entity, Manager $manager, $authenticated ) {
		$this->setForm( new Form( $entity ) );
		$this->setManager($manager);
		$this->setAuthenticated($authenticated);
	}
	
	abstract public function build();
	
	public function setForm( Form $form ) {
		$this->form = $form;
	}
	
	public function setManager( Manager $manager ) {
		$this->manager = $manager;
	}
	
	public function setAuthenticated( $authenticated ) {
		$this->authenticated = $authenticated;
	}
	
	public function form() {
		return $this->form;
	}
	
	public function manager() {
		return $this->manager;
	}
	public function authenticated() {
		return $this->authenticated;
	}
	
}