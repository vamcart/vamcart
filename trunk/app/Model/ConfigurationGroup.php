<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class ConfigurationGroup extends AppModel {
	public $name = 'ConfigurationGroup';
	public $hasMany = array('Configuration' => array('dependent' => true));	
}
?>