<?php

namespace OCFram;

use Model\CommentsManager;
use Model\NewsManager;
use Model\RoleManager;
use Model\UserManager;

class FormHandler {
	/** @var Form $form */
	protected $form;
	/** @var NewsManager|CommentsManager|UserManager|RoleManager $manager */
	protected $manager;
	/** @var HTTPRequest $request */
	protected $request;
	
	public function __construct( Form $form, Manager $manager, HTTPRequest $request ) {
		$this->setForm( $form );
		$this->setManager( $manager );
		$this->setRequest( $request );
	}
	
	public function setForm( Form $form ) {
		$this->form = $form;
	}
	
	public function setManager( Manager $manager ) {
		$this->manager = $manager;
	}
	
	public function setRequest( HTTPRequest $request ) {
		$this->request = $request;
	}
	
	public function process() {
		if ( $this->request->method() == 'POST' && $this->form->isValid() ) {
			$this->manager->save( $this->form->entity() );
			
			return true;
		}
		
		return false;
	}
}