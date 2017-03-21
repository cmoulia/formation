<?php

namespace App\Backend\Modules\Connexion;

use Entity\User;
use Model\UserManager;
use \OCFram\BackController;
use \OCFram\HTTPRequest;

class ConnexionController extends BackController {
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
}