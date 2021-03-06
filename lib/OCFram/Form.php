<?php

namespace OCFram;

class Form {
	protected $entity;
	protected $fields = [];
	
	public function __construct( Entity $entity ) {
		$this->setEntity( $entity );
	}
	
	public function setEntity( Entity $entity ) {
		$this->entity = $entity;
	}
	
	public function add( Field $field ) {
		$attr = $field->name(); // On récupère le nom du champ.
		if ( is_callable( [
			$this->entity,
			$attr,
		] ) ) {
			$field->setValue( $this->entity->$attr() ); // On assigne la valeur correspondante au champ.
		}
		elseif ( isset( $_POST[ $attr ] ) ) {
			$field->setValue( $_POST[ $attr ] ); // On assigne la valeur correspondante au champ.
		}
		
		$this->fields[] = $field; // On ajoute le champ passé en argument à la liste des champs.
		
		return $this;
	}
	
	public function getFields() {
		return $this->fields;
	}
	
	public function getField( $name ) {
		foreach ( $this->fields as $field ) {
			if ( $field->name() == $name ) {
				return $field;
			}
		}
		
		return null;
	}
	
	public function createView() {
		$view = '';
		
		// On génère un par un les champs du formulaire.
		foreach ( $this->fields as $field ) {
			$view .= $field->buildWidget() . '<br />';
		}
		
		return $view;
	}
	
	public function isValid() {
		$valid = true;
		
		// On vérifie que tous les champs sont valides.
		foreach ( $this->fields as $field ) {
			if ( !$field->isValid() ) {
				$valid = false;
			}
		}
		
		return $valid;
	}
	
	public function entity() {
		return $this->entity;
	}
}