<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class ShippingMethod extends AppModel {
	var $name = 'ShippingMethod';
	var $hasMany = array('ShippingMethodValue' => array('dependent' => true));
}
?>