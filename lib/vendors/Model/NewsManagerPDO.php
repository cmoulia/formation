<?php
namespace Model;

use \Entity\News;

class NewsManagerPDO extends NewsManager {
	/**
	 * @param int $debut
	 * @param int $limite
	 *
	 * @return mixed
	 */
	public function getList( $debut = -1, $limite = -1 ) {
		$sql = 'SELECT id, auteur, titre, contenu, dateAjout, dateModif FROM T_NEW_newsc ORDER BY dateAjout DESC';
		
		if ( $debut != -1 || $limite != -1 ) {
			$sql .= ' LIMIT ' . (int)$limite . ' OFFSET ' . (int)$debut;
		}
		
		/** @var \PDOStatement $requete */
		$requete = $this->dao->query( $sql );
		$requete->setFetchMode( \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News' );
		
		$listeNews = $requete->fetchAll();
		
		/** @var News $news */
		foreach ( $listeNews as $news ) {
			$news->setDateAjout( new \DateTime( $news->dateAjout() ) );
			$news->setDateModif( new \DateTime( $news->dateModif() ) );
		}
		
		$requete->closeCursor();
		
		return $listeNews;
	}
	
	public function getUnique( $id ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'SELECT id, auteur, titre, contenu, dateAjout, dateModif FROM T_NEW_newsc WHERE id = :id' );
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
	
	public function count() {
		return $this->dao->query( 'SELECT COUNT(*) FROM T_NEW_newsc' )->fetchColumn();
	}
	
	public function delete( $id ) {
		$this->dao->exec( 'DELETE FROM T_NEW_newsc WHERE id = ' . (int)$id );
	}
	
	protected function add( News $news ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'INSERT INTO T_NEW_newsc SET auteur = :auteur, titre = :titre, contenu = :contenu, dateAjout = NOW(), dateModif = NOW()' );
		
		$requete->bindValue( ':titre', $news->titre() );
		$requete->bindValue( ':auteur', $news->auteur() );
		$requete->bindValue( ':contenu', $news->contenu() );
		
		$requete->execute();
	}
	
	protected function modify( News $news ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'UPDATE T_NEW_newsc SET auteur = :auteur, titre = :titre, contenu = :contenu, dateModif = NOW() WHERE id = :id' );
		
		$requete->bindValue( ':titre', $news->titre() );
		$requete->bindValue( ':auteur', $news->auteur() );
		$requete->bindValue( ':contenu', $news->contenu() );
		$requete->bindValue( ':id', $news->id(), \PDO::PARAM_INT );
		
		$requete->execute();
	}
}