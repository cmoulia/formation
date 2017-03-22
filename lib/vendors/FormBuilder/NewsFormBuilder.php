<?php

namespace FormBuilder;

use \OCFram\FormBuilder;
use \OCFram\StringField;
use \OCFram\TextField;
use \OCFram\MaxLengthValidator;
use \OCFram\NotNullValidator;

class NewsFormBuilder extends FormBuilder {
	public function build() {
		if ( !$this->authenticated() ) {
			$this->form->add( new StringField( [
				'label'      => 'Auteur',
				'name'       => 'author',
				'maxLength'  => 20,
				'validators' => [
					new MaxLengthValidator( 'L\'auteur spécifié est trop long (20 caractères maximum)', 20 ),
					new NotNullValidator( 'Merci de spécifier l\'auteur de la news' ),
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
			],
		] ) )->add( new TextField( [
			'label'      => 'Contenu',
			'name'       => 'content',
			'rows'       => 8,
			'cols'       => 60,
			'validators' => [
				new NotNullValidator( 'Merci de spécifier le contenu de la news' ),
			],
		] ) );
	}
}