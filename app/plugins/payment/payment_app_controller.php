<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class PaymentAppController extends AppController 
{
	
	function credit_card_fields ()
	{
		$cc_fields = $this->requestAction('/payment/credit_card/display_fields/',array('return'));
		return $cc_fields;
	}
	
}
?>