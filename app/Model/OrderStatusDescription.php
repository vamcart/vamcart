<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class OrderStatusDescription extends AppModel {
	public $name = 'OrderStatusDescription';
	public $belongsTo = array('OrderStatus','Language');
}
?>