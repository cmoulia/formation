<?php

namespace Entity;

use \OCFram\Entity;

class Comment extends Entity{
	const INVALID_AUTHOR = 1;
	const INVALID_CONTENT = 2;
	const INVALID_ADMIN = 3;
	/** @var string $prefix Table prefix (used in the constructor) */
	protected $prefix = 'NCC_';
	protected $fk_NNC, $author, $fk_MEM_author, $fk_MEM_admin, $content, $dateadd, $dateupdate;
	
	public function isValid() {
		return !( ( empty( $this->author ) && empty( $this->fk_MEM_author ) ) || empty( $this->content ) );
	}
	
	// SETTERS //
	
	public function setFk_NNC( $fk_NNC ) {
		$this->fk_NNC = (int)$fk_NNC;
	}
	
	public function setAuthor( $author ) {
		if ( !is_string( $author ) || empty( $author ) ) {
			$this->errors[] = self::INVALID_AUTHOR;
		}
		$this->author = $author;
	}
	
	public function setFk_MEM_author( $author ) {
		if ( !is_int( $author ) || empty( $author ) ) {
			$this->errors[] = self::INVALID_AUTHOR;
		}
		$this->fk_MEM_author = $author;
	}
	
	public function setFk_MEM_admin( $admin ) {
		if ( !is_string( $admin ) || empty( $admin ) ) {
			$this->errors[] = self::INVALID_ADMIN;
		}
		$this->fk_MEM_admin = $admin;
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
	
	public function fk_NNC() {
		return $this->fk_NNC;
	}
	
	public function author() {
		return $this->author;
	}
	
	public function fk_MEM_author() {
		return $this->fk_MEM_author;
	}
	
	public function fk_MEM_admin() {
		return $this->fk_MEM_admin;
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
	
	/**
	 * Specify data which should be serialized to JSON
	 *
	 * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 *        which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	public function jsonSerialize() {
		return [
			'id' => $this->id,
			'fk_NNC' => $this->fk_NNC,
			'author' => $this->author,
			'fk_MEM_author' => $this->fk_MEM_author,
			'fk_MEM_admin' => $this->fk_MEM_admin,
			'content' => $this->content,
			'dateadd' => $this->dateadd,
			'dateupdate' => $this->dateupdate,
		];
	}
}