<?php

namespace Model;

use \Entity\Comment;

class CommentsManagerPDO extends CommentsManager {
	public function getListOf( $newsId ) {
		if ( !ctype_digit( $newsId ) ) {
			throw new \InvalidArgumentException( 'L\'identifiant de la news passé doit être un nombre entier valide' );
		}
		
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'SELECT id, fk_NNC, author, content, dateadd FROM T_NEW_commentc WHERE fk_NNC = :news' );
		$q->bindValue( ':news', $newsId, \PDO::PARAM_INT );
		$q->execute();
		
		$q->setFetchMode( \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment' );
		
		$comments = $q->fetchAll();
		
		/** @var Comment $comment */
		foreach ( $comments as $comment ) {
			$comment->setDateadd( new \DateTime( $comment->dateadd() ) );
		}
		
		return $comments;
	}
	
	public function get( $id ) {
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'SELECT id, fk_NNC, author, content FROM T_NEW_commentc WHERE id = :id' );
		$q->bindValue( ':id', (int)$id, \PDO::PARAM_INT );
		$q->execute();
		
		$q->setFetchMode( \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment' );
		
		return $q->fetch();
	}
	
	public function getNews( $id ) {
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'SELECT fk_NNC FROM T_NEW_commentc WHERE id = :id' );
		$q->bindValue( ':id', (int)$id, \PDO::PARAM_INT );
		$q->execute();
		
		return $q->fetchColumn();
	}
	
	public function delete( $id ) {
		$this->dao->exec( 'DELETE FROM T_NEW_commentc WHERE id = ' . (int)$id );
	}
	
	public function deleteFromNews( $newsId ) {
		$this->dao->exec( 'DELETE FROM T_NEW_commentc WHERE fk_NNC = ' . (int)$newsId );
	}
	
	protected function add( Comment $comment ) {
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'INSERT INTO T_NEW_commentc SET fk_NNC = :news, author = :author, content = :content, dateadd = NOW()' );
		
		$q->bindValue( ':news', $comment->fk_NNC(), \PDO::PARAM_INT );
		$q->bindValue( ':author', $comment->author() );
		$q->bindValue( ':content', $comment->content() );
		
		$q->execute();
		
		$comment->setId( $this->dao->lastInsertId() );
	}
	
	protected function modify( Comment $comment ) {
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'UPDATE T_NEW_commentc SET author = :author, content = :content WHERE id = :id' );
		
		$q->bindValue( ':author', $comment->author() );
		$q->bindValue( ':content', $comment->content() );
		$q->bindValue( ':id', $comment->id(), \PDO::PARAM_INT );
		
		$q->execute();
	}
}