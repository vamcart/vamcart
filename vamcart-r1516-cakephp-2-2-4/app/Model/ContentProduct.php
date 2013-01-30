<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class ContentProduct extends AppModel {
	public $name = 'ContentProduct';
	public $belongsTo = array('Tax');
	
	public $validate = array(
	'price' => array(
		'rule' => 'notEmpty'
	),
	'weight' => array(
		'rule' => 'notEmpty'
	),
	'stock' => array(
		'rule' => 'notEmpty'
	)
	);
	
}
?>