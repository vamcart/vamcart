<?php
class Language extends AppModel
{
	var $name = 'Language';

	var $validate = array(
		'name' => array(
			'rule' => 'notEmpty'
		),
		'code' => array(
			'rule' => 'notEmpty'
		)
	);
}
?>