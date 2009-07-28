<?php
/* -----------------------------------------------------------------------------------------
   VaM Shop
   http://vamshop.com
   http://vamshop.ru
   Copyright 2009 VaM Shop
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
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