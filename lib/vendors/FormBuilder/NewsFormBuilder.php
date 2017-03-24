<?php

namespace FormBuilder;

use \OCFram\FormBuilder;
use OCFram\NoTagsValidator;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;

class NewsFormBuilder extends FormBuilder {
	public function build() {
		// If the user is already connected, don't ask him his name, we already know it
		if ( !$this->user->isAuthenticated() ) {
			$this->form->add( new StringField( [
				'label'      => 'Auteur',
				'name'       => 'fk_MEM_author',
				'maxLength'  => 20,
				'validators' => [
					new MaxLengthValidator( 'L\'auteur spécifié est trop long (20 caractères maximum)', 20 ),
					new NotNullValidator( 'Merci de spécifier l\'auteur de la news' ),
					new NoTagsValidator( 'Le nom d\'auteur n\'est pas valide' ),
				],
			] ) );
		}
		$this->form->add( new StringField( [
			'label'      => 'Titre',
			'name'       => 'title',
			'maxLength'  => 100,
			'validators' => [
				new MaxLengthValidator( 'Le titre spécifié est trop long (100 caractères maximum)', 100 ),
				new NotNullValidator( 'Merci de spécifier le titre de la news' ),
				new NoTagsValidator( 'Le titre n\'est pas valide' ),
			],
		] ) )->add( new TextField( [
			'label'      => 'Contenu',
			'name'       => 'content',
			'rows'       => 8,
			'cols'       => 60,
			'validators' => [
				new NotNullValidator( 'Merci de spécifier le contenu de la news' ),
				new NoTagsValidator( 'Le contenu n\'est pas valide' ),
			],
		] ) );
	}
}