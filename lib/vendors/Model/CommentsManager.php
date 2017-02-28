<?php

namespace Model;

use \OCFram\Manager;
use \Entity\Comment;

abstract class CommentsManager extends Manager {
	/**
	 * Méthode permettant d'enregistrer un commentaire.
	 *
	 * @param $comment Le commentaire à enregistrer
	 *
	 * @return void
	 */
	public function save( Comment $comment ) {
		if ( $comment->isValid() ) {
			$comment->isNew() ? $this->add( $comment ) : $this->modify( $comment );
		}
		else {
			throw new \RuntimeException( 'Le commentaire doit être validé pour être enregistré' );
		}
	}
	
	/**
	 * Méthode permettant d'ajouter un commentaire.
	 *
	 * @param $comment Le commentaire à ajouter
	 *
	 * @return void
	 */
	abstract protected function add( Comment $comment );
	
	/**
	 * Méthode permettant de récupérer une liste de commentaires.
	 *
	 * @param $news La news sur laquelle on veut récupérer les commentaires
	 *
	 * @return array
	 */
	abstract public function getListOf( $news );
}