<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class ShippingMethod extends AppModel {
	var $name = 'ShippingMethod';
	var $hasMany = array('ShippingMethodValue' => array('dependent' => true));
}
?>