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
		$sql = 'SELECT NNC_id, NNC_author, NNC_title, NNC_content, NNC_dateadd, NNC_dateupdate FROM T_NEW_newsc ORDER BY NNC_dateadd DESC';
		
		if ( $debut != -1 || $limite != -1 ) {
			$sql .= ' LIMIT ' . (int)$limite . ' OFFSET ' . (int)$debut;
		}
		
		/** @var \PDOStatement $requete */
		$requete = $this->dao->query( $sql );
		$requete->setFetchMode(\PDO::FETCH_ASSOC);
		$news_a = $requete->fetchAll();
		
		/** @var array $news */
		foreach ( $news_a as $key => $news ) {
			$news['NNC_dateadd'] = new \DateTime($news['NNC_dateadd']);
			$news['NNC_dateupdate'] = new \DateTime($news['NNC_dateupdate']);
			$news_a[$key] = new News($news);
		}
		
		$requete->closeCursor();
		
		return $news_a;
	}
	
	public function getUnique( $id ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'SELECT NNC_id, NNC_author, NNC_title, NNC_content, NNC_dateadd, NNC_dateupdate FROM T_NEW_newsc WHERE NNC_id = :id' );
		$requete->bindValue( ':id', (int)$id, \PDO::PARAM_INT );
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_ASSOC);
		
		if ( $news = $requete->fetch() ) {
			$news['NNC_dateadd'] = new \DateTime($news['NNC_dateadd']);
			$news['NNC_dateupdate'] = new \DateTime($news['NNC_dateupdate']);

			return new News($news);
		}
		
		return null;
	}
	
	public function count() {
		return $this->dao->query( 'SELECT COUNT(*) FROM T_NEW_newsc' )->fetchColumn();
	}
	
	public function delete( $id ) {
		$this->dao->exec( 'DELETE FROM T_NEW_newsc WHERE NNC_id = ' . (int)$id );
	}
	
	protected function add( News $news ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'INSERT INTO T_NEW_newsc SET NNC_author = :author, NNC_title = :title, NNC_content = :content, NNC_dateadd = NOW(), NNC_dateupdate = NOW()' );
		
		$requete->bindValue( ':title', $news->title() );
		$requete->bindValue( ':author', $news->author() );
		$requete->bindValue( ':content', $news->content() );
		
		$requete->execute();
	}
	
	protected function modify( News $news ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'UPDATE T_NEW_newsc SET NNC_author = :author, NNC_title = :title, NNC_content = :content, NNC_dateupdate = NOW() WHERE NNC_id = :id' );
		
		$requete->bindValue( ':author', $news->author() );
		$requete->bindValue( ':title', $news->title() );
		$requete->bindValue( ':content', $news->content() );
		$requete->bindValue( ':id', $news->id(), \PDO::PARAM_INT );
		
		$requete->execute();
	}
}