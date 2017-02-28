<?php

/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 28/02/2017
 * Time: 11:32
 */

namespace Model;

use \Entity\News;

class NewsManagerPDO extends NewsManager {
	/**
	 * @param int $debut
	 * @param int $limite
	 *
	 * @return array
	 */
	public function getList( $debut = -1, $limite = -1 ) {
		$sql = 'SELECT id, auteur, titre, contenu, dateAjout, dateModif FROM news ORDER BY id DESC';
		
		if ( $debut != -1 || $limite != -1 ) {
			$sql .= ' LIMIT ' . (int)$limite . ' OFFSET ' . (int)$debut;
		}
		
		/** @var \PDOStatement $requete */
		$requete = $this->dao->query( $sql );
		$requete->setFetchMode( \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News' );
		
		$listeNews = $requete->fetchAll();
		
		/** @var News $news */
		foreach ( $listeNews as $news ) {
			$news->setDateAjout( new \DateTime( $news->getDateAjout() ) );
			$news->setDateModif( new \DateTime( $news->getDateModif() ) );
		}
		
		$requete->closeCursor();
		
		return $listeNews;
	}
}