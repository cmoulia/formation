<?php

namespace App\Frontend\Modules\News;

use \Entity\News;
use FormBuilder\NewsFormBuilder;
use \OCFram\BackController;
use \OCFram\Form;
use \OCFram\HTTPRequest;
use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \OCFram\FormHandler;

class NewsController extends BackController {
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
			$this->app->httpResponse()->redirect( '/' );
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
		
		$this->app->httpResponse()->redirect( '/news-' . $newsId );
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
	
	public function executeShow( HTTPRequest $request ) {
		/** @var News $news */
		$news = $this->managers->getManagerOf( 'News' )->getUnique( $request->getData( 'id' ) );
		
		if ( empty( $news ) ) {
			$this->app->user()->setFlash('La news n\'existe pas');
			$this->app->httpResponse()->redirect('/');
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
			$this->app->httpResponse()->redirect( '/' );
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
			$this->app->httpResponse()->redirect( '/' );
		}
		
		$this->page->addVar( 'form', $form->createView() );
	}
	
	public function processCommentForm( HTTPRequest $request ) {
		$isNew = true;
		if ( $request->method() == 'POST' ) {
			$comment = new Comment( [
				'fk_NNC'        => $request->getData( 'news' ),
				'author'        => $request->postData( 'author' ),
				'fk_MEM_author' => $this->app->user()->getAttribute( 'user' )[ 'id' ],
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
			$this->app->httpResponse()->redirect( '/news-' . $comment->fk_NNC() );
		}
		
		$this->page->addVar( 'form', $form->createView() );
	}
}