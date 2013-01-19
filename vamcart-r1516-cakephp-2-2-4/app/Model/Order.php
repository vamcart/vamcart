<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('Model', 'AppModel');
class Order extends AppModel {
	var $name = 'Order';

	var $belongsTo = array('OrderStatus',
				'ShippingMethod',
				'PaymentMethod');

	var $hasMany = array('OrderProduct' => array('dependent' => true),
						 'OrderComment' => array('dependent' => true));
}
?>