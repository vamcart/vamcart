<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class PaymentMethod extends AppModel {
	var $name = 'PaymentMethod';
	var $hasMany = array('PaymentMethodValue' => array('dependent' => true));
}
?>