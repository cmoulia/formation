<?php

namespace FormBuilder;

use \OCFram\FormBuilder;
use OCFram\NoTagsValidator;
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
					// errorMessage, User manager, field for the query, and null
					new ExistingValidator( 'L\'utilisateur n\'est pas disponible', $this->manager, 'checkExistencyByUsername', null ),
					new NoTagsValidator( 'Le nom d\'auteur n\'est pas valide' ),
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
				new NoTagsValidator( 'Le contenu n\'est pas valide' ),
			],
		] ) );
	}
}