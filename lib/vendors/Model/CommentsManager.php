<?php

namespace Model;

use Entity\News;
use \OCFram\Manager;
use \Entity\Comment;

abstract class CommentsManager extends Manager {
	/**
	 * Méthode permettant d'enregistrer un commentaire.
	 *
	 * @param Comment $comment Le commentaire à enregistrer
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
	 * @param Comment $comment Le commentaire à ajouter
	 *
	 * @return void
	 */
	abstract protected function add( Comment $comment );
	
	/**
	 * Méthode permettant de modifier un commentaire.
	 *
	 * @param Comment $comment Le commentaire à modifier
	 *
	 * @return void
	 */
	abstract protected function modify( Comment $comment );
	
	/**
	 * Méthode permettant de récupérer une liste de commentaires.
	 *
	 * @param News $newsId La news sur laquelle on veut récupérer les commentaires
	 *
	 * @return array
	 */
	abstract public function getListOf( $newsId );
	
	/**
	 * Méthode permettant d'obtenir un commentaire spécifique.
	 *
	 * @param int $id L'identifiant du commentaire
	 *
	 * @return Comment
	 */
	abstract public function get( $id );
	
	/**
	 * Méthode permettant d'obtenir l\'identifiant de la news d\'un commentaire spécifique.
	 *
	 * @param int $id L'identifiant du commentaire
	 *
	 * @return int
	 */
	abstract public function getNews( $id );
	
	/**
	 * Méthode permettant de supprimer un commentaire.
	 *
	 * @param int $id L'identifiant du commentaire à supprimer
	 *
	 * @return void
	 */
	abstract public function delete( $id );
	
	/**
	 * Méthode permettant de supprimer tous les commentaires liés à une news
	 *
	 * @param int $newsId L'identifiant de la news dont les commentaires doivent être supprimés
	 *
	 * @return void
	 */
	abstract public function deleteFromNews($newsId);
}