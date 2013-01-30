<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class Order extends AppModel {
	public $name = 'Order';

	public $belongsTo = array('OrderStatus',
				'ShippingMethod',
				'PaymentMethod');

	public $hasMany = array('OrderProduct' => array('dependent' => true),
						 'OrderComment' => array('dependent' => true));
}
?>