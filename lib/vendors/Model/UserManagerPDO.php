<?php

namespace Model;

use Entity\User;

class UserManagerPDO extends UserManager {
	/**
	 * @param int $limit
	 * @param int $offset
	 *
	 * @return array
	 */
	public function getList( $limit = -1, $offset = -1 ) {
		//		SELECT everything from T_MEM_memberc
		$sql = 'SELECT MEM_id, MEM_fk_MRC, MEM_firstname, MEM_lastname, MEM_email, MEM_username, MEM_birthdate, MEM_dateregister FROM T_MEM_memberc ORDER BY MEM_dateregister DESC';
		
		//		If we want the top X
		if ( $limit != -1 ) {
			$sql .= ' LIMIT ' . (int)$limit;
			
			//			If we want the data starting at a certain point
			if ( $offset != -1 ) {
				$sql .= ' OFFSET ' . (int)$offset;
			}
		}
		
		/** @var \PDOStatement $requete */
		$requete = $this->dao->query( $sql );
		//		\PDO::FETCH_ASSOC is set, we get an array with the columns as the keys of the array
		$requete->setFetchMode( \PDO::FETCH_ASSOC );
		$user_a = $requete->fetchAll();
		
		foreach ( $user_a as $key => $user ) {
			//			Dates are return from the database as a string, we need them in DateTime format, we set the date as a DateTime instance with the string in parameter
			$user[ 'MEM_birthdate' ]    = new \DateTime( $user[ 'MEM_birthdate' ] );
			$user[ 'MEM_dateregister' ] = new \DateTime( $user[ 'MEM_dateregister' ] );
			//			We instanciate each sub-array as a new User entity
			$user_a[ $key ] = new User( $user );
		}
		
		$requete->closeCursor();
		
		//		We return the array of User entities
		return $user_a;
	}
	
	/**
	 * @param int $id
	 *
	 * @return User|null
	 */
	public function getUnique( $id ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'SELECT MEM_id, MEM_fk_MRC, MEM_firstname, MEM_lastname, MEM_email, MEM_username, MEM_password, MEM_birthdate, MEM_dateregister FROM T_MEM_memberc WHERE MEM_id = :id' );
		$requete->bindValue( ':id', (int)$id, \PDO::PARAM_INT );
		$requete->execute();
		$requete->setFetchMode( \PDO::FETCH_ASSOC );
		
		if ( $user = $requete->fetch() ) {
			//			Dates are return from the database as a string, we need them in DateTime format, we set the date as a DateTime instance with the string in parameter
			$user[ 'MEM_birthdate' ]    = new \DateTime( $user[ 'MEM_birthdate' ] );
			$user[ 'MEM_dateregister' ] = new \DateTime( $user[ 'MEM_dateregister' ] );
			
			//			new instance of Entity\User with the array from the db in parameter
			return new User( $user );
		}
		
