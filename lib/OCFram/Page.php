<?php
/**
 * Created by PhpStorm.
 * User: cmoulia
 * Date: 27/02/2017
 * Time: 18:41
 */

namespace OCFram;


/**
 * Class Page
 *
 * @package OCFram
 */
class Page extends ApplicationComponent {
	/**
	 * @var
	 */
	protected $contentFile;
	/**
	 * @var array
	 */
	protected $vars = [];
	
	/**
	 * @param $var
	 * @param $value
	 */
	public function addVar( $var, $value ) {
		if ( !is_string( $var ) || is_numeric( $var ) || empty( $var ) ) {
			throw new \InvalidArgumentException( 'Le nom de la variable doit être une chaine de caractères non nulle' );
		}
		
		$this->vars[ $var ] = $value;
	}
	
	/**
	 * @return string
	 */
	public function getGeneratedPage() {
		if ( !file_exists( $this->contentFile ) ) {
			throw new \RuntimeException( 'La vue spécifiée n\'existe pas' );
		}
		
		$user = $this->app->getUser();
		
		extract( $this->vars );
		ob_start();
		require $this->contentFile;
		$content = ob_get_clean();
		
		ob_start();
		require __DIR__ . '/../../App/' . $this->app->getName() . '/Templates/layout.php';
		
		return ob_get_clean();
	}
	
	/**
	 * @param $contentFile
	 */
	public function setContentFile( $contentFile ) {
		if ( !is_string( $contentFile ) || empty( $contentFile ) ) {
			throw new \InvalidArgumentException( 'La vue spécifiée est invalide' );
		}
		
		$this->contentFile = $contentFile;
	}
}