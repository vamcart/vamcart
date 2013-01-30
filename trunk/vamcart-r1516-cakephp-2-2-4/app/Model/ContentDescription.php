<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class ContentDescription extends AppModel {

	public $name = 'ContentDescription';
	public $belongsTo = array('Language');
	
	public $validate = array(
		'content_id' => array(
			'rule' => 'notEmpty'
		)
	);
}
