<?php

namespace Entity;

use \OCFram\Entity;

class News extends Entity {
	const AUTEUR_INVALIDE  = 1;
	const TITRE_INVALIDE   = 2;
	const CONTENU_INVALIDE = 3;
	protected $prefix = 'NNC_';
	protected $author, $title, $content, $dateadd, $dateupdate;
	
	public function isValid() {
		return !( empty( $this->author ) || empty( $this->title ) || empty( $this->content ) );
	}
	
	// SETTERS //
	
	public function setAuthor( $author ) {
		if ( !is_string( $author ) || empty( $author ) ) {
			$this->errors[] = self::AUTEUR_INVALIDE;
		}
		
		$this->author = $author;
	}
	
	public function setTitle( $title ) {
		if ( !is_string( $title ) || empty( $title ) ) {
			$this->errors[] = self::TITRE_INVALIDE;
		}
		
		$this->title = $title;
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
	
	public function setDateupdate( \DateTime $dateupdate ) {
		$this->dateupdate = $dateupdate;
	}
	
	// GETTERS //
	
	public function author() {
		return $this->author;
	}
	
	public function title() {
		return $this->title;
	}
	
	public function content() {
		return $this->content;
	}
	
	public function dateadd() {
		return $this->dateadd;
	}
	
	public function dateupdate() {
		return $this->dateupdate;
	}
}