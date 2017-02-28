<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 27/02/2017
 * Time: 16:49
 */

namespace OCFram;


class HTTPResponse extends ApplicationComponent {
	protected $page;
	
	public function redirect( $location ) {
		header( 'Location' . $location );
		exit();
	}
	
	public function redirect404() {
		$this->page = new Page( $this->app );
		$this->page->setContentFile( __DIR__ . '/../../errors/404.html' );
		$this->addHeader( 'HTTP/1.0 404 Not Found' );
		$this->send();
	}
	
	public function addHeader( $header ) {
		header( $header );
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