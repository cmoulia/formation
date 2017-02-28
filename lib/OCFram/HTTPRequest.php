<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 27/02/2017
 * Time: 16:36
 */

namespace OCFram;


/**
 * Class HTTPRequest
 *
 * @package OCFram
 */
class HTTPRequest extends ApplicationComponent {
	/**
	 * @param $key
	 *
	 * @return null
	 */
	public function cookieData( $key ) {
		return isset( $_COOKIE[ $key ] ) ? $_COOKIE[ $key ] : null;
	}
	
	/**
	 * @param $key
	 *
	 * @return bool
	 */
	public function cookieExists( $key ) {
		return isset( $_COOKIE[ $key ] );
	}
	
	/**
	 * @param $key
	 *
	 * @return null
	 */
	public function getData( $key ) {
		return isset( $_GET[ $key ] ) ? $_GET[ $key ] : null;
	}
	
	/**
	 * @param $key
	 *
	 * @return bool
	 */
	public function getExists( $key ) {
		return isset( $_GET[ $key ] );
	}
	
	/**
	 * @return mixed
	 */
	public function method() {
		return $_SERVER[ 'REQUEST_METHOD' ];
	}
	
	/**
	 * @param $key
	 *
	 * @return null
	 */
	public function postData( $key ) {
		return isset( $_POST[ $key ] ) ? $_POST[ $key ] : null;
	}
	
	/**
	 * @param $key
	 *
	 * @return bool
	 */
	public function postExists( $key ) {
		return isset( $_POST[ $key ] );
	}
	
	/**
	 * @return mixed
	 */
	public function requestURI() {
		return $_SERVER[ 'REQUEST_URI' ];
	}
}