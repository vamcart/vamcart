<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class ContentManufacturer extends AppModel {
	public $name = 'ContentManufacturer';
	
	public $validate = array(
	'content_id' => array(
		'rule' => 'notBlank'
	)
	);
	
}
?>