<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class OrderStatusDescription extends AppModel {
	var $name = 'OrderStatusDescription';
	var $belongsTo = array('OrderStatus','Language');
}
?>