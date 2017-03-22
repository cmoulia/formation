<?php


namespace Model;


use Entity\User;

class UserManagerPDO extends UserManager {
	public function getList( $offset = -1, $limit = -1 ) {
		$sql = 'SELECT MEM_id, MEM_fk_MRC, MEM_firstname, MEM_lastname, MEM_email, MEM_username, MEM_birthdate, MEM_dateregister FROM T_MEM_memberc ORDER BY MEM_dateregister DESC';
		
		if ( $offset != -1 || $limit != -1 ) {
			$sql .= ' LIMIT ' . (int)$limit . ' OFFSET ' . (int)$offset;
		}
		
		/** @var \PDOStatement $requete */
		$requete = $this->dao->query( $sql );
		$requete->setFetchMode(\PDO::FETCH_ASSOC);
		$user_a = $requete->fetchAll();
		
		foreach ( $user_a as $key => $user ) {
			$user['MEM_birthdate'] = new \DateTime($user['MEM_birthdate']);
			$user['MEM_dateregister'] = new \DateTime($user['MEM_dateregister']);
			$user_a[$key] = new User($user);
		}
		
		$requete->closeCursor();
		
		return $user_a;
	}
	
	public function getUnique( $id ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'SELECT MEM_id, MEM_fk_MRC, MEM_firstname, MEM_lastname, MEM_email, MEM_username, MEM_password, MEM_birthdate, MEM_dateregister FROM T_MEM_memberc WHERE MEM_id = :id' );
		$requete->bindValue( ':id', (int)$id, \PDO::PARAM_INT );
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_ASSOC);
		
		if ( $user = $requete->fetch() ) {
			$user['MEM_birthdate'] = new \DateTime($user['MEM_birthdate']);
			$user['MEM_dateregister'] = new \DateTime($user['MEM_dateregister']);
			
			return new User($user);
		}
		
		return null;
	}
	
	public function getUniqueByUsernameOrEmail( $login ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'SELECT MEM_id, MEM_fk_MRC, MEM_firstname, MEM_lastname, MEM_email, MEM_username, MEM_password, MEM_birthdate, MEM_dateregister FROM T_MEM_memberc WHERE MEM_username = :username OR MEM_email = :email' );
		$requete->bindValue( ':username', $login );
		$requete->bindValue( ':email', $login );
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_ASSOC);
		
		if ( $user = $requete->fetch() ) {
			$user['MEM_birthdate'] = new \DateTime($user['MEM_birthdate']);
			$user['MEM_dateregister'] = new \DateTime($user['MEM_dateregister']);
			
			return new User($user);
		}
		
		return null;
	}
	
	public function count() {
		return $this->dao->query( 'SELECT COUNT(*) FROM T_MEM_memberc' )->fetchColumn();
	}
	
	protected function add( User $user ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'INSERT INTO T_MEM_memberc SET MEM_firstname = :firstname, MEM_lastname = :lastname, MEM_email = :email, MEM_username = :username, MEM_password = :password, MEM_birthdate = :birthdate, MEM_dateregister = NOW()' );
		
		$requete->bindValue( ':firstname', $user->firstname() );
		$requete->bindValue( ':lastname', $user->lastname() );
		$requete->bindValue( ':email', $user->email() );
		$requete->bindValue( ':username', $user->username() );
		$requete->bindValue( ':password', $user->password() );
		$requete->bindValue( ':birthdate', $user->birthdate()->format("Y-m-d H:i:s") );
		
		$requete->execute();
	}
	
	protected function modify( User $user ) {
		/** @var \PDOStatement $requete */
		$requete = $this->dao->prepare( 'UPDATE T_MEM_memberc SET MEM_firstname = :firstname, MEM_lastname = :lastname, MEM_birthdate = :birthdate WHERE MEM_id = :id' );
		
		$requete->bindValue( ':firstname', $user->firstname() );
		$requete->bindValue( ':lastname', $user->lastname() );
		$requete->bindValue( ':birthdate', $user->birthdate()->format("Y-m-d H:i:s") );
		$requete->bindValue( ':id', $user->id(), \PDO::PARAM_INT );
		
		$requete->execute();
	}
	
	public function delete( $id ) {
		$this->dao->exec( 'DELETE FROM T_MEM_memberc WHERE MEM_id = ' . (int)$id );
	}
}