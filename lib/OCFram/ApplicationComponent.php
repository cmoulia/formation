<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 27/02/2017
 * Time: 17:02
 */

namespace OCFram;


/**
 * Class ApplicationComponent
 *
 * @package OCFram
 */
abstract class ApplicationComponent {
	/**
	 * @var Application
	 */
	protected $app;
	
	/**
	 * ApplicationComponent constructor.
	 *
	 * @param Application $app
	 */
	public function __construct( Application $app ) {
		$this->app = $app;
	}
	
	/**
	 * @return Application
	 */
	public function getApp() {
		return $this->app;
	}
}