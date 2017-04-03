<?php


namespace Filter;


use Entity\Comment;
use OCFram\Filter;
use OCFram\User;

class OwnCommentFilter extends Filter {
	protected $comment;
	
	public function __construct( $redirect_or_callback, User $User, Comment $comment ) {
		parent::__construct( $redirect_or_callback, $User );
		$this->comment = $comment;
	}
	
	public function check() {
		if ( $this->User()->isAdmin() ) {
			return false;
		}
		if ( $this->comment->fk_MEM_author() != $this->User()->getAttribute( 'user' )[ 'id' ] ) {
			return true;
		}
		
		return false;
	}
}