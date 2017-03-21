<?php

namespace OCFram;

use App\Backend\Modules\Connexion\ConnexionController;

abstract class FormBuilder {
	protected $form;
	protected $controller;
	
	public function __construct( Entity $entity, ConnexionController $controller ) {
		$this->setForm( new Form( $entity ) );
		$this->setController( $controller );
	}
	
	public function setForm( Form $form ) {
		$this->form = $form;
	}
	
	public function setController( ConnexionController $controller ) {
		$this->controller = $controller;
	}
	
	abstract public function build();
	
	public function form() {
		return $this->form;
	}
	
	public function controller() {
		return $this->form;
	}
}