<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class ShippingMethod extends AppModel {
	var $name = 'ShippingMethod';
	var $hasMany = array('ShippingMethodValue' => array('dependent' => true));
}
?>