		//		If we were unable to fetch, meaning there's no user with that id
		return null;
	}
	
	/**
	 * @param string $login
	 *
	 * @return User|null
	 */
	public function getUniqueByUsernameOrEmail( $login ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'SELECT MEM_id, MEM_fk_MRC, MEM_firstname, MEM_lastname, MEM_email, MEM_username, MEM_password, MEM_birthdate, MEM_dateregister FROM T_MEM_memberc WHERE MEM_username = :username OR MEM_email = :email' );
		$requete->bindValue( ':username', $login );
		$requete->bindValue( ':email', $login );
		$requete->execute();
		$requete->setFetchMode( \PDO::FETCH_ASSOC );
		
		if ( $user = $requete->fetch() ) {
			$user[ 'MEM_birthdate' ]    = new \DateTime( $user[ 'MEM_birthdate' ] );
			$user[ 'MEM_dateregister' ] = new \DateTime( $user[ 'MEM_dateregister' ] );
			
			return new User( $user );
		}
		
		return null;
	}
	
	public function getUniqueByUsername( $username ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'SELECT MEM_id, MEM_fk_MRC, MEM_firstname, MEM_lastname, MEM_email, MEM_username, MEM_password, MEM_birthdate, MEM_dateregister FROM T_MEM_memberc WHERE MEM_username = :username' );
		$requete->bindValue( ':username', $username );
		$requete->execute();
		$requete->setFetchMode( \PDO::FETCH_ASSOC );
		
		if ( $user = $requete->fetch() ) {
			$user[ 'MEM_birthdate' ]    = new \DateTime( $user[ 'MEM_birthdate' ] );
			$user[ 'MEM_dateregister' ] = new \DateTime( $user[ 'MEM_dateregister' ] );
			
			return new User( $user );
		}
		
		return null;
	}
	
	public function getUniqueByEmail( $email ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'SELECT MEM_id, MEM_fk_MRC, MEM_firstname, MEM_lastname, MEM_email, MEM_username, MEM_password, MEM_birthdate, MEM_dateregister FROM T_MEM_memberc WHERE MEM_email = :email' );
		$requete->bindValue( ':email', $email );
		$requete->execute();
		$requete->setFetchMode( \PDO::FETCH_ASSOC );
		
		if ( $user = $requete->fetch() ) {
			$user[ 'MEM_birthdate' ]    = new \DateTime( $user[ 'MEM_birthdate' ] );
			$user[ 'MEM_dateregister' ] = new \DateTime( $user[ 'MEM_dateregister' ] );
			
			return new User( $user );
		}
		
		return null;
	}
	
	public function checkExistencyByUsername( $username, $excluded_id = null ) {
		/** @var \PDOStatement $requete */
		$sql = 'SELECT MEM_id FROM T_MEM_memberc WHERE MEM_username = :username';
		if ($excluded_id) {
			$sql.= ' AND MEM_id != :mem_id';
		}
		$requete = $this->dao->prepare( $sql );
		$requete->bindValue( ':username', $username );
		if ($excluded_id) {
			$requete->bindValue(':mem_id',$excluded_id,\PDO::PARAM_INT);
		}
		$requete->execute();
		$requete->setFetchMode( \PDO::FETCH_ASSOC );
		
		return ( $requete->fetch() ) ? true : false;
	}
	
	public function checkExistencyByEmail( $email ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'SELECT MEM_id FROM T_MEM_memberc WHERE MEM_email = :email' );
		$requete->bindValue( ':email', $email );
		$requete->execute();
		$requete->setFetchMode( \PDO::FETCH_ASSOC );
		
		return ( $requete->fetch() ) ? true : false;
	}
	
	public function checkExistency( $attribute, $value ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'SELECT MEM_id FROM T_MEM_memberc WHERE MEM_'.$attribute.' = :value' );
		//		$requete->bindValue( ':attribute', $attribute );
		$requete->bindValue( ':value', $value );
		$requete->execute();
		$requete->setFetchMode( \PDO::FETCH_ASSOC );
		
		return ( $requete->fetch() ) ? true : false;
	}
	
	/**
	 * @return mixed
	 */
	public function count() {
		return $this->dao->query( 'SELECT COUNT(*) FROM T_MEM_memberc' )->fetchColumn();
	}
	
	/**
	 * @param User $user
	 */
	protected function add( User $user ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'INSERT INTO T_MEM_memberc SET MEM_firstname = :firstname, MEM_lastname = :lastname, MEM_email = :email, MEM_username = :username, MEM_password = :password, MEM_birthdate = :birthdate, MEM_dateregister = NOW()' );
		
		$requete->bindValue( ':firstname', $user->firstname() );
		$requete->bindValue( ':lastname', $user->lastname() );
		$requete->bindValue( ':email', $user->email() );
		$requete->bindValue( ':username', $user->username() );
		$requete->bindValue( ':password', $user->password() );
		$requete->bindValue( ':birthdate', $user->birthdate()->format( "Y-m-d H:i:s" ) );
		
		$requete->execute();
		
		$user->setId( $this->dao->lastInsertId() );
	}
	
	/**
	 * @param User $user
	 */
	protected function modify( User $user ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'UPDATE T_MEM_memberc SET MEM_username = :username, MEM_firstname = :firstname, MEM_lastname = :lastname, MEM_email = :email, MEM_birthdate = :birthdate WHERE MEM_id = :id' );
		
		$requete->bindValue( ':username', $user->username() );
		$requete->bindValue( ':firstname', $user->firstname() );
		$requete->bindValue( ':lastname', $user->lastname() );
		$requete->bindValue( ':email', $user->email() );
		$requete->bindValue( ':birthdate', $user->birthdate()->format( "Y-m-d H:i:s" ) );
		$requete->bindValue( ':id', $user->id(), \PDO::PARAM_INT );
		
		$requete->execute();
	}
	
	/**
	 * @param int $id
	 */
	public function delete( $id ) {
		$this->dao->exec( 'DELETE FROM T_MEM_memberc WHERE MEM_id = ' . (int)$id );
		$this->dao->exec( 'DELETE FROM T_NEW_newsc WHERE NNC_fk_MEM_author = ' . (int)$id );
		$this->dao->exec( 'DELETE FROM T_MEM_memberc WHERE MEM_id = ' . (int)$id );
	}
}