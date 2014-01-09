<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
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