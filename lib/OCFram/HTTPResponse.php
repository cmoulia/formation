<?php
namespace OCFram;

class HTTPResponse extends ApplicationComponent {
	/** @var Page $page */
	protected $page;
	
	public function redirect( $location ) {
		header( 'Location: ' . $location );
		exit;
	}
	
	public function redirect404() {
		$this->page = new Page( $this->app, 'html' );
		$this->page->setContentFile( __DIR__ . '/../../Errors/404.html' );
		
		$this->addHeader( 'HTTP/1.0 404 Not Found' );
		
		$this->send();
	}
	
	public function addHeader( $header ) {
		header( $header );
	}
	
	public function send() {
		switch ($this->page->format()){
			case 'json':
				$this->addHeader('Content-Type: application/json');
				break;
			default:
				$this->addHeader('Content-Type:text/html; charset=UTF-8');
		}
		exit( $this->page->getGeneratedPage() );
	}
	
	public function setPage( Page $page ) {
		$this->page = $page;
	}
	
	// Changement par rapport à la fonction setcookie() : le dernier argument est par défaut à true
	public function setCookie( $name, $value = '', $expire = 0, $path = null, $domain = null, $secure = false, $httpOnly = true ) {
		setcookie( $name, $value, $expire, $path, $domain, $secure, $httpOnly );
	}
}