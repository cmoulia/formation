<?php

namespace Filter;


use OCFram\Filter;

class GuestFilter extends Filter {
	
	public function check() {
		
		if(!$this->User()->isAuthenticated()){
			return true;
		}
		
		return false;
		
	}
	
}