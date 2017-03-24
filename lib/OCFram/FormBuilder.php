<?php

namespace OCFram;


abstract class FormBuilder {
	/** @var Form $form */
	protected $form;
	/** @var Entity $entity */
	protected $entity;
	/** @var Manager $manager */
	protected $manager;
	/** @var User $user */
	protected $user;
	
	public function __construct( Entity $entity, Manager $manager, $user ) {
		$this->setUser( $user );
		$this->setEntity( $entity );
		$this->setForm( new Form( $entity ) );
		$this->setManager( $manager );
	}
	
	abstract public function build();
	
	public function isAdmin() {
		return $this->user->isAdmin();
	}
	
	public function setUser( $user ) {
		$this->user = $user;
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
	
	public function user() {
		return $this->user;
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