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
		$newsId = $request->getData( 'id' );
		
		$this->managers->getManagerOf( 'Comments' )->deleteFromNews( $newsId );
		$this->managers->getManagerOf( 'News' )->delete( $newsId );
		
		$this->app->user()->setFlash( 'La news a bien été supprimée !' );
		
		$this->app->httpResponse()->redirect( '.' );
	}
	
	public function executeDeleteComment( HTTPRequest $request ) {
		$newsId = $this->managers->getManagerOf( 'Comments' )->getNews( $request->getData( 'id' ) );
		$this->managers->getManagerOf( 'Comments' )->delete( $request->getData( 'id' ) );
		
		$this->app->user()->setFlash( 'Le commentaire a bien été supprimé !' );
		
		$this->app->httpResponse()->redirect( '/news-' . $newsId );
	}
	
	public function executeIndex( HTTPRequest $request ) {
		$nombreNews       = $this->app->config()->get( 'nombre_news' );
		$nombreCaracteres = $this->app->config()->get( 'nombre_caracteres' );
		
		// On ajoute une définition pour le titre.
		$this->page->addVar( 'title', 'Liste des ' . $nombreNews . ' dernières news' );
		
		// On récupère le manager des news.
		$manager = $this->managers->getManagerOf( 'News' );
		
		$news_a = $manager->getList( 0, $nombreNews );
		
		/** @var News $news */
		foreach ( $news_a as $news ) {
			if ( strlen( $news->content() ) > $nombreCaracteres ) {
				$debut = substr( $news->content(), 0, $nombreCaracteres );
				$debut = substr( $debut, 0, strrpos( $debut, ' ' ) ) . '...';
				
				$news->setContent( $debut );
			}
		}
		
		// On ajoute la variable $listeNews à la vue.
		$this->page->addVar( 'listeNews', $news_a );
	}
	
	public function executeInsert( HTTPRequest $request ) {
		$this->processForm( $request );
		
		$this->page->addVar( 'title', 'Ajout d\'une news' );
	}
	
	public function executeInsertComment( HTTPRequest $request ) {
		// Si le formulaire a été envoyé.
		if ( $request->method() == 'POST' ) {
			$comment = new Comment( [
				'fk_NNC'  => $request->getData( 'news' ),
				'author'  => ( $this->app->user()->getAttribute( 'username' ) ) ? $this->app->user()->getAttribute( 'username' ) : $request->postData( 'author' ),
				'content' => $request->postData( 'content' ),
			] );
		}
		else {
			$comment = new Comment;
		}
		
		$formBuilder = new CommentFormBuilder( $comment, $this->managers->getManagerOf( 'User' ), $this->app->user()->isAuthenticated() );
		$formBuilder->build();
		
		/** @var Form $form */
		$form = $formBuilder->form();
		
		$formHandler = new FormHandler( $form, $this->managers->getManagerOf( 'Comments' ), $request );
		
		if ( $formHandler->process() ) {
			$this->app->user()->setFlash( 'Le commentaire a bien été ajouté, merci !' );
			$this->app->httpResponse()->redirect( 'news-' . $request->getData( 'news' ) );
		}
		
		$this->page->addVar( 'comment', $comment );
		$this->page->addVar( 'form', $form->createView() );
		$this->page->addVar( 'title', 'Ajout d\'un commentaire' );
	}
	
	public function executeShow( HTTPRequest $request ) {
		/** @var News $news */
		$news = $this->managers->getManagerOf( 'News' )->getUnique( $request->getData( 'id' ) );
		
		if ( empty( $news ) ) {
			$this->app->httpResponse()->redirect404();
		}
		
		$this->page->addVar( 'title', $news->title() );
		$this->page->addVar( 'news', $news );
		$this->page->addVar( 'comments', $this->managers->getManagerOf( 'Comments' )->getListOf( $news->id() ) );
	}
	
	public function executeUpdate( HTTPRequest $request ) {
		$this->processForm( $request );
		
		$this->page->addVar( 'title', 'Modification d\'une news' );
	}
	
	public function executeUpdateComment( HTTPRequest $request ) {
		$this->page->addVar( 'title', 'Modification d\'un commentaire' );
		
		if ( $request->method() == 'POST' ) {
			$comment = new Comment( [
				'id'      => $request->getData( 'id' ),
				'author'  => $request->postData( 'author' ),
				'content' => $request->postData( 'content' ),
			] );
			$comment->setFk_NNC( $this->managers->getManagerOf( 'Comments' )->getNews( $comment->id() ) );
		}
		else {
			$comment = $this->managers->getManagerOf( 'Comments' )->get( $request->getData( 'id' ) );
		}
		
		
		$formBuilder = new CommentFormBuilder( $comment, $this->managers->getManagerOf( 'User' ), $this->app->user()->isAuthenticated() );
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		$formHandler = new FormHandler( $form, $this->managers->getManagerOf( 'Comments' ), $request );
		
		if ( $formHandler->process() ) {
			$this->app->user()->setFlash( 'Le commentaire a bien été modifié' );
			$this->app->httpResponse()->redirect( '/news-' . $comment->fk_NNC() );
		}
		
		$this->page->addVar( 'form', $form->createView() );
	}
	
	public function processForm( HTTPRequest $request ) {
		if ( $request->method() == 'POST' ) {
			$news = new News( [
				'author'  => $this->app->user()->getAttribute( 'username' ),
				'title'   => $request->postData( 'title' ),
				'content' => $request->postData( 'content' ),
			] );
			
			if ( $request->getExists( 'id' ) ) {
				$news->setId( $request->getData( 'id' ) );
			}
		}
		else {
			// L'identifiant de la news est transmis si on veut la modifier
			if ( $request->getExists( 'id' ) ) {
				$news = $this->managers->getManagerOf( 'News' )->getUnique( $request->getData( 'id' ) );
			}
			else {
				$news = new News;
			}
		}
		
		$formBuilder = new NewsFormBuilder( $news, $this->managers->getManagerOf( 'News' ), $this->app->user()->isAuthenticated() );
		$formBuilder->build();
		
		
		$form = $formBuilder->form();
		
		$formHandler = new FormHandler( $form, $this->managers->getManagerOf( 'News' ), $request );
		
		if ( $formHandler->process() ) {
			$this->app->user()->setFlash( $news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !' );
			$this->app->httpResponse()->redirect( '/' );
		}
		
		
		$this->page->addVar( 'form', $form->createView() );
	}
}