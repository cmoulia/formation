<?php

namespace Model;

use \Entity\Comment;

class CommentsManagerPDO extends CommentsManager {
	/** @var \PDO $dao */
	protected $dao;
	
	public function getListOf( $newsId ) {
		if ( !is_int( $newsId ) ) {
			throw new \InvalidArgumentException( 'L\'identifiant de la news passé doit être un nombre entier valide' );
		}
		
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'SELECT NCC_id, NCC_fk_NNC, NCC_author, NCC_fk_MEM_author, NCC_fk_MEM_admin, NCC_content, NCC_dateadd, NCC_dateupdate
								   FROM T_NEW_commentc
								   WHERE NCC_fk_NNC = :news ' );
		$q->bindValue( ':news', $newsId, \PDO::PARAM_INT );
		$q->execute();
		$q->setFetchMode( \PDO::FETCH_ASSOC );
		
		$comment_a = $q->fetchAll();
		
		/** @var Comment $comment */
		foreach ( $comment_a as $key => $comment ) {
			$comment[ 'NCC_dateadd' ]    = new \DateTime( $comment[ 'NCC_dateadd' ] );
			$comment[ 'NCC_dateupdate' ] = new \DateTime( $comment[ 'NCC_dateupdate' ] );
			$comment_a[ $key ]           = new Comment( $comment );
		}
		
		return $comment_a;
	}
	
