<?php
class Product extends AppModel
{
	var $name = 'Product';

	var $actsAs = array(
		'Translate' => array(
			'name', 'description'
		)
	);

	// Use a different model
	var $translateModel = 'ProductTranslation';
	
	// Use a different table for translateModel
	var $translateTable = 'product_translations';
		
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