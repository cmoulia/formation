<?php


namespace Filter;


use Entity\News;
use OCFram\Filter;
use OCFram\User;

class OwnNewsFilter extends Filter {
	protected $News;
	
	public function __construct( $redirect_or_callback, User $User, News $news ) {
		parent::__construct( $redirect_or_callback, $User );
		$this->News = $news;
	}
	
	public function check() {
		if ( $this->User()->isAdmin() ) {
			return false;
		}
		if ( $this->News->fk_MEM_author() != $this->User()->getAttribute( 'user' )[ 'id' ] ) {
			return true;
		}
		return false;
	}
}