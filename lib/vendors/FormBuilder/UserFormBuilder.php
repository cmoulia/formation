<?php

namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\DateField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;
use \OCFram\EqualsValidator;
use \OCFram\ExistingValidator;

class UserFormBuilder extends FormBuilder {
	/** @var \Model\UserManager $manager */
	protected $manager;
	/** @var \Entity\User $entity */
	protected $entity;
	
	public function build() {
		$this->form->add( new StringField( [
			'label'      => 'Nom d\'utilisateur',
			'name'       => 'username',
			'maxLength'  => 20,
			'validators' => [
				new MaxLengthValidator( 'Le nom d\'utilisateur spécifié est trop long (20 caractères maximum)', 20 ),
				new NotNullValidator( 'Merci de spécifier votre nom d\'utilisateur' ),
				new ExistingValidator( 'Le nom d\'utilisateur n\'est pas disponible', $this->manager, 'username', ( $this->user->isAuthenticated() ) ? $this->entity->username() : null ),
			],
		] ) )->add( new StringField( [
			'label'      => 'Mot de passe',
			'name'       => 'password',
			// HTML5 type, so password hidden
			'type'       => 'password',
			'maxLength'  => 100,
			'validators' => [
				new MaxLengthValidator( 'Le mot de passe spécifié est trop long (100 caractères maximum)', 100 ),
				new NotNullValidator( 'Merci de spécifier le mot de passe' ),
			],
		] ) )->add( new StringField( [
			'label'      => 'Confirmation du mot de passe',
			'name'       => 'password_verification',
			// HTML5 type, so password hidden
			'type'       => 'password',
			'maxLength'  => 100,
			'validators' => [
				new MaxLengthValidator( 'La confirmation de mot de passe spécifié est trop long (100 caractères maximum)', 100 ),
				new NotNullValidator( 'Merci de spécifier la vérification de mot de passe' ),
				new EqualsValidator( 'Mot de passe différent', $this->form->getField( 'password' ) ),
			],
		] ) )->add( new StringField( [
			'label'      => 'Email',
			'name'       => 'email',
			// HTML5 type, so email format
			'type'       => 'email',
			'maxLength'  => 100,
			'validators' => [
				new MaxLengthValidator( 'L\'adresse email spécifié est trop longue (100 caractères maximum)', 100 ),
				new NotNullValidator( 'Merci de spécifier l\'adresse email' ),
				new ExistingValidator( 'L\'adresse email n\'est pas disponible', $this->manager, 'email', ( $this->user->isAuthenticated() ) ? $this->entity->email() : null ),
			
			],
		] ) )->add( new StringField( [
			'label'      => 'Confirmation de l\'email',
			'name'       => 'email_verification',
			// HTML5 type, so email format
			'type'       => 'email',
			'maxLength'  => 100,
			'validators' => [
				new MaxLengthValidator( 'L\'adresse email spécifié est trop longue (100 caractères maximum)', 100 ),
				new NotNullValidator( 'Merci de spécifier la vérification de l\'adresse email' ),
				new EqualsValidator( 'Adresse email différente', $this->form->getField( 'email' ) ),
			],
		] ) )->add( new StringField( [
			'label'      => 'Prénom',
			'name'       => 'firstname',
			'maxLength'  => 20,
			'validators' => [
				new MaxLengthValidator( 'Le prénom spécifié est trop long (20 caractères maximum)', 100 ),
				new NotNullValidator( 'Merci de spécifier le prénom' ),
			],
		] ) )->add( new StringField( [
			'label'      => 'Nom',
			'name'       => 'lastname',
			'maxLength'  => 20,
			'validators' => [
				new MaxLengthValidator( 'Le nom spécifié est trop long (20 caractères maximum)', 100 ),
				new NotNullValidator( 'Merci de spécifier le nom' ),
			],
		] ) )->add( new DateField( [
			'label'      => 'Date de naissance',
			'name'       => 'birthdate',
			'value'      => date( "Y-m-d" ),
			'validators' => [],
		] ) );
	}
}