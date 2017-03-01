<?php

namespace Model;

use \Entity\Comment;

class CommentsManagerPDO extends CommentsManager {
	public function getListOf( $news ) {
		if ( !ctype_digit( $news ) ) {
			throw new \InvalidArgumentException( 'L\'identifiant de la news passé doit être un nombre entier valide' );
		}
		
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'SELECT id, news, auteur, contenu, date FROM T_NEW_commentc WHERE news = :news' );
		$q->bindValue( ':news', $news, \PDO::PARAM_INT );
		$q->execute();
		
		$q->setFetchMode( \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment' );
		
		$comments = $q->fetchAll();
		
		/** @var Comment $comment */
		foreach ( $comments as $comment ) {
			$comment->setDate( new \DateTime( $comment->date() ) );
		}
		
		return $comments;
	}
	
	public function get( $id ) {
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'SELECT id, news, auteur, contenu FROM T_NEW_commentc WHERE id = :id' );
		$q->bindValue( ':id', (int)$id, \PDO::PARAM_INT );
		$q->execute();
		
		$q->setFetchMode( \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment' );
		
		return $q->fetch();
	}
	
	public function delete( $id ) {
		$this->dao->exec( 'DELETE FROM T_NEW_commentc WHERE id = ' . (int)$id );
	}
	
	public function deleteFromNews( $news ) {
		$this->dao->exec( 'DELETE FROM T_NEW_commentc WHERE news = ' . (int)$news );
	}
	
	protected function add( Comment $comment ) {
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'INSERT INTO T_NEW_commentc SET news = :news, auteur = :auteur, contenu = :contenu, date = NOW()' );
		
		$q->bindValue( ':news', $comment->news(), \PDO::PARAM_INT );
		$q->bindValue( ':auteur', $comment->auteur() );
		$q->bindValue( ':contenu', $comment->contenu() );
		
		$q->execute();
		
		$comment->setId( $this->dao->lastInsertId() );
	}
	
	protected function modify( Comment $comment ) {
		/** @var \PDOStatement $q */
		$q = $this->dao->prepare( 'UPDATE T_NEW_commentc SET auteur = :auteur, contenu = :contenu WHERE id = :id' );
		
		$q->bindValue( ':auteur', $comment->auteur() );
		$q->bindValue( ':contenu', $comment->contenu() );
		$q->bindValue( ':id', $comment->id(), \PDO::PARAM_INT );
		
		$q->execute();
	}
}