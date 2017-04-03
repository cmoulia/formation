<?php


namespace Filter;


use OCFram\Filter;

class AdminFilter extends Filter {
	
	/**
	 * @return bool
	 */
	public function check() {
		if(!$this->User()->isAuthenticated()){
			return false;
		}
		
		if(!$this->User()->isAdmin()){
			return false;
		}
		
		return true;
	}
}