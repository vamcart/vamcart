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
				'PaymentMethod',
				'BillCountry' => array(
					'className' => 'Country',
					'foreignKey' => 'bill_country'
				),
				'BillState' => array(
					'className' => 'CountryZone',
					'foreignKey' => 'bill_state'
				),
				'ShipCountry' => array(
					'className' => 'Country',
					'foreignKey' => 'ship_country'
				),
				'ShipState' => array(
					'className' => 'CountryZone',
					'foreignKey' => 'ship_state'
				));

	public $hasMany = array('OrderProduct' => array('dependent' => true),
						 'OrderComment' => array('dependent' => true));
}
?>