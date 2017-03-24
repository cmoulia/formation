<?php

namespace App\Backend\Modules\Users;

use Entity\User;
use FormBuilder\AdminUserFormBuilder;
use FormBuilder\UserFormBuilder;
use \OCFram\BackController;
use \OCFram\FormHandler;
use \OCFram\HTTPRequest;

class UsersController extends BackController {
	
	public function execute404( HTTPRequest $request ) {
		$this->app->user()->setFlash('404 Not Found !');
		$this->app->httpResponse()->redirect('/admin/');
	}
	
	public function executeDelete( HTTPRequest $request ) {
		$userId = $request->getData( 'id' );
		
		$this->managers->getManagerOf( 'User' )->delete( $userId );
		
		$this->app->user()->setFlash( 'L\'utilisateur a bien été supprimé !' );
		
		$this->app->httpResponse()->redirect( '/admin/users' );
	}
	
	public function executeIndex( HTTPRequest $request ) {
		$this->page->addVar( 'title', 'Liste des Utilisateurs' );
		
		// On récupère le manager des user.
		$manager = $this->managers->getManagerOf( 'User' );
		
		// On ajoute la variable $listeUsers à la vue.
		$this->page->addVar( 'listeUsers', $manager->getList() );
		$this->page->addVar( 'nombreUsers', $manager->count() );
	}
	
	public function executeInsert( HTTPRequest $request ) {
		$this->processForm( $request );
		
		$this->page->addVar( 'title', 'Ajout d\'un utilisateur' );
	}
	
	public function executeUpdate( HTTPRequest $request ) {
		$this->processForm( $request );
		
		$this->page->addVar( 'title', 'Modification d\'un utilisateur' );
	}
	
	public function processForm( HTTPRequest $request ) {
		$isNew = true;
		if ( $request->method() == 'POST' ) {
			$user = new User( [
				'firstname' => $request->postData( 'firstname' ),
				'lastname'  => $request->postData( 'lastname' ),
				'email'     => $request->postData( 'email' ),
				'username'  => $request->postData( 'username' ),
				'password'  => $request->postData( 'password' ),
				'birthdate' => new \DateTime( $request->postData( 'birthdate' ) ),
			] );
			
			if ( $request->getExists( 'id' ) ) {
				$isNew = false;
				$user->setId( $request->getData( 'id' ) );
			}
		}
		else {
			// L'identifiant de l\'utilisateur est transmis si on veut le modifier
			if ( $request->getExists( 'id' ) ) {
				$isNew = false;
				$user  = $this->managers->getManagerOf( 'User' )->getUnique( $request->getData( 'id' ) );
			}
			else {
				$user = new User;
			}
		}
		
		// If user, admin update user info
		$formBuilder = new AdminUserFormBuilder( $user, $this->managers->getManagerOf( 'User' ), $this->app->user(), $request->getExists( 'id' ) );
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		$formHandler = new FormHandler( $form, $this->managers->getManagerOf( 'User' ), $request );
		
		if ( $formHandler->process() ) {
			$this->app->user()->setFlash( $isNew ? 'L\'utilisateur a bien été ajouté !' : 'L\'utilisateur a bien été modifié !' );
			$this->app->httpResponse()->redirect( '/admin/users' );
		}
		
		$this->page->addVar( 'form', $form->createView() );
	}
}