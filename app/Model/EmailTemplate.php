<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class EmailTemplate extends AppModel {

	public $name = 'EmailTemplate';
	public $hasMany = array('EmailTemplateDescription' => array('dependent'     => true));

}
?>