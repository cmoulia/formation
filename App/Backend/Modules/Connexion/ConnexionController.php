<?php

namespace App\Backend\Modules\Connexion;

use Entity\User;
use FormBuilder\UserFormBuilder;
use Model\UserManager;
use \OCFram\BackController;
use OCFram\FormHandler;
use \OCFram\HTTPRequest;

class ConnexionController extends BackController {
	public function executeDelete( HTTPRequest $request ) {
		$userId = $request->getData( 'id' );
		
		$this->managers->getManagerOf( 'User' )->delete( $userId );
		
		$this->app->user()->setFlash( 'L\'utilisateur a bien été supprimé !' );
		
		$this->app->httpResponse()->redirect( '.' );
	}
	
	public function executeIndex( HTTPRequest $request ) {
		$this->page->addVar( 'title', 'Liste des Utilisateurs' );
		
		// On récupère le manager des news.
		$manager = $this->managers->getManagerOf( 'User' );
		
		// On ajoute la variable $listeUsers à la vue.
		$this->page->addVar( 'listeUsers', $manager->getList() );
		$this->page->addVar( 'nombreUsers', $manager->count() );
	}
	
	public function executeInsert( HTTPRequest $request ) {
		$this->processForm( $request );
		
		$this->page->addVar( 'title', 'Ajout d\'un utilisateur' );
	}
	
	public function executeLogin( HTTPRequest $request ) {
		$this->page->addVar( 'title', 'Connexion' );
		
		if ( $request->postExists( 'login' ) ) {
			$login    = $request->postData( 'login' );
			$password = $request->postData( 'password' );
			
			/** @var UserManager $manager */
			$manager = $this->managers->getManagerOf( 'User' );
			
			if ( $id = $manager->getIdByUsernameOrEmail( $login ) ) {
				/** @var User $user */
				$user = $manager->getUnique( $id );
				if ( $password == $user->password() ) {
					$this->app->user()->setAuthenticated( true );
					$this->app->user()->setFlash( 'Connexion réussie' );
					$this->app->httpResponse()->redirect( '.' );
				}
				else {
					$this->app->user()->setFlash( 'Le pseudo ou le mot de passe est incorrect.' );
				}
			}
			else {
				$this->app->user()->setFlash( 'Le pseudo ou le mot de passe est incorrect.' );
			}
			/*			if ( $login == $this->app->config()->get( 'login' ) && $password == $this->app->config()->get( 'pass' ) ) {
							$this->app->user()->setAuthenticated( true );
							$this->app->httpResponse()->redirect( '.' );
						}
						else {
							$this->app->user()->setFlash( 'Le pseudo ou le mot de passe est incorrect.' );
						}*/
		}
	}
	
	public function executeLogout( HTTPRequest $request ) {
		session_unset();
		session_destroy();
		$this->app->httpResponse()->redirect( '/' );
	}
	
	public function executeUpdate( HTTPRequest $request ) {
		$this->processForm( $request );
		
		$this->page->addVar( 'title', 'Modification d\'un utilisateur' );
	}
	
	public function processForm( HTTPRequest $request ) {
		if ( $request->method() == 'POST' ) {
			$user = new User( [
				'firstname'  => $request->postData( 'firstname' ),
				'lastname'   => $request->postData( 'lastname' ),
				'email' => $request->postData( 'email' ),
				'username' => $request->postData( 'username' ),
				'password' => $request->postData( 'password' ),
				'birthdate' => new \DateTime($request->postData( 'birthdate' )),
			] );
			
//			var_dump($user);die;
			
			if ( $request->getExists( 'id' ) ) {
				$user->setId( $request->getData( 'id' ) );
			}
		}
		else {
			// L'identifiant de l\'utilisateur est transmis si on veut le modifier
			if ( $request->getExists( 'id' ) ) {
				$user = $this->managers->getManagerOf( 'User' )->getUnique( $request->getData( 'id' ) );
			}
			else {
				$user = new User;
			}
		}
		
		$formBuilder = new UserFormBuilder( $user );
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		$formHandler = new FormHandler( $form, $this->managers->getManagerOf( 'User' ), $request );
		
		if ( $formHandler->process() ) {
			$this->app->user()->setFlash( $user->isNew() ? 'L\'utilisateur a bien été ajouté !' : 'L\'utilisateur a bien été modifié !' );
			$this->app->httpResponse()->redirect( '/admin/' );
		}
		
		$this->page->addVar( 'form', $form->createView() );
	}
}