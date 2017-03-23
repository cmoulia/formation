<?php

namespace OCFram;


abstract class FormBuilder {
	/** @var Form $form */
	protected $form;
	/** @var Entity $entity */
	protected $entity;
	/** @var Manager $manager */
	protected $manager;
	/** @var boolean $authenticated */
	protected $authenticated;
	
	public function __construct( Entity $entity, Manager $manager, $authenticated ) {
		$this->setAuthenticated($authenticated);
		$this->setEntity( $entity );
		$this->setForm( new Form( $entity ) );
		$this->setManager($manager);
	}
	
	abstract public function build();
	
	public function setAuthenticated( $authenticated ) {
		$this->authenticated = $authenticated;
	}
	
	public function setEntity( Entity $entity ) {
		$this->entity = $entity;
	}
	
	public function setForm( Form $form ) {
		$this->form = $form;
	}
	
	public function setManager( Manager $manager ) {
		$this->manager = $manager;
	}
	
	public function authenticated() {
		return $this->authenticated;
	}
	
	public function entity() {
		return $this->entity;
	}
	
	public function form() {
		return $this->form;
	}
	
	public function manager() {
		return $this->manager;
	}
	
}