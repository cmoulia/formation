<?php

namespace App\Frontend\Modules\News;

use App\Frontend\FrontendApplication;
use \Entity\News;
use FormBuilder\NewsFormBuilder;
use OCFram\Application;
use \OCFram\BackController;
use OCFram\Field;
use OCFram\Filterable;
use \OCFram\Form;
use \OCFram\HTTPRequest;
use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \OCFram\FormHandler;
use OCFram\Page;
use OCFram\Router;
use OCFram\RouterFactory;
use OCFram\User;

class NewsController extends BackController implements Filterable {
	public function getFilterableFilter() {
		switch ( $this->action ) {
			case "index":
			case "insertComment":
			case "insertCommentJson":
			case "refreshCommentJson":
			case "show":
				return [];
				break;
			case "delete":
			case "update":
				return [
					FrontendApplication::buildGuestFilter( $this->app ),
					FrontendApplication::buildOwnNewsFilter(
						$this->app,
						'Impossible de modifier les news des autres membres.',
						$this->managers->getManagerOf( 'News' )->getUnique( $this->app()->httpRequest()->getData( 'id' ) )
					),
				];
				break;
			case "deleteComment":
			case "deleteCommentJson":
			case "updateComment":
			case "updateCommentJson":
				return [
					FrontendApplication::buildGuestFilter( $this->app ),
					FrontendApplication::buildOwnCommentFilter(
						$this->app,
						'Impossible de modifier les commantires des autres membres.',
						$this->managers->getManagerOf( 'Comments' )->getUnique( $this->app()->httpRequest()->getData( 'id' ) )
					),
				];
				break;
		}
		
		return null;
	}
	
	public function executeDelete( HTTPRequest $request ) {
		/** @var News $news */
		$news = $this->managers->getManagerOf( 'News' )->getUnique( $request->getData( 'id' ) );
		
		// If requested news doesn't exist
		if ( empty( $news ) ) {
			$this->app->httpResponse()->redirect404();
		}
		
		// If requested news is not his own
		if ( $news->fk_MEM_author() != $this->app->user()->getAttribute( 'user' )[ 'id' ] ) {
			$this->app->user()->setFlash( 'Vous n\'êtes pas autorisé à supprimer cette news' );
			$this->app->httpResponse()->redirect( self::getLinkTo( 'index' ) );
		}
		
		// We delete the news (automatically delete the comments)
		$this->managers->getManagerOf( 'News' )->delete( $news->id() );
		
		$this->app->user()->setFlash( 'La news a bien été supprimée !' );
		
		// We redirect to the same page: HomePage
		$this->app->httpResponse()->redirect( '.' );
	}
	
	public function executeDeleteComment( HTTPRequest $request ) {
		// We first get the newsId from the comment, to redirect the user after
		$newsId = $this->managers->getManagerOf( 'Comments' )->getNews( $request->getData( 'id' ) );
		$this->managers->getManagerOf( 'Comments' )->delete( $request->getData( 'id' ) );
		
		$this->app->user()->setFlash( 'Le commentaire a bien été supprimé !' );
		
		$this->app->httpResponse()->redirect( self::getLinkTo( 'index', null, [ 'id' => $newsId ] ) );
	}
	
	public function executeDeleteCommentJson( HTTPRequest $request ) {
		$comment = $this->managers->getManagerOf( 'Comments' )->getUnique( $request->getData( 'id' ) );
		
		if ( !$comment ) {
			$this->app->httpResponse()->addHeader( 'HTTP/1.0 404 Not Found ' );
			$this->page->addVar( 'errors', 'Le commentaire n\'existe déjà plus' );
		}
		else {
			$this->managers->getManagerOf( 'Comments' )->delete( $request->getData( 'id' ) );
		}
		$this->page->addVar( 'comment_id', $request->getData( 'id' ) );
	}
	
