<?php

namespace App\Backend\Modules\Role;

use Entity\Role;
use FormBuilder\RoleFormBuilder;
use OCFram\BackController;
use OCFram\FormHandler;
use OCFram\HTTPRequest;

class RoleController extends BackController {
	public function executeDelete( HTTPRequest $request ) {
		$this->managers->getManagerOf( 'Role' )->delete( $request->getData( 'id' ) );
		$this->app->user()->setFlash( 'Le rôle a bien été supprimé !' );
		$this->app->httpResponse()->redirect( '/admin/roles' );
	}
	
	public function executeIndex( HTTPRequest $request ) {
		$this->page->addVar( 'titie', 'Liste des rôles' );
		$this->page->addVar( ( 'role_a' ), $this->managers->getManagerOf( 'Role' )->getList() );
	}
	
	public function executeInsert( HTTPRequest $request ) {
		$this->processForm( $request );
		
		$this->page->addVar( 'title', 'Ajout d\'un rôle' );
	}
	
	public function executeUpdate( HTTPRequest $request ) {
		$this->processForm( $request );
		
		$this->page->addVar( 'title', 'Modification d\'un rôle' );
	}
	
	public function processForm( HTTPRequest $request ) {
		if ( $request->method() == 'POST' ) {
			$role = new Role( [
				'name'        => $request->postData( 'name' ),
				'description' => $request->postData( 'description' ),
			] );
			
			if ( $request->getExists( 'id' ) ) {
				$role->setId( $request->getData( 'id' ) );
			}
		}
		else {
			// L'identifiant du rôle est transmis si on veut le modifier
			if ( $request->getExists( 'id' ) ) {
				$role = $this->managers->getManagerOf( 'Role' )->getUnique( $request->getData( 'id' ) );
			}
			else {
				$role = new Role;
			}
		}
		
		$formBuilder = new RoleFormBuilder( $role, $this->managers->getManagerOf('Role'),$this->app->user()->isAuthenticated() );
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		$formHandler = new FormHandler( $form, $this->managers->getManagerOf( 'Role' ), $request );
		
		if ( $formHandler->process() ) {
			$this->app->user()->setFlash( $role->isNew() ? 'Le rôle a bien été ajouté !' : 'Le rôle a bien été modifié !' );
			$this->app->httpResponse()->redirect( '/admin/' );
		}
		
		$this->page->addVar( 'form', $form->createView() );
	}
}