	public function getListOfFilterByAfterDate( $newsId, $dateupdate ) {
		$q = $this->dao->prepare( 'SELECT NCC_id, NCC_fk_NNC, NCC_author, NCC_fk_MEM_author, NCC_fk_MEM_admin, NCC_content, NCC_dateadd, NCC_dateupdate
 								  FROM T_NEW_commentc
 								  WHERE NCC_fk_NNC = :news AND NCC_dateadd >= :date' );
		$q->bindValue( ':news', $newsId, \PDO::PARAM_INT );
		$q->bindValue( ':date', $dateupdate->format( 'Y-m-d H:i:s' ) );
		$q->execute();
		$q->setFetchMode( \PDO::FETCH_ASSOC );
		
		$comment_a = $q->fetchAll();
		
		/** @var Comment $comment */
		foreach ( $comment_a as $key => $comment ) {
			$comment[ 'NCC_dateadd' ]    = new \DateTime( $comment[ 'NCC_dateadd' ] );
			$comment[ 'NCC_dateupdate' ] = new \DateTime( $comment[ 'NCC_dateupdate' ] );
			$comment_a[ $key ]           = new Comment( $comment );
		}
		
		return $comment_a;
	}
	
	public function getListOfFilterByDeletedAfterDate( $newsId, $comment_id_a, $dateupdate ) {
		$inQuery = implode( ',', $comment_id_a );
		$q = $this->dao->prepare( 'SELECT NCC_id
 								   FROM T_NEW_commentc
 								   WHERE NCC_fk_NNC = :news AND NCC_id IN (' . $inQuery . ')' );
		$q->bindValue( ':news', $newsId, \PDO::PARAM_INT );
		$q->execute();
		$q->setFetchMode( \PDO::FETCH_NUM );

		if ( !empty( $comment_a = $q->fetchAll() ) ) {
			$merged    = array_merge( ...$comment_a );
			$comment_a = array_diff( $comment_id_a, $merged );
			/** @var Comment $comment */
			foreach ( $comment_a as $key => $comment ) {
				$comment_a[ $comment ] = $comment;
				unset($comment_a[$key]);
			}
//			var_dump($inQuery, $comment_id_a, $merged, $comment_a);die;
		}
		
		return $comment_a;
	}
	
	public function getListOfFilterByUpdatedAfterDate( $newsId, $comment_id_a, $dateupdate ) {
		$inQuery = implode( ',', $comment_id_a );
		$q       = $this->dao->prepare( 'SELECT NCC_id, NCC_content, NCC_dateupdate
 								  FROM T_NEW_commentc
 								  WHERE NCC_fk_NNC = :news AND NCC_dateupdate >= :date AND NCC_id IN (' . $inQuery . ')' );
		$q->bindValue( ':news', $newsId, \PDO::PARAM_INT );
		$q->bindValue( ':date', $dateupdate->format( 'Y-m-d H:i:s' ) );
		$q->execute();
		$q->setFetchMode( \PDO::FETCH_ASSOC );
		
		$comment_a = $q->fetchAll();
		/** @var Comment $comment */
		foreach ( $comment_a as $key => $comment ) {
			$comment[ 'NCC_dateupdate' ] = new \DateTime( $comment[ 'NCC_dateupdate' ] );
			$comment_a[ $key ] = new Comment( $comment );
		}
		
		return $comment_a;
	}
	
	public function getUnique( $id ) {
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'SELECT NCC_id, NCC_fk_NNC, NCC_author, NCC_fk_MEM_author, NCC_fk_MEM_admin, NCC_content
								   FROM T_NEW_commentc
								   WHERE NCC_id = :id' );
		$q->bindValue( ':id', (int)$id, \PDO::PARAM_INT );
		$q->execute();
		$q->setFetchMode( \PDO::FETCH_ASSOC );
		
		if ( $result = $q->fetch() ) {
			return new Comment( $result );
		}
		
		return false;
	}
	
	public function getNews( $id ) {
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'SELECT NCC_fk_NNC
								   FROM T_NEW_commentc
								   WHERE NCC_id = :id' );
		$q->bindValue( ':id', (int)$id, \PDO::PARAM_INT );
		$q->execute();
		
		return $q->fetchColumn();
	}
	
	public function delete( $id ) {
		$this->dao->exec( 'DELETE FROM T_NEW_commentc
						   WHERE NCC_id = ' . (int)$id );
		
		return true;
	}
	
	public function deleteFromNews( $newsId ) {
		$this->dao->exec( 'DELETE FROM T_NEW_commentc
						   WHERE NCC_fk_NNC = ' . (int)$newsId );
	}
	
	protected function add( Comment $comment ) {
		$dateutcnow = new \DateTime();
		/** @var \PDOStatement $q */
		if ( $comment->author() ) {
			$q = $this->dao->prepare( 'INSERT INTO T_NEW_commentc
									   SET NCC_fk_NNC = :fk_NNC, NCC_author = :author, NCC_content = :content, NCC_dateadd = :datetime, NCC_dateupdate = :datetime' );
			$q->bindValue( ':author', $comment->author() );
			$q->bindValue( ':datetime', $dateutcnow->format( 'Y-m-d H:i:s' ) );
		}
		if ( $comment->fk_MEM_author() ) {
			$q = $this->dao->prepare( 'INSERT INTO T_NEW_commentc
									   SET NCC_fk_NNC = :fk_NNC, NCC_fk_MEM_author = :author, NCC_content = :content, NCC_dateadd = :datetime' );
			$q->bindValue( ':author', $comment->fk_MEM_author() );
			$q->bindValue( ':datetime', $dateutcnow->format( 'Y-m-d H:i:s' ) );
		}
		
		$q->bindValue( ':fk_NNC', $comment->fk_NNC(), \PDO::PARAM_INT );
		$q->bindValue( ':content', $comment->content() );
		
		$q->execute();
		
		$comment->setDateadd( $dateutcnow );
		$comment->setId( $this->dao->lastInsertId() );
	}
	
	protected function modify( Comment $comment ) {
		$dateutcnow = new \DateTime();
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'UPDATE T_NEW_commentc
								   SET NCC_author = :author, NCC_content = :content, NCC_dateupdate = :datetime
								   WHERE NCC_id = :id' );
		
		$q->bindValue( ':author', $comment->author() );
		$q->bindValue( ':datetime', $dateutcnow->format( 'Y-m-d H:i:s' ) );
		$q->bindValue( ':content', $comment->content() );
		$q->bindValue( ':id', $comment->id(), \PDO::PARAM_INT );
		
		$q->execute();
	}
}