	public function executeIndex( HTTPRequest $request ) {
		$countNews        = $this->app->config()->get( 'nombre_news' );
		$nombreCaracteres = $this->app->config()->get( 'nombre_caracteres' );
		
		// On ajoute une définition pour le titre.
		$this->page->addVar( 'title', 'Liste des ' . $countNews . ' dernières news' );
		
		// On récupère le manager des news.
		$manager = $this->managers->getManagerOf( 'News' );
		
		$news_a = $manager->getList( $countNews );
		
		/** @var News $news */
		foreach ( $news_a as $news ) {
			if ( strlen( $news->content() ) > $nombreCaracteres ) {
				$content = substr( $news->content(), 0, $nombreCaracteres );
				$content = substr( $content, 0, strrpos( $content, ' ' ) ) . '...';
				
				$news->setContent( $content );
				
				// We get the data linked to the foreign key
				$news[ 'fk_MEM_author' ] = $this->managers->getManagerOf( 'User' )->getUnique( $news[ 'fk_MEM_author' ] );
				$news[ 'fk_MEM_admin' ]  = $this->managers->getManagerOf( 'User' )->getUnique( $news[ 'fk_MEM_admin' ] );
			}
		}
		
		// On ajoute la variable $news_a à la vue.
		$this->page->addVar( 'news_a', $news_a );
	}
	
	public function executeInsert( HTTPRequest $request ) {
		$this->processNewsForm( $request );
		
		$this->page->addVar( 'title', 'Ajout d\'une news' );
	}
	
	public function executeInsertComment( HTTPRequest $request ) {
		$this->page->addVar( 'title', 'Ajout d\'un commentaire' );
		
		$this->processCommentForm( $request );
	}
	
	/**
	 * Set la variable comment pour le commentaire juste inséré
	 *
	 * @param HTTPRequest $request
	 */
	public function executeInsertCommentJson( HTTPRequest $request ) {
		if ( $request->method() == 'POST' ) {
			$comment = new Comment( [
				'fk_NNC'        => $request->getData( 'news' ),
				'author'        => $request->postData( 'author' ),
				'fk_MEM_author' => $this->app->user()->getAttribute( 'user' )[ 'id' ],
				'content'       => $request->postData( 'content' ),
			] );
			
			if ( $request->getExists( 'id' ) ) {
				$comment->setId( $request->getData( 'id' ) );
			}
			
			if ( !$comment->fk_NNC() ) {
				$comment->setFk_NNC( $this->managers->getManagerOf( 'Comments' )->getNews( $comment->id() ) );
			}
		}
		
		$formBuilder = new CommentFormBuilder( $comment, $this->managers->getManagerOf( 'User' ), $this->app->user() );
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		$formHandler = new FormHandler( $form, $this->managers->getManagerOf( 'Comments' ), $request );
		
		if ( $formHandler->process() ) {
			$routes = [];
			if ( $this->app->user()->isAuthenticated() ) {
				$routes = [
					"update"      => self::getLinkTo( 'updateComment', null, [ 'id' => $comment[ 'id' ] ] ),
					"update_text" => ( $this->app->user()->isAdmin() ) ? 'Modérer' : 'Modifier',
					"delete"      => self::getLinkTo( 'deleteComment', null, [ 'id' => $comment[ 'id' ] ] ),
					"delete_json" => self::getLinkTo( 'deleteCommentJson', 'json', [ 'id' => $comment[ 'id' ] ] ),
					"delete_text" => 'Supprimer',
				];
			}
			$this->page->addVar( 'comment', $comment );
			$this->page->addVar( 'comment_author', $this->app->user()->getAttribute( 'user' )[ 'username' ] );
			$this->page->addVar( 'routes', $routes );
		}
		else {
			$this->app->httpResponse()->addHeader( 'HTTP/1.0 401 Error' );
			/** @var Field $field */
			foreach ( $form->getFields() as $field ) {
				$error_a[] = $field->errorMessage();
			}
			$this->page->addVar( 'error_a', $error_a );
		}
	}
	
