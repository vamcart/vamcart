<?php
class Post extends AppModel
{
	var $name = 'Post';

	var $actsAs = array(
		'Translate' => array(
			'title', 'body'
		)
	);
	
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