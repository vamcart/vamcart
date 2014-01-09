<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

App::uses('Model', 'AppModel');
class AttributeDescription extends AppModel {

	public $name = 'AttributeDescription';
	public $belongsTo = array('Language');
	public $primaryKey = 'dsc_id';
	public $validate = array(
		'attribute_id' => array(
			'rule' => 'notEmpty'
		)
	);
}
