<?php
namespace Model;

use \OCFram\Manager;
use \Entity\User;

abstract class UserManager extends Manager {
	/**
	 * Méthode retournant une liste des utilisateurs.
	 *
	 * @param int $offset Le premier utilisateur à sélectionner
	 * @param int $limit  Le nombre d'utilisateurs à sélectionner
	 *
	 * @return array La liste des utilisateurs. Chaque entrée est une instance de User.
	 */
	abstract public function getList( $offset = -1, $limit = -1 );
	
	/**
	 * Méthode retournant un user précis.
	 *
	 * @param int $id L'identifiant de l'user à récupérer
	 *
	 * @return User L'user demandé
	 */
	abstract public function getUnique( $id );
	
	/**
	 * Méthode retournant un user précis.
	 *
	 * @param string $login Email ou Pseudo de l'user à récupérer
	 *
	 * @return User L'user demandé
	 */
	abstract public function getUniqueByUsernameOrEmail( $login );
	
	abstract public function getUniqueByUsername ($username);
	abstract public function getUniqueByEmail ($email);
	abstract public function checkExistencyByUsername ($username);
	abstract public function checkExistencyByEmail ($email);
	
	/**
	 * Méthode renvoyant le nombre d'utilisateurs total.
	 *
	 * @return int
	 */
	abstract public function count();
	
	/**
	 * Méthode permettant d'enregistrer un utilisateur.
	 *
	 * @param User $user l'utilisateur à enregistrer
	 *
	 * @see self::add()
	 * @see self::modify()
	 * @return void
	 */
	public function save( User $user ) {
		if ( $user->isValid() ) {
			$user->isNew() ? $this->add( $user ) : $this->modify( $user );
		}
		else {
			throw new \RuntimeException( 'L\'utilisateur doit être validé pour être enregistré' );
		}
	}
	
	/**
	 * Méthode permettant d'ajouter un utilisateur.
	 *
	 * @param User $user L'utilisateur à ajouter
	 *
	 * @return void
	 */
	abstract protected function add( User $user );
	
	/**
	 * Méthode permettant de modifier un utilisateur.
	 *
	 * @param User $user l'utilisateur à modifier
	 *
	 * @return void
	 */
	abstract protected function modify( User $user );
	
	/**
	 * Méthode permettant de supprimer un utilisateur.
	 *
	 * @param int $id L'identifiant de l'utilisateur à supprimer
	 *
	 * @return void
	 */
	abstract public function delete( $id );
}