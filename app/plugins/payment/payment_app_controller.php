<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2009 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class PaymentAppController extends AppController 
{
	var $layout = 'dummy';
	
	function credit_card_fields ()
	{
		$cc_fields = $this->requestAction('/payment/credit_card/display_fields/',array('return'));
		return $cc_fields;
	}
	
}
?>