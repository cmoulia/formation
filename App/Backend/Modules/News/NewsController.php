<?php

namespace App\Backend\Modules\News;

use Entity\Comment;
use Entity\News;
use FormBuilder\CommentFormBuilder;
use FormBuilder\NewsFormBuilder;
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
		
		/** @var \Model\NewsManager $manager */
		$manager = $this->managers->getManagerOf( 'News' );
		$news_a = $manager->getList();
		
		foreach ( $news_a as $news ) {
			$news['fk_MEM_author'] = $this->managers->getManagerOf('User')->getUnique($news['fk_MEM_author']);
			$news['fk_MEM_admin'] = $this->managers->getManagerOf('User')->getUnique($news['fk_MEM_admin']);
		}
		
		$this->page->addVar( 'news_a', $news_a );
		$this->page->addVar( 'nombreNews', $manager->count() );
	}
	
	public function executeUpdate( HTTPRequest $request ) {
		$this->page->addVar( 'title', 'Modification d\'une news' );
		
		if ( $request->method() == 'POST' ) {
			$news = new News( [
				'fk_MEM_admin'   => $this->app->user()->getAttribute( 'user' )['id'],
				'title'   => $request->postData( 'title' ),
				'content' => $request->postData( 'content' ),
			] );
			
			if ( $request->getExists( 'id' ) ) {
				$news->setId( $request->getData( 'id' ) );
				$news->setFk_MEM_author($this->managers->getManagerOf('News')->getUnique($news->id())->fk_MEM_author());
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
			$this->app->user()->setFlash( $news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modérée !' );
			$this->app->httpResponse()->redirect( '/' );
		}
		
		
		$this->page->addVar( 'form', $form->createView() );
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
		
		
		$formBuilder = new CommentFormBuilder( $comment, $this->managers->getManagerOf( 'Comments' ), $this->app->user()->isAuthenticated() );
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