<?php

/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 28/02/2017
 * Time: 11:32
 */

namespace Model;

use OCFram\Manager;

abstract class NewsManager extends Manager {
	abstract public function getList( $debut = -1, $limite = -1 );
}