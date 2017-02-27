<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 27/02/2017
 * Time: 16:49
 */

namespace OCFram;


class HTTPResponse {
	protected $page;
	
	public function addHeader( $header ) {
		header( $header );
	}
	
	public function redirect( $location ) {
		header( 'Location' . $location );
		exit();
	}
	
	public function redirect404() {
	}
	
	public function send() {
		exit( $this->page->getGeneratedPage() );
	}
	
	public function setCookie( $name, $value = '', $expire = 0, $path = null, $domain = null, $secure = false, $httpOnly = true ) {
		setcookie( $name, $value, $expire, $path, $domain, $secure, $httpOnly );
	}
	
	/**
	 * @param mixed $page
	 */
	public function setPage( Page $page ) {
		$this->page = $page;
	}
}