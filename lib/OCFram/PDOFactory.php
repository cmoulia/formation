<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 27/02/2017
 * Time: 18:26
 */

namespace OCFram;


/**
 * Class PDOFactory
 *
 * @package OCFram
 */
class PDOFactory {
	/**
	 * @return \PDO
	 */
	public static function getMysqlConnexion() {
		$db = new \PDO( 'mysql:host=localhost;dbname=news', 'root', 'root' );
		$db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
		
		return $db;
	}
}