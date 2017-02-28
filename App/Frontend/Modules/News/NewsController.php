<?php

/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 28/02/2017
 * Time: 11:32
 */

namespace App\Frontend\Modules\News;

use Entity\News;
use Model\NewsManagerPDO;
use OCFram\BackController;
use OCFram\HTTPRequest;

class NewsController extends BackController {
	/**
	 * @param HTTPRequest $request
	 */
	public function executeIndex( HTTPRequest $request ) {
		$nombreNews       = $this->app->getConfig()->get( 'nombre_news' );
		$nombreCaracteres = $this->app->getConfig()->get( 'nombre_caracteres' );
		
		$this->page->addVar( 'title', 'Liste des ' . $nombreNews . ' dernières news' );
		
		/** @var NewsManagerPDO $manager */
		$manager = $this->managers->getManagerOf( 'News' );
		
		$listeNews = $manager->getList( 0, $nombreNews );
		
		/** @var News $news */
		foreach ( $listeNews as $news ) {
			if ( strlen( $news->getContenu() ) > $nombreCaracteres ) {
				$debut = substr( $news->getContenu(), 0, $nombreCaracteres );
				$debut = substr( $debut, 0, strrpos( $debut, ' ' ) ) . '...';
				
				$news->setContenu( $debut );
			}
		}
		
		$this->page->addVar( 'listeNews', $listeNews );
	}
}