<?php
namespace App\Frontend;

use App\Backend\BackendApplication;
use App\Frontend\Modules\News\NewsController as FrontNewsController;
use App\Frontend\Modules\Connexion\ConnexionController;
use App\Frontend\Modules\News\NewsController;
use Entity\Comment;
use Entity\News;
use Filter\EntityNotFoundFilter;
use Filter\GuestFilter;
use Filter\OwnCommentFilter;
use Filter\OwnNewsFilter;
use Filter\UserFilter;
use \OCFram\Application;
use OCFram\Menu;
use OCFram\MenuElement;
use OCFram\User;

class FrontendApplication extends Application {
	public function __construct() {
		parent::__construct();
		
		$this->name = 'Frontend';
	}
	
	public function run() {
		$controller = $this->getController();
		$controller->execute();
		
		$this->httpResponse->setPage( $controller->page() );
		$controller->page()->addVar( 'menu', $this->generateMenu() );
		$this->httpResponse->send();
	}
	
	private function generateMenu() {
		$menu = new Menu( $this );
		switch ( $this->user()->getRole() ) {
			case $this->user()->getEncrypted( User::ADMINROLE ):
				return BackendApplication::generateAdminMenu( $this );
				break;
			case $this->user()->getEncrypted( User::AUTHENTICATEDROLE ):
				$menu->addElement( new MenuElement( 'Accueil', FrontNewsController::getLinkToIndex() ) )
					 ->addElement( new MenuElement( 'Déconnexion', ConnexionController::getLinkToLogout() ) )
					 ->addElement( new MenuElement( 'Ajouter une news', FrontNewsController::getLinkToInsert() ) );
				break;
			case $this->user()->getEncrypted( User::DEFAULTROLE ):
				$menu->addElement( new MenuElement( 'Accueil', FrontNewsController::getLinkToIndex() ) )
					 ->addElement( new MenuElement( 'Connexion', ConnexionController::getLinkToLogin() ) )
					 ->addElement( new MenuElement( 'Inscription', ConnexionController::getLinkToRegister() ) );
				break;
		}
		
		return $menu->elements();
	}
	
	/**
	 * @param Application $App
	 *
	 * @return GuestFilter
	 */
	public static function buildGuestFilter( Application $App ) {
		return new GuestFilter( function() use ( $App ) {
			$App->user()->setFlash( 'Vous devez être connecté pour effecuter cette action' );
			$App->httpResponse()->redirect( NewsController::getLinkToIndex() );
		}, $App->user() );
	}
	
	/**
	 * @param Application $App
	 * @param string      $message
	 *
	 * @return UserFilter
	 */
	public static function buildUserFilter( Application $App, $message ) {
		return new UserFilter( function() use ( $App, $message ) {
			$App->user()->setFlash( $message );
			$App->httpResponse()->redirect( NewsController::getLinkToIndex() );
		}, $App->user() );
	}
	
	/**
	 * @param Application $App
	 * @param string      $message
	 * @param News        $news
	 *
	 * @return OwnNewsFilter
	 */
	public static function buildOwnNewsFilter( Application $App, $message, News $news ) {
		return new OwnNewsFilter( function() use ( $App, $message, $news ) {
			$App->user()->setFlash( $message );
			$App->httpResponse()->redirect( NewsController::getLinkToIndex() );
		}, $App->user(), $news );
	}
	
	/**
	 * @param Application $App
	 * @param string      $message
	 * @param Comment     $comment
	 *
	 * @return OwnCommentFilter
	 */
	public static function buildOwnCommentFilter( Application $App, $message, Comment $comment ) {
		return new OwnCommentFilter( function() use ( $App, $message ) {
			$App->user()->setFlash( $message );
			$App->httpResponse()->redirect( NewsController::getLinkToIndex() );
		}, $App->user(), $comment );
	}
	
	public static function buildEntityNotFoundFilter( Application $App, $manager, $method, $additionnal_method_params ) {
		return new EntityNotFoundFilter( function() use ($App){
			$App->httpResponse()->redirect404();
		}, $App->user(), $manager, $method, $additionnal_method_params );
	}
}