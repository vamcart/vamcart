<?php
class Categorie extends AppModel
{
	var $name = 'Categorie';

	var $actsAs = array(
		'Translate' => array(
			'name', 'description'
		)
	);

	// Use a different model
	var $translateModel = 'CategorieTranslation';
	
	// Use a different table for translateModel
	var $translateTable = 'categorie_translations';
		
	var $validate = array(
		'name' => array(
			'rule' => 'notEmpty'
		),
		'description' => array(
			'rule' => 'notEmpty'
		)
	);
}
?>