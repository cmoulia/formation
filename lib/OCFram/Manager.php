<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 27/02/2017
 * Time: 18:29
 */

namespace OCFram;


abstract class Manager {
	protected $dao;
	
	public function __construct( $dao ) {
		$this->dao = $dao;
	}
}