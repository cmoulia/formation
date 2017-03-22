<?php

namespace FormBuilder;

use OCFram\FormBuilder;
use OCFram\MaxLengthValidator;
use OCFram\NotNullValidator;
use OCFram\StringField;

class RoleFormBuilder extends FormBuilder {
	public function build() {
		$this->form->add( new StringField( [
			'label' => 'Nom',
			'name' => 'name',
			'maxLength' => 50,
			'validators' => [
				new MaxLengthValidator( 'Le nom du rôle spécifié est trop long (50 caractères maximum)', 50 ),
				new NotNullValidator( 'Merci de spécifier le nom du rôle' ),
			],
		] ) )->add( new StringField( [
			'label'=>'Description',
			'name'=>'description',
			'maxLength' => 200,
			'validators' => [
				new MaxLengthValidator( 'La description du rôle est trop longue (200 caractères maximum)', 200 ),
				new NotNullValidator( 'Merci de spécifier une description pour le rôle' ),
			],
		] ) );
	}
}