<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('AppController', 'Controller');

class PaymentAppController extends AppController 
{
	
	function credit_card_fields ()
	{
		$cc_fields = $this->requestAction('/Payment/CreditCard/display_fields/',array('return'));
		return $cc_fields;
	}
	
}
?>