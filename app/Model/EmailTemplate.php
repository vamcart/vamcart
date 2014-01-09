<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class EmailTemplate extends AppModel {

	public $name = 'EmailTemplate';
	public $hasMany = array('EmailTemplateDescription' => array('dependent'     => true));

}
?>