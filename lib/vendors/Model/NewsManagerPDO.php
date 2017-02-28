<?php
namespace Model;

use \Entity\News;

class NewsManagerPDO extends NewsManager {
	public function getList( $debut = -1, $limite = -1 ) {
		$sql = 'SELECT id, auteur, titre, contenu, dateAjout, dateModif FROM news ORDER BY id DESC';
		
		if ( $debut != -1 || $limite != -1 ) {
			$sql .= ' LIMIT ' . (int)$limite . ' OFFSET ' . (int)$debut;
		}
		
		$requete = $this->dao->query( $sql );
		$requete->setFetchMode( \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News' );
		
		$listeNews = $requete->fetchAll();
		
		foreach ( $listeNews as $news ) {
			$news->setDateAjout( new \DateTime( $news->dateAjout() ) );
			$news->setDateModif( new \DateTime( $news->dateModif() ) );
		}
		
		$requete->closeCursor();
		
		return $listeNews;
	}
	
	public function getUnique( $id ) {
		$requete = $this->dao->prepare( 'SELECT id, auteur, titre, contenu, dateAjout, dateModif FROM news WHERE id = :id' );
		$requete->bindValue( ':id', (int)$id, \PDO::PARAM_INT );
		$requete->execute();
		
		$requete->setFetchMode( \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News' );
		
		if ( $news = $requete->fetch() ) {
			$news->setDateAjout( new \DateTime( $news->dateAjout() ) );
			$news->setDateModif( new \DateTime( $news->dateModif() ) );
			
			return $news;
		}
		
		return null;
	}
}