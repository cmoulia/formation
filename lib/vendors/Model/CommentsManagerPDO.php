<?php

namespace Model;

use \Entity\Comment;

class CommentsManagerPDO extends CommentsManager {
	public function getListOf( $newsId ) {
		if ( !is_int( $newsId ) ) {
			throw new \InvalidArgumentException( 'L\'identifiant de la news passé doit être un nombre entier valide' );
		}
		
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'SELECT NCC_id, NCC_fk_NNC, NCC_author, NCC_fk_MEM_author, NCC_fk_MEM_admin, NCC_content, NCC_dateadd FROM T_NEW_commentc WHERE NCC_fk_NNC = :news ' );
		$q->bindValue( ':news', $newsId, \PDO::PARAM_INT );
		$q->execute();
		$q->setFetchMode( \PDO::FETCH_ASSOC );
		
		$comment_a = $q->fetchAll();
		
		/** @var Comment $comment */
		foreach ( $comment_a as $key => $comment ) {
			$comment[ 'NCC_dateadd' ] = new \DateTime( $comment[ 'NCC_dateadd' ] );
			$comment_a[ $key ]        = new Comment( $comment );
		}
		
		return $comment_a;
	}
	
	public function getUnique( $id ) {
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'SELECT NCC_id, NCC_fk_NNC, NCC_author, NCC_fk_MEM_author, NCC_fk_MEM_admin, NCC_content FROM T_NEW_commentc WHERE NCC_id = :id' );
		$q->bindValue( ':id', (int)$id, \PDO::PARAM_INT );
		$q->execute();
		$q->setFetchMode( \PDO::FETCH_ASSOC );
		
		
		return new Comment( $q->fetch() );
	}
	
	public function getNews( $id ) {
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'SELECT NCC_fk_NNC FROM T_NEW_commentc WHERE NCC_id = :id' );
		$q->bindValue( ':id', (int)$id, \PDO::PARAM_INT );
		$q->execute();
		
		return $q->fetchColumn();
	}
	
	public function delete( $id ) {
		$this->dao->exec( 'DELETE FROM T_NEW_commentc WHERE NCC_id = ' . (int)$id );
	}
	
	public function deleteFromNews( $newsId ) {
		$this->dao->exec( 'DELETE FROM T_NEW_commentc WHERE NCC_fk_NNC = ' . (int)$newsId );
	}
	
	protected function add( Comment $comment ) {
		/** @var \PDOStatement $q */
		if ( $comment->author() ) {
			$q = $this->dao->prepare( 'INSERT INTO T_NEW_commentc SET NCC_fk_NNC = :fk_NNC, NCC_author = :author, NCC_content = :content, NCC_dateadd = NOW()' );
			$q->bindValue( ':author', $comment->author() );
		}
		if ( $comment->fk_MEM_author() ) {
			$q = $this->dao->prepare( 'INSERT INTO T_NEW_commentc SET NCC_fk_NNC = :fk_NNC, NCC_fk_MEM_author = :author, NCC_content = :content, NCC_dateadd = NOW()' );
			$q->bindValue( ':author', $comment->fk_MEM_author() );
		}
		
		$q->bindValue( ':fk_NNC', $comment->fk_NNC(), \PDO::PARAM_INT );
		$q->bindValue( ':content', $comment->content() );
		
		$q->execute();
		
		$comment->setId( $this->dao->lastInsertId() );
	}
	
	protected function modify( Comment $comment ) {
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'UPDATE T_NEW_commentc SET NCC_author = :author, NCC_content = :content WHERE NCC_id = :id' );
		
		$q->bindValue( ':author', $comment->author() );
		$q->bindValue( ':content', $comment->content() );
		$q->bindValue( ':id', $comment->id(), \PDO::PARAM_INT );
		
		$q->execute();
	}
}