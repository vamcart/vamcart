<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class OrderStatus extends AppModel {

	var $name = 'OrderStatus';
	var $hasMany = array('OrderStatusDescription' => array('dependent'     => true),'Order');

}
?>