<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
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