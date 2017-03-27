<?php

namespace App\Backend;

use \OCFram\Application;
use OCFram\RouterFactory;

class BackendApplication extends Application {
	public function __construct() {
		parent::__construct();
		
		$this->name = 'Backend';
	}
	
	public function run() {
		if ( $this->user->isAuthenticated() && $this->user->isAdmin() ) {
			$controller = $this->getController();
		}
		else {
			$this->httpResponse()->redirect( RouterFactory::getRouter( 'Frontend' )->getUrl( 'Connexion', 'login' ) );
		}
		
		$controller->execute();
		
		$this->httpResponse->setPage( $controller->page() );
		$this->httpResponse->send();
	}
}