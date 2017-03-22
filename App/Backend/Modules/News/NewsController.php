<?php

namespace App\Backend\Modules\News;

use Entity\Comment;
use FormBuilder\CommentFormBuilder;
use \OCFram\BackController;
use OCFram\FormHandler;
use \OCFram\HTTPRequest;

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
		$this->page->addVar( 'title', 'Gestion des news' );
		$this->page->addVar( 'username', $this->app->user()->getAttribute('username') );
		
		/** @var \Model\NewsManager $manager */
		$manager = $this->managers->getManagerOf( 'News' );
		
		$this->page->addVar( 'listeNews', $manager->getList() );
		$this->page->addVar( 'nombreNews', $manager->count() );
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
		
		
		$formBuilder = new CommentFormBuilder( $comment, $this->managers->getManagerOf('Comments'), $this->app->user()->isAuthenticated() );
		$formBuilder->build();
		
		$form = $formBuilder->form();
		
		$formHandler = new FormHandler( $form, $this->managers->getManagerOf( 'Comments' ), $request );
		
		if ( $formHandler->process() ) {
			$this->app->user()->setFlash( 'Le commentaire a bien été modifié' );
			$this->app->httpResponse()->redirect( '/news-' . $comment->fk_NNC() );
		}
		
		$this->page->addVar( 'form', $form->createView() );
	}

}