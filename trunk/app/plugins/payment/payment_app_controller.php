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

class PaymentAppController extends AppController 
{

	function credit_card_fields ()
	{
		ob_start();
		$this->requestAction('/payment/credit_card/display_fields/',array('return'));
		$cc_fields = @ob_get_contents();
		ob_end_clean();
		return $cc_fields;
	}

}
?>