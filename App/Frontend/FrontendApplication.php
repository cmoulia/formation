<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 28/02/2017
 * Time: 10:57
 */

namespace App\Frontend;


use OCFram\Application;
use OCFram\BackController;

class FrontendApplication extends Application {
	public function __construct() {
		parent::__construct();
		
		$this->name = 'Frontend';
	}
	
	public function run() {
		
		/** @var BackController $controller */
		$controller = $this->getController();
		$controller->execute();
		
		$this->httpResponse->setPage( $controller->getPage() );
		$this->httpResponse->send();
	}
}