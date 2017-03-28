<?php
namespace OCFram;

class Page extends ApplicationComponent {
	protected $contentFile;
	protected $vars = [];
	protected $format;
	
	public function __construct( Application $app, $format ) {
		parent::__construct( $app );
		$this->format = $format;
	}
	
	public function addVar( $var, $value ) {
		if ( !is_string( $var ) || is_numeric( $var ) || empty( $var ) ) {
			throw new \InvalidArgumentException( 'Le nom de la variable doit être une chaine de caractères non nulle' );
		}
		$this->vars[ $var ] = $value;
	}
	
	public function getGeneratedPage() {
		if ( !file_exists( $this->contentFile ) ) {
			throw new \RuntimeException( 'La vue spécifiée n\'existe pas: ' . $this->contentFile );
		}
		switch ($this->format){
			case 'html':
				return $this->getGeneratedPageHTML();
				break;
			case 'json':
				return $this->getGeneratedPageJSON();
				break;
			default:
				throw new \RuntimeException('Le format '.$this->format.' n\est pas encore géré');
		}
		
	}
	
	private function getGeneratedPageHTML() {
		if ( !file_exists( $this->contentFile ) ) {
			throw new \RuntimeException( 'La vue spécifiée n\'existe pas: ' . $this->contentFile );
		}
		
		/** @var User $user */
		$user = $this->app->user();
		
		extract( $this->vars );
		
		ob_start();
		require $this->contentFile;
		$content = ob_get_clean();
		
		ob_start();
		require __DIR__ . '/../../App/' . $this->app->name() . '/Templates/layout.html.php';
		
		return ob_get_clean();
	}
	
	private function getGeneratedPageJSON() {
		
		/** @var User $user */
		$user = $this->app->user();
		
		extract( $this->vars );
		
		$content = require $this->contentFile;
		
		return json_encode(require __DIR__ . '/../../App/' . $this->app->name() . '/Templates/layout.json.php');
	}
	
	public function setContentFile( $contentFile ) {
		if ( !is_string( $contentFile ) || empty( $contentFile ) ) {
			throw new \InvalidArgumentException( 'La vue spécifiée est invalide' );
		}
		
		$this->contentFile = $contentFile;
	}
	
	public function format() {
		return $this->format;
	}
	
	public function setFormat( $format ) {
		if ( !is_string( $format ) || empty( $format ) ) {
			throw new \InvalidArgumentException( 'Le format de la vue est invalide' );
		}
		
		$this->format = $format;
	}
}