	public function executeRefreshCommentJson( HTTPRequest $request ) {
		$page_comments = $request->postData( 'ids' );
		$dateupdate    = new \DateTime();
		$dateupdate->setTimestamp( $request->postData( 'date' ) );
		$newsid = $request->getData( 'id' );
		
		//		var_dump($page_comments, $dateupdate, $newsid);die;
		$comment_new_a        = $this->managers->getManagerOf( 'Comments' )->getListOfFilterByAfterDate( $newsid, $dateupdate );
		$route_a              = array();
		$comment_new_author_a = array();
		foreach ( $comment_new_a as $comment_new ) {
			if ( $comment_new[ 'fk_MEM_author' ] ) {
				$comment_new_author_a[ $comment_new[ 'id' ] ] = $this->managers->getManagerOf( 'User' )->getUnique( $comment_new[ 'fk_MEM_author' ] );
			}
			if ( $this->app->user()->isAuthenticated() ) {
				if ( $this->app->user()->isAdmin()
					 || $this->app->user()->getAttribute( 'user' )[ 'id' ] == $comment_new[ 'fk_MEM_author' ]
				) {
					$route_a[ $comment_new[ 'id' ] ] = array(
						"update"      => self::getLinkTo( 'updateComment', null, [ 'id' => $comment_new[ 'id' ] ] ),
						"update_text" => ( $this->app->user()->isAdmin()
										   && ( $comment_new_author_a[ $comment_new[ 'id' ] ] ) ? $comment_new_author_a[ $comment_new[ 'id' ] ][ 'username' ]
							: null != $this->app->user()->getAttribute( 'user' )[ 'username' ] ) ? 'Modérer' : 'Modifier',
						"delete"      => self::getLinkTo( 'deleteComment', false, [ 'id' => $comment_new[ 'id' ] ] ),
						"delete_json" => self::getLinkTo( 'deleteCommentJson', 'json', [ 'id' => $comment_new[ 'id' ] ] ),
						"delete_text" => 'Supprimer',
					);
				}
			}
		}
		$comment_delete_a = $this->managers->getManagerOf( 'Comments' )->getListOfFilterByDeletedAfterDate( $newsid, $page_comments, $dateupdate );
		$comment_update_a = $this->managers->getManagerOf( 'Comments' )->getListOfFilterByUpdatedAfterDate( $newsid, $page_comments, $dateupdate );
		
		$errors = '';
		
		$this->page->addVar( 'comment_new_a', $comment_new_a );
		$this->page->addVar( 'comment_new_author_a', $comment_new_author_a );
		$this->page->addVar( 'comment_delete_a', $comment_delete_a );
		$this->page->addVar( 'comment_update_a', $comment_update_a );
		$this->page->addVar( 'route_a', $route_a );
		$this->page->addVar( 'errors', $errors );
	}
	
	public function executeShow( HTTPRequest $request ) {
		/** @var News $news */
		$news = $this->managers->getManagerOf( 'News' )->getUnique( $request->getData( 'id' ) );
		
		if ( empty( $news ) ) {
			$this->app->user()->setFlash( 'La news n\'existe pas' );
			$this->app->httpResponse()->redirect( self::getLinkTo( 'index' ) );
		}
		
		// We get the data linked to the foreign key
		$news[ 'fk_MEM_author' ] = $this->managers->getManagerOf( 'User' )->getUnique( $news[ 'fk_MEM_author' ] );
		$news[ 'fk_MEM_admin' ]  = $this->managers->getManagerOf( 'User' )->getUnique( $news[ 'fk_MEM_admin' ] );
		
		$comment_a = $this->managers->getManagerOf( 'Comments' )->getListOf( $news->id() );
		
		// We get the data linked to the foreign key
		foreach ( $comment_a as $comment ) {
			$comment[ 'fk_MEM_author' ] = $this->managers->getManagerOf( 'User' )->getUnique( $comment[ 'fk_MEM_author' ] );
			$comment[ 'fk_MEM_admin' ]  = $this->managers->getManagerOf( 'User' )->getUnique( $comment[ 'fk_MEM_admin' ] );
		}
		
		$formBuilder = new CommentFormBuilder( new Comment, $this->managers->getManagerOf( 'User' ), $this->app->user() );
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		$this->page->addVar( 'form', $form->createView() );
		$this->page->addVar( 'title', $news->title() );
		$this->page->addVar( 'news', $news );
		$this->page->addVar( 'comment_a', $comment_a );
	}
	
