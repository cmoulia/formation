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
			$this->httpResponse()->redirect( ConnexionController::getLinkToLogin() );
		}
		
		$controller->execute();
		
		$this->httpResponse->setPage( $controller->page() );
		$controller->page()->addVar( 'menu', self::generateAdminMenu( $this ) );
		$this->httpResponse->send();
	}
	
	static public function generateAdminMenu( $instance ) {
		$menu = new Menu( $instance );
		$menu->addElement( new MenuElement( 'Front Office', FrontNewsController::getLinkToIndex() ) );
		$menu->addElement( new MenuElement( 'Back Office', BackNewsController::getLinkToIndex() ) );
		$menu->addElement( new MenuElement( 'Déconnexion', ConnexionController::getLinkToLogout() ) );
		$menu->addElement( new MenuElement( 'Ajouter une news', FrontNewsController::getLinkToInsert() ) );
		$menu->addElement( new MenuElement( 'Liste des rôles', RoleController::getLinkToIndex() ) );
		$menu->addElement( new MenuElement( 'Liste des utilisateurs', UserController::getLinkToIndex() ) );
		
		return $menu->elements();
	}
}