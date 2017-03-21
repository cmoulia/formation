<?php


namespace Model;


use Entity\User;

class UserManagerPDO extends UserManager {
	public function getList( $debut = -1, $limite = -1 ) {
		$sql = 'SELECT id, firstname, lastname, email, username, birthdate, dateregister FROM T_MEM_memberc ORDER BY dateregister DESC';
		
		if ( $debut != -1 || $limite != -1 ) {
			$sql .= ' LIMIT ' . (int)$limite . ' OFFSET ' . (int)$debut;
		}
		
		/** @var \PDOStatement $requete */
		$requete = $this->dao->query( $sql );
		$requete->setFetchMode( \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\User' );
		
		$listeUsers = $requete->fetchAll();
		
		/** @var User $user */
		foreach ( $listeUsers as $user ) {
			$user->setBirthdate( new \DateTime( $user->birthdate() ) );
			$user->setDateRegister( new \DateTime( $user->dateRegister() ) );
		}
		
		$requete->closeCursor();
		
		return $listeUsers;
	}
	
	public function getUnique( $id ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'SELECT id, firstname, lastname, email, username, password, birthdate, dateregister FROM T_MEM_memberc WHERE id = :id' );
		$requete->bindValue( ':id', (int)$id, \PDO::PARAM_INT );
		$requete->execute();
		
		$requete->setFetchMode( \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\User' );
		
		if ( $user = $requete->fetch() ) {
			$user->setBirthdate( new \DateTime( $user->birthdate() ) );
			$user->setDateRegister( new \DateTime( $user->dateRegister() ) );
			
			return $user;
		}
		
		return null;
	}
	
	public function getIdByUsernameOrEmail( $login ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'SELECT id FROM T_MEM_memberc WHERE username = :username OR email = :email' );
		$requete->bindValue( ':username', $login );
		$requete->bindValue( ':email', $login );
		$requete->execute();
		
		return $requete->fetch();
	}
	
	public function count() {
		return $this->dao->query( 'SELECT COUNT(*) FROM T_MEM_memberc' )->fetchColumn();
	}
	
	public function delete( $id ) {
		$this->dao->exec( 'DELETE FROM T_MEM_memberc WHERE id = ' . (int)$id );
	}
	
	protected function add( User $user ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'INSERT INTO T_MEM_memberc SET firstname = :firstname, dateregister = NOW()' );
		
		$requete->bindValue( ':firstname', $user->firstname() );
		$requete->bindValue( ':lastname', $user->lastname() );
		$requete->bindValue( ':email', $user->email() );
		$requete->bindValue( ':username', $user->username() );
		$requete->bindValue( ':password', $user->password() );
		$requete->bindValue( ':birthdate', $user->birthdate() );
		
		$requete->execute();
	}
	
	protected function modify( User $user ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'UPDATE T_MEM_memberc SET firstname = :firstname, lastname = :lastname, birthdate = :birthdate WHERE id = :id' );
		
		$requete->bindValue( ':firstname', $user->firstname() );
		$requete->bindValue( ':lastname', $user->lastname() );
		$requete->bindValue( ':birthdate', $user->birthdate() );
		$requete->bindValue( ':id', $user->id(), \PDO::PARAM_INT );
		
		$requete->execute();
	}
}