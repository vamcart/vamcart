<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class ContentCategory extends AppModel {
	public $name = 'ContentCategory';
	
	public $validate = array(
	'content_id' => array(
		'rule' => 'notEmpty'
	)
	);
	
}
?>