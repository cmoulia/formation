<?php

namespace Model;

use Entity\Role;

class RoleManagerPDO extends RoleManager {
	/**
	 * @param int $limit
	 * @param int $offset
	 *
	 * @return \Entity\Role[]
	 */
	public function getList( $limit = -1, $offset = -1 ) {
//		SELECT everything from T_MEM_rolec
		$sql = 'SELECT MRC_id, MRC_name, MRC_description
				FROM T_MEM_rolec';
		
		//		If we want the top X
		if ( $limit != -1 ) {
			$sql .= ' LIMIT ' . (int)$limit;
			
			//			If we want the data starting at a certain point
			if ( $offset != -1 ) {
				$sql .= ' OFFSET ' . (int)$offset;
			}
			
		}
		
		/** @var \PDOStatement $query */
		$query = $this->dao->query( $sql );
		$query->setFetchMode( \PDO::FETCH_ASSOC );
		$role_a = $query->fetchAll();
		
		foreach ( $role_a as $key => $role ) {
			$role_a[ $key ] = new Role( $role );
		}
		
		$query->closeCursor();
		
		return $role_a;
	}
	
	/**
	 * @param int $id
	 *
	 * @return Role|null
	 */
	public function getUnique( $id ) {
		/** @var \PDOStatement $query */
		$query = $this->dao->prepare( 'SELECT MRC_id, MRC_name, MRC_description
									   FROM T_MEM_rolec
									   WHERE MRC_id = :id' );
		$query->bindValue( ':id', (int)$id, \PDO::PARAM_INT );
		$query->execute();
		$query->setFetchMode( \PDO::FETCH_ASSOC );
		
		if ( $role = $query->fetch() ) {
			return new Role( $role );
		}
		
		return null;
	}
	
	/**
	 * @return mixed
	 */
	protected function count() {
		return $this->dao->query( 'SELECT COUNT(*)
								   FROM T_MEM_rolec' )->fetchColumn();
	}
	
	/**
	 * @param Role $role
	 */
	protected function add( Role $role ) {
		/** @var \PDOStatement $query */
		$query = $this->dao->prepare( 'INSERT INTO T_MEM_rolec
									   SET MRC_name = :name, MRC_description = :description' );
		$query->bindValue( ':name', $role->name() );
		$query->bindValue( ':description', $role->description() );
		
		$query->execute();
	}
	
	/**
	 * @param Role $role
	 */
	protected function modify( Role $role ) {
		/** @var \PDOStatement $query */
		$query = $this->dao->prepare( 'UPDATE T_MEM_rolec
									   SET MRC_name = :name, MRC_description = :description
									   WHERE MRC_id = :id' );
		$query->bindValue( ':name', $role->name() );
		$query->bindValue( ':description', $role->description() );
		$query->bindValue( ':id', $role->id(), \PDO::PARAM_INT );
		
		$query->execute();
	}
	
	/**
	 * @param int $id
	 */
	public function delete( $id ) {
		$this->dao->exec( 'DELETE FROM T_MEM_rolec
						   WHERE MRC_id = ' . (int)$id );
	}
}