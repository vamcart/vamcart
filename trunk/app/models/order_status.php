<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class OrderStatus extends AppModel {

	var $name = 'OrderStatus';
	var $hasMany = array('OrderStatusDescription' => array('dependent'     => true),'Order');

}
?>