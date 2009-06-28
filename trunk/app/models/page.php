<?php
class Post extends AppModel
{
	var $name = 'Post';

	var $actsAs = array(
		'Translate' => array(
			'title', 'body'
		)
	);

	// Use a different model
	var $translateModel = 'PostI18n';
	
	// Use a different table for translateModel
	var $translateTable = 'post_translations';
		
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