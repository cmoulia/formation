<?php

namespace Entity;

use OCFram\Entity;

class Role extends Entity {
	const INVALID_NAME = 1;
	const INVALID_DESCRIPTION = 2;
	
	protected $prefix = 'MRC_';
	protected $name, $description;
	
	public function isValid(){
		return !(empty($this->name) || empty($this->description));
	}
	
	public function setName($name){
		if (!is_string($name) || empty($name))
			$this->errors[] = self::INVALID_NAME;
		
		$this->name = $name;
	}
	
	public function setDescription($description){
		if (!is_string($description) || empty($description))
			$this->errors[] = self::INVALID_DESCRIPTION;
		
		$this->description = $description;
	}
	
	public function name(){
		return $this->name;
	}
	
	public function description(){
		return $this->description;
	}
}