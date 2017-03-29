<?php

namespace Entity;

use \OCFram\Entity;

class News extends Entity {
	const INVALID_AUTHOR  = 1;
	const INVALID_ADMIN   = 2;
	const INVALID_TITLE   = 3;
	const INVALID_CONTENT = 4;
	/** @var string $prefix Table prefix (used in the constructor) */
	protected $prefix = 'NNC_';
	protected $fk_MEM_author, $fk_MEM_admin, $title, $content, $dateadd, $dateupdate;
	
	public function isValid() {
		return !( ( empty( $this->fk_MEM_author ) && empty( $this->fk_MEM_admin ) ) || empty( $this->title ) || empty( $this->content ) );
	}
	
	// SETTERS //
	
	public function setFk_MEM_author( $fk_MEM_author ) {
		if ( !is_int( $fk_MEM_author ) || empty( $fk_MEM_author ) ) {
			$this->errors[] = self::INVALID_AUTHOR;
		}
		$this->fk_MEM_author = $fk_MEM_author;
	}
	
	public function setFk_MEM_admin( $fk_MEM_admin ) {
		if ( !is_int( $fk_MEM_admin ) ) {
			$this->errors[] = self::INVALID_ADMIN;
		}
		$this->fk_MEM_admin = $fk_MEM_admin;
	}
	
	public function setTitle( $title ) {
		if ( !is_string( $title ) || empty( $title ) ) {
			$this->errors[] = self::INVALID_TITLE;
		}
		$this->title = $title;
	}
	
	public function setContent( $content ) {
		if ( !is_string( $content ) || empty( $content ) ) {
			$this->errors[] = self::INVALID_CONTENT;
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
	
	public function fk_MEM_author() {
		return $this->fk_MEM_author;
	}
	
	public function fk_MEM_admin() {
		return $this->fk_MEM_admin;
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
	
	public function jsonSerialize() {
		return [
			'id' => $this->id,
			'fk_MEM_author' => $this->fk_MEM_author,
			'fk_MEM_admin' => $this->fk_MEM_admin,
			'title' => $this->title,
			'content' => $this->content,
			'dateadd' => $this->dateadd,
			'dateupdate' => $this->dateupdate,
		];
	}
}