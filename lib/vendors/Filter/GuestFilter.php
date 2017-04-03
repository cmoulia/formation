<?php
/**
 * Created by PhpStorm.
 * User: gstenek
 * Date: 31/03/2017
 * Time: 11:46
 */

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