	public function executeUpdate( HTTPRequest $request ) {
		/** @var News $news */
		$news = $this->managers->getManagerOf( 'News' )->getUnique( $request->getData( 'id' ) );
		
		// If requested news doesn't exist
		if ( empty( $news ) ) {
			$this->app->httpResponse()->redirect404();
		}
		
		// If requested news is not his own
		if ( $news->fk_MEM_author() != $this->app->user()->getAttribute( 'user' )[ 'id' ] ) {
			$this->app->user()->setFlash( 'Vous n\'êtes pas autorisé à modifier cette news' );
			$this->app->httpResponse()->redirect( self::getLinkTo( 'index' ) );
		}
		
		$this->processNewsForm( $request );
		$this->page->addVar( 'title', 'Modification d\'une news' );
	}
	
	public function executeUpdateComment( HTTPRequest $request ) {
		$this->processCommentForm( $request );
		
		$this->page->addVar( 'title', 'Modification d\'un commentaire' );
	}
	
	public function processNewsForm( HTTPRequest $request ) {
		$isNew = true;
		if ( $request->method() == 'POST' ) {
			$news = new News( [
				// a news is created by an user, so we get the value from $_SESSION
				'fk_MEM_author' => $this->app->user()->getAttribute( 'user' )[ 'id' ],
				'title'         => $request->postData( 'title' ),
				'content'       => $request->postData( 'content' ),
			] );
			
			if ( $request->getExists( 'id' ) ) {
				$isNew = false;
				$news->setId( $request->getData( 'id' ) );
			}
		}
		else {
			// L'identifiant de la news est transmis si on veut la modifier
			if ( $request->getExists( 'id' ) ) {
				$isNew = false;
				$news  = $this->managers->getManagerOf( 'News' )->getUnique( $request->getData( 'id' ) );
			}
			else {
				$news = new News;
			}
		}
		
		$formBuilder = new NewsFormBuilder( $news, $this->managers->getManagerOf( 'News' ), $this->app->user() );
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		$formHandler = new FormHandler( $form, $this->managers->getManagerOf( 'News' ), $request );
		
		if ( $formHandler->process() ) {
			$this->app->user()->setFlash( $isNew ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !' );
			$this->app->httpResponse()->redirect( self::getLinkTo( 'index' ) );
		}
		
		$this->page->addVar( 'form', $form->createView() );
	}
	
	public function processCommentForm( HTTPRequest $request ) {
		$isNew = true;
		if ( $request->method() == 'POST' ) {
			$comment = new Comment( [
				'fk_NNC'        => $request->getData( 'news' ),
				'author'        => $request->postData( 'author' ),
				'fk_MEM_author' => ( $this->app->user()->isAdmin() ) ? null : $this->app->user()->getAttribute( 'user' )[ 'id' ],
				'fk_MEM_admin'  => ( $this->app->user()->isAdmin() ) ? $this->app->user()->getAttribute( 'user' )[ 'id' ] : null,
				'content'       => $request->postData( 'content' ),
			] );
			
			if ( $request->getExists( 'id' ) ) {
				$isNew = false;
				$comment->setId( $request->getData( 'id' ) );
			}
			
			if ( !$comment->fk_NNC() ) {
				$comment->setFk_NNC( $this->managers->getManagerOf( 'Comments' )->getNews( $comment->id() ) );
			}
		}
		else {
			if ( $request->getExists( 'id' ) ) {
				$isNew   = false;
				$comment = $this->managers->getManagerOf( 'Comments' )->getUnique( $request->getData( 'id' ) );
			}
			else {
				$comment = new Comment;
			}
		}
		
		
		$formBuilder = new CommentFormBuilder( $comment, $this->managers->getManagerOf( 'User' ), $this->app->user() );
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		$formHandler = new FormHandler( $form, $this->managers->getManagerOf( 'Comments' ), $request );
		
		if ( $formHandler->process() ) {
			$this->app->user()->setFlash( $isNew ? 'Le commentaire a bien été ajouté' : 'Le commentaire a bien été modifié' );
			$this->app->httpResponse()->redirect( self::getLinkTo( 'show', null, [ 'id' => $comment->fk_NNC() ] ) );
		}
		
		$this->page->addVar( 'form', $form->createView() );
	}
	
	static public function getLinkTo( $action, $format = 'html', array $args = [] ) {
		//		return RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', 'index' );
		return RouterFactory::getRouter( 'Frontend' )->getUrl( 'News', $action, is_null( $format ) ? 'html' : $format, $args );
	}
}