<?php

namespace OCFram;

trait AuthorizationHelper {
	protected $routes_rules = [];
	protected $action_rules = [];
	
	/**
	 * @param $role
	 * @param $action
	 * @param $right
	 */
	public function addRouteRule( $role, $action, $right ) {
		if ( !isset( $this->routes_rules[ $role . '|' . $action ] ) ) {
			$this->routes_rules[ $role . '|' . $action ] = $right;
		}
	}
	
	public function addActionRule( $action, $method ) {
		if ( !isset( $this->action_rules[ $action . '|' . $method ] ) ) {
			$this->action_rules[ $action ][] = $method;
		}
	}
	
	protected function checkRights( $action ) {
		if ( $this->app->user()->isAdmin() ) {
			return true;
		}
		
		// If there's a rule
		if ( isset( $this->routes_rules[ $this->app->user()->getRole() . '|' . $action ] ) ) {
			// If we are allowed
			if ( $this->routes_rules[ $this->app->user()->getRole() . '|' . $action ] ) {
				$this->checkCorrectRight( $action );
			}
		}
		// if there's no rule
		else {
			$this->checkCorrectRight( $action );
			
			return true;
		}
	}
	
	private function checkCorrectRight( $action ) {
		if ( !empty( $this->action_rules ) ) {
			foreach ( $this->action_rules[ $action ] as $action_rule ) {
				if ( is_callable( [
					$this,
					$action_rule,
				] ) ) {
					if ( !$this->$action_rule() ) {
						return false;
					}
				}
			}
		}
		return true;
	}
}