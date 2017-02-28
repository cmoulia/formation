<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 27/02/2017
 * Time: 18:29
 */

namespace OCFram;


/**
 * Class Manager
 *
 * @package OCFram
 */
abstract class Manager {
	/**
	 * @var \PDO
	 */
	protected $dao;
	
	/**
	 * Manager constructor.
	 *
	 * @param $dao
	 */
	public function __construct( $dao ) {
		$this->dao = $dao;
	}
}