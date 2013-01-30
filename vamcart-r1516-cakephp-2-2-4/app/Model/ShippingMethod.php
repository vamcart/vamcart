<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class ShippingMethod extends AppModel {
	public $name = 'ShippingMethod';
	public $hasMany = array('ShippingMethodValue' => array('dependent' => true));
}
?>