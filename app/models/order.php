<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class Order extends AppModel {
	var $name = 'Order';
	
	var $belongsTo = array('OrderStatus',
						   'ShippingMethod',
						   'PaymentMethod');
						   
	var $hasMany = array('OrderProduct' => array('dependent' => true),
						 'OrderComment' => array('dependent' => true));
}
?>