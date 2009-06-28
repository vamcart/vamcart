<?php
class Page extends AppModel
{
	var $name = 'Page';

	var $actsAs = array(
		'Translate' => array(
			'title', 'body'
		)
	);

	// Use a different model
	var $translateModel = 'PageTranslation';
	
	// Use a different table for translateModel
	var $translateTable = 'page_translations';
		
	var $validate = array(
		'title' => array(
			'rule' => 'notEmpty'
		),
		'body' => array(
			'rule' => 'notEmpty'
		)
	);
}
?>