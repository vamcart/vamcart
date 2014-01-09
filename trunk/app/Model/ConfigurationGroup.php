<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class ConfigurationGroup extends AppModel {
	public $name = 'ConfigurationGroup';
	public $hasMany = array('Configuration' => array('dependent' => true));	
}
?>