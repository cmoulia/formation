<?php

namespace OCFram;

trait MenuHelper {
	/**
	 * @param User $user
	 *
	 * @return Menu
	 */
	public function getMenu( $user ) {
		$role = User::DEFAULTROLE;
		if ( $user->isAuthenticated() ) {
			$role = User::AUTHENTICATEDROLE;
			if ( $user->isAdmin() ) {
				$role = User::ADMINROLE;
			}
		}
		
		return $this->menu[ $this->name.'|'.	$role ];
	}
	
	/**
	 * @param Menu $menu
	 *
	 */
	protected function addMenu( Menu $menu ) {
		if ( empty( $this->menu[ $menu->app()->name()|$menu->authlevel() ] ) || !in_array( $menu, $this->menu ) ) {
			$this->menu[ $menu->app()->name().'|'.$menu->authlevel() ] = $menu;
		}
	}
}