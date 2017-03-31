<?php

namespace App\Backend;

use App\Backend\Modules\News\NewsController as BackNewsController;
use App\Backend\Modules\Role\RoleController;
use App\Backend\Modules\User\UserController;
use App\Frontend\Modules\News\NewsController as FrontNewsController;
use App\Frontend\Modules\Connexion\ConnexionController;
use \OCFram\Application;
use OCFram\Menu;
use OCFram\MenuElement;
use OCFram\MenuHelper;
use OCFram\User;

class BackendApplication extends Application {
	public function __construct() {
		parent::__construct();
		
		$this->name = 'Backend';
	}
	
	use MenuHelper;
	
	public function run() {
		if ( $this->user->isAuthenticated() && $this->user->isAdmin() ) {
			$controller = $this->getController();
		}
		else {
			$this->httpResponse()->redirect( ConnexionController::getLinkTo( 'login' ) );
		}
		
		$controller->execute();
		
		$this->httpResponse->setPage( $controller->page() );
		$this->generateMenu();
		$controller->page()->addVar( 'menu', $this->getMenu( $this->user )->elements() );
		$this->httpResponse->send();
	}
	
	private function generateMenu() {
		$adminmenu = new Menu( $this, User::ADMINROLE );
		$adminmenu->addElement( new MenuElement( 'Front Office', FrontNewsController::getLinkTo( 'index' ), 0 ) );
		$adminmenu->addElement( new MenuElement( 'Back Office', BackNewsController::getLinkTo( 'index' ), 0 ) );
		$adminmenu->addElement( new MenuElement( 'Déconnexion', ConnexionController::getLinkTo( 'logout' ), 0 ) );
		$adminmenu->addElement( new MenuElement( 'Ajouter une news', FrontNewsController::getLinkTo( 'insert' ), 0 ) );
		$adminmenu->addElement( new MenuElement( 'Liste des rôles', RoleController::getLinkTo( 'index' ), 0 ) );
		$adminmenu->addElement( new MenuElement( 'Liste des utilisateurs', UserController::getLinkTo( 'index' ), 0 ) );
		
		$this->addMenu( $adminmenu );
	}
}