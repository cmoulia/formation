<?php

namespace Model;


use Entity\Role;
use OCFram\Manager;

abstract class RoleManager extends Manager {
	/**
	 * Method to get all Roles
	 *
	 * @param int $offset
	 * @param int $limit
	 *
	 * @return mixed
	 */
	abstract public function getList($offset = -1, $limit = -1);
	
	/**
	 * Méthode permettant d'obtenir un role spécifique.
	 *
	 * @param int $id L'identifiant du role
	 *
	 * @return Role
	 */
	abstract public function getUnique( $id );
	
	/**
	 * Méthode permettant d'ajouter un role.
	 *
	 * @param Role $role Le role à ajouter
	 *
	 * @return void
	 */
	abstract protected function add( Role $role );
	
	abstract protected function count();
	
	/**
	 * Méthode permettant de modifier un role.
	 *
	 * @param Role $role Le commentaire à modifier
	 *
	 * @return void
	 */
	abstract protected function modify( Role $role );
	
	/**
	 * Méthode permettant de supprimer un role.
	 *
	 * @param int $id L'identifiant du role à supprimer
	 *
	 * @return void
	 */
	abstract public function delete( $id );
	
	/**
	 * Méthode permettant d'enregistrer un role.
	 *
	 * @param Role $role Le role à enregistrer
	 *
	 * @return void
	 */
	public function save( Role $role ) {
		if ( $role->isValid() ) {
			$role->isNew() ? $this->add( $role ) : $this->modify( $role );
		}
		else {
			throw new \RuntimeException( 'Le role doit être validé pour être enregistré' );
		}
	}
}