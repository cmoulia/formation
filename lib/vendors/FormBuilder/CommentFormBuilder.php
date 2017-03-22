<?php

namespace FormBuilder;

use \OCFram\ExistingUserValidator;
use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;

class CommentFormBuilder extends FormBuilder {
	public function build() {
		if ( !$this->authenticated() ) {
			$this->form->add( new StringField( [
				'label'      => 'Auteur',
				'name'       => 'author',
				'maxLength'  => 50,
				'validators' => [
					new MaxLengthValidator( 'L\'auteur spécifié est trop long (50 caractères maximum)', 50 ),
					new NotNullValidator( 'Merci de spécifier l\'auteur du commentaire' ),
					new ExistingUserValidator( 'L\'utilisateur n\'est pas disponible', $this->manager->getList() ),
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