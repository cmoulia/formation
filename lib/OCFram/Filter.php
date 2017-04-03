<?php

namespace OCFram;


abstract class Filter {
	
	
	protected $redirect;
	protected $User;
	
	/**
	 * Filter constructor.
	 *
	 * @param string|callable $redirect_or_callback Url de redirection ou fonction de callback
	 * @param User  $User
	 */
	public function __construct($redirect_or_callback, User $User)
	{
		$this->setRedirect($redirect_or_callback);
		$this->setUser($User);
	}
	
	/**
	 * @return mixed
	 */
	public function redirect() {
		return $this->redirect;
	}
	
	/**
	 * @param string|callable $redirect Url de redirection ou fonction de callback
	 */
	public function setRedirect( $redirect ) {
		$this->redirect = $redirect;
	}
	
	/**
	 * @param User $User
	 */
	public function setUser(User $User ) {
		$this->User = $User;
	}
	
	/**
	 * @return User
	 */
	public function User() {
		return $this->User;
	}
	
	/**
	 * @return bool
	 */
	abstract public function check();
	
}