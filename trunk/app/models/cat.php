<?php
class Cat extends AppModel
{
	var $name = 'Cat';

	var $actsAs = array(
		'Translate' => array(
			'name', 'description'
		)
	);

	// Use a different model
	var $translateModel = 'CatTranslation';
	
	// Use a different table for translateModel
	var $translateTable = 'cat_translations';
		
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