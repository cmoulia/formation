<?php

namespace Entity;

use \OCFram\Entity;

class Comment extends Entity {
	const AUTEUR_INVALIDE  = 1;
	const CONTENU_INVALIDE = 2;
	protected $prefix = 'NCC_';
	protected $fk_NNC, $author, $content, $dateadd;
	
	public function isValid() {
		return !( empty( $this->author ) || empty( $this->content ) );
	}
	
	public function setFk_NNC( $fk_NNC ) {
		$this->fk_NNC = (int)$fk_NNC;
	}
	
	public function setAuthor( $author ) {
		if ( !is_string( $author ) || empty( $author ) ) {
			$this->errors[] = self::AUTEUR_INVALIDE;
		}
		
		$this->author = $author;
	}
	
	public function setContent( $content ) {
		if ( !is_string( $content ) || empty( $content ) ) {
			$this->errors[] = self::CONTENU_INVALIDE;
		}
		
		$this->content = $content;
	}
	
	public function setDateadd( \DateTime $dateadd ) {
		$this->dateadd = $dateadd;
	}
	
	public function fk_NNC() {
		return $this->fk_NNC;
	}
	
	public function author() {
		return $this->author;
	}
	
	public function content() {
		return $this->content;
	}
	
	public function dateadd() {
		return $this->dateadd;
	}
}