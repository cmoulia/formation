<?php

namespace App\Frontend\Modules\Connexion;

use Entity\User;
use FormBuilder\UserFormBuilder;
use OCFram\BackController;
use OCFram\FormHandler;
use OCFram\HTTPRequest;

class ConnexionController extends BackController {
	public function execute404( HTTPRequest $request ) {
		$this->app->user()->setFlash('404 Not Found !');
		$this->app->httpResponse()->redirect('/');
	}
	
	public function executeLogin( HTTPRequest $request ) {
		if ( $this->app->user()->isAuthenticated() && $this->app->user()->isAdmin() ) {
			$this->app->user()->setFlash( 'Vous êtes déjà connecté' );
			$this->app->httpResponse()->redirect( '/admin/' );
		}
		if ( $this->app->user()->isAuthenticated() && !$this->app->user()->isAdmin() ) {
			$this->app->httpResponse()->redirect( '/' );
		}
		
		$this->page->addVar( 'title', 'Connexion' );
		
		if ( $request->postExists( 'login' ) ) {
			$login    = $request->postData( 'login' );
			$password = $request->postData( 'password' );
			
			/** @var \Model\UserManager $manager */
			$manager = $this->managers->getManagerOf( 'User' );
			
			/** @var \Entity\User $user */
			if ( $user = $manager->getUniqueByUsernameOrEmail( $login ) ) {
				if ( $password == $user->password() ) {
					$this->app->user()->setAuthenticated( true );
					$this->app->user()->setAttribute( 'user', $user );
					
					$this->app->user()->setFlash( 'Connexion réussie' );
					if ( ( $user->fk_MRC() == 1 ) ) {
						$this->app->user()->setRole( 'admin' );
						$this->app->httpResponse()->redirect( '/admin/' );
					}
					else {
						$this->app->user()->setRole();
						$this->app->httpResponse()->redirect( '.' );
					}
				}
				else {
					$this->app->user()->setFlash( 'Le pseudo ou le mot de passe est incorrect.' );
				}
			}
			else {
				$this->app->user()->setFlash( 'Le pseudo ou le mot de passe est incorrect.' );
			}
		}
	}
	
	public function executeLogout( HTTPRequest $request ) {
		session_unset();
		session_destroy();
		$this->app->httpResponse()->redirect( '/' );
	}
	
	public function executeRegister( HTTPRequest $request ) {
		$this->processForm( $request );
		
		$this->page->addVar( 'title', 'Inscription' );
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
				'email'     => strtolower( $request->postData( 'email' ) ),
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
			$isNew = false;
			// L'identifiant de l\'utilisateur est transmis si on veut le modifier
			if ( $request->getExists( 'id' ) ) {
				$user  = $this->managers->getManagerOf( 'User' )->getUnique( $request->getData( 'id' ) );
			}
			else {
				$user = new User;
			}
		}
		
		// If is not authenticated, register
		// If is authenticated, user update his info
		$formBuilder = new UserFormBuilder( $user, $this->managers->getManagerOf( 'User' ), $this->app->user() );
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		$formHandler = new FormHandler( $form, $this->managers->getManagerOf( 'User' ), $request );
		
		if ( $formHandler->process() ) {
			$this->app->user()->setFlash( $isNew ? 'L\'inscription s\'est bien déroulé !' : 'La modification de vos informations s\'est bien déroulé !' );
			if ( $isNew ) {
				$this->app->user()->setAuthenticated( true );
				$this->app->user()->setRole();
			}
			$this->app->user()->setAttribute( 'user', $user );
			
			$this->app->httpResponse()->redirect( '/' );
		}
		
		$this->page->addVar( 'form', $form->createView() );
	}
}