<?php

namespace OCFram;

/**
 * Class Authorizer
 *
 * Permet d'exécuter une fonction et/ou de rediriger en fonction d'un filter
 *
 * @package OCFram
 *
 */
class Authorizer extends ApplicationComponent {
	
	protected $checked = false;
	
	/** @var Filter[] */
	protected $Filter_a = []; // tableau de filter
	
	/** @param  Application $App */
	public function __construct(Application $App) {
		
		parent::__construct($App);
	}
	
	/**
	 * @param Filter | Filter[] $Filter
	 *
	 * @throws \Exception
	 */
	public function addFilter($Filter) {
		if (!is_array($Filter)) {
			$Filter = [$Filter];
		}
		if ($this->checked) {
			throw new \Exception('Authorizer already checkec');
		}
		$this->Filter_a = array_merge($this->Filter_a,$Filter);
	}
	
	/**
	 *
	 * @return void
	 */
	public function checkFilter(){
		$this->checked = true;
		if(empty($this->Filter_a)){
			return;
		}
		/** @var Filter $Filter */
		foreach ( $this->Filter_a as $Filter ) {
			if($Filter->check()){
				$redirect = $Filter->redirect();
				if (is_callable($redirect)) {
					$redirect();
				}
				else {
					$this->app()->HTTPResponse()->redirect( $redirect);
				}
			}
		}
	}
	
	
}