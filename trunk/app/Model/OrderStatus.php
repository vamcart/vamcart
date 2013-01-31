<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class OrderStatus extends AppModel {

	public $name = 'OrderStatus';
	public $hasMany = array('OrderStatusDescription' => array('dependent'     => true),'Order');

}
?>