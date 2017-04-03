<?php

namespace Filter;

use OCFram\Filter;

class UserFilter extends Filter {
	public function check() {
		
		if ( $this->User()->isAuthenticated() ) {
			return true;
		}
		
		return false;
	}
}