<?php
namespace OCFram;

class PDOFactory {
	public static function getMysqlConnexion() {
		$db = new \PDO( 'mysql:host=localhost;dbname=news', 'root', 'root' );
		$db->exec( 'SET CHARACTER SET utf8' );
		$db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
		
		return $db;
	}
}