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
			$comment[ 'NCC_dateadd' ] = new \DateTime( $comment[ 'NCC_dateadd' ] );
			if ( $comment[ 'NCC_dateupdate' ] ) {
				$comment[ 'NCC_dateupdate' ] = new \DateTime( $comment[ 'NCC_dateupdate' ] );
			}
			else {
				unset( $comment[ 'NCC_dateupdate' ] );
			}
			$comment_a[ $key ] = new Comment( $comment );
		}
		
		return $comment_a;
	}
	
	public function getListOfFilterByAfterDate( $newsId, \DateTime $dateupdate ) {
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
	
	/**
	 * Function that return comments that were deleted
	 * Can be done with a temp table and a left join (no need for array manipulation)
	 *
	 * @param           $newsId
	 * @param array     $comment_id_a
	 * @param \DateTime $dateupdate
	 *
	 * @return array
	 */
	public function getListOfFilterByDeletedAfterDate( $newsId, array $comment_id_a, \DateTime $dateupdate ) {
		$vars = "";
		foreach ( $comment_id_a as $key => $comment_id ) {
			$vars .= ':var' . $key . ', ';
			$parameters[ 'var' . $key ] = $comment_id;
		}
		$vars = rtrim( $vars, ", " );
		$sql = "SELECT NCC_id, NCC_content, NCC_dateupdate
 				FROM T_NEW_commentc
 				WHERE NCC_fk_NNC = :news AND NCC_id IN ($vars)";
		$parameters['news'] = $newsId;
		$q = $this->dao->prepare( $sql );
		$q->execute( $parameters );
		$q->setFetchMode( \PDO::FETCH_NUM );
		
		if ( !empty( $comment_a = $q->fetchAll() ) ) {
			$merged    = array_merge( ...$comment_a );
			$comment_a = array_diff( $comment_id_a, $merged );
		}
		
		return array_values( $comment_a );
	}
	
	
	public function getListOfFilterByUpdatedAfterDate( $newsId, array $comment_id_a, \DateTime $dateupdate ) {
		$vars = "";
		foreach ( $comment_id_a as $key => $comment_id ) {
			$vars .= ':var' . $key . ', ';
			$parameters[ 'var' . $key ] = $comment_id;
		}
		$vars = rtrim( $vars, ", " );
		$sql = "SELECT NCC_id, NCC_content, NCC_dateupdate
 				FROM T_NEW_commentc
 				WHERE NCC_fk_NNC = :news AND NCC_dateupdate > :date AND NCC_id IN ($vars)";
		$parameters['news'] = $newsId;
		$parameters['date'] = $dateupdate->format( 'Y-m-d H:i:s' );
		$q = $this->dao->prepare( $sql );
		$q->execute( $parameters );
		$q->setFetchMode( \PDO::FETCH_ASSOC );
		
		$comment_a = $q->fetchAll();
		/** @var Comment $comment */
		foreach ( $comment_a as $key => $comment ) {
			$comment[ 'NCC_dateupdate' ] = new \DateTime( $comment[ 'NCC_dateupdate' ] );
			$comment_a[ $key ]           = new Comment( $comment );
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
		$sql        = 'INSERT INTO T_NEW_commentc
					   SET NCC_fk_NNC = :fk_NNC, NCC_content = :content, NCC_dateadd = :datetime';
		if ( $comment->author() ) {
			$sql .= ', NCC_author = :author';
		}
		if ( $comment->fk_MEM_author() ) {
			$sql .= ', NCC_fk_MEM_author = :author';
		}
		
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( $sql );
		$q->bindValue( ':fk_NNC', $comment->fk_NNC(), \PDO::PARAM_INT );
		$q->bindValue( ':content', $comment->content() );
		$q->bindValue( ':datetime', $dateutcnow->format( 'Y-m-d H:i:s' ) );
		if ( $comment->author() ) {
			$q->bindValue( ':author', $comment->author() );
		}
		if ( $comment->fk_MEM_author() ) {
			$q->bindValue( ':author', $comment->fk_MEM_author() );
		}
		
		$q->execute();
		
		$comment->setDateadd( $dateutcnow );
		$comment->setId( $this->dao->lastInsertId() );
	}
	
	protected function modify( Comment $comment ) {
		$dateutcnow = new \DateTime();
		$sql        = 'UPDATE T_NEW_commentc
				SET NCC_content = :content, NCC_dateupdate = :datetime';
		if ( $comment->fk_MEM_author() ) {
			$sql .= ', NCC_fk_MEM_author = :author';
		}
		if ( $comment->fk_MEM_admin() ) {
			$sql .= ', NCC_fk_MEM_admin = :admin';
		}
		$sql .= ' WHERE NCC_id = :id';
		
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( $sql );
		
		if ( $comment->fk_MEM_author() ) {
			$q->bindValue( ':author', $comment->fk_MEM_author() );
		}
		if ( $comment->fk_MEM_admin() ) {
			$q->bindValue( ':admin', $comment->fk_MEM_admin() );
		}
		$q->bindValue( ':datetime', $dateutcnow->format( 'Y-m-d H:i:s' ) );
		$q->bindValue( ':content', $comment->content() );
		$q->bindValue( ':id', $comment->id(), \PDO::PARAM_INT );
		
		$q->execute();
	}
}