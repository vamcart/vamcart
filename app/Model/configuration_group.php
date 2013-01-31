<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class ConfigurationGroup extends AppModel {
	var $name = 'ConfigurationGroup';
	var $hasMany = array('Configuration' => array('dependent' => true));	
}
?>