<?php

namespace App\Backend\Modules\News;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Comment;
use \Entity\News;
use \FormBuilder\CommentFormBuilder;
use \FormBuilder\NewsFormBuilder;
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
		
		$this->app->httpResponse()->redirect( '/news-' . $newsId . '.html' );
	}
	
	public function executeIndex( HTTPRequest $request ) {
		$this->page->addVar( 'title', 'Gestion des news' );
		
		/** @var \Model\NewsManager $manager */
		$manager = $this->managers->getManagerOf( 'News' );
		
		$this->page->addVar( 'listeNews', $manager->getList() );
		$this->page->addVar( 'nombreNews', $manager->count() );
	}
	
	public function executeInsert( HTTPRequest $request ) {
		$this->processForm( $request );
		
		$this->page->addVar( 'title', 'Ajout d\'une news' );
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
		
		
		$formBuilder = new CommentFormBuilder( $comment );
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		$formHandler = new FormHandler( $form, $this->managers->getManagerOf( 'Comments' ), $request );
		
		if ( $formHandler->process() ) {
			$this->app->user()->setFlash( 'Le commentaire a bien été modifié' );
			$this->app->httpResponse()->redirect( '/news-' . $comment->fk_NNC() . '.html' );
		}
		
		$this->page->addVar( 'form', $form->createView() );
	}
	
	public function processForm( HTTPRequest $request ) {
		if ( $request->method() == 'POST' ) {
			$news = new News( [
				'author'  => $request->postData( 'author' ),
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
		
		$formBuilder = new NewsFormBuilder( $news );
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