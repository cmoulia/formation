<?php

namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;
use \OCFram\ExistingValidator;

class CommentFormBuilder extends FormBuilder {
	/** @var \Entity\Comment $entity */
	protected $entity;
	
	public function build() {
		// If the user is already connected, don't ask him his name, we already know it
		if ( !$this->user->isAuthenticated() ) {
			$this->form->add( new StringField( [
				'label'      => 'Auteur',
				'name'       => 'author',
				'maxLength'  => 50,
				'validators' => [
					new MaxLengthValidator( 'L\'auteur spécifié est trop long (50 caractères maximum)', 50 ),
					new NotNullValidator( 'Merci de spécifier l\'auteur du commentaire' ),
					// errorMessage, array containing the list of all users, and a new instance of User, cause the class need one (supposed to be the current user, here we have no user
					new ExistingValidator( 'L\'utilisateur n\'est pas disponible', $this->manager, 'username', ( $this->user->isAuthenticated() ) ? $this->entity->author() : null ),
				],
			] ) );
		}
		$this->form->add( new TextField( [
			'label'      => 'Contenu',
			'name'       => 'content',
			'rows'       => 7,
			'cols'       => 50,
			'validators' => [
				new NotNullValidator( 'Merci de spécifier votre commentaire' ),
			],
		] ) );
	}
}