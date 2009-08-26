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

class CreditCardController extends PaymentAppController {
	var $uses = null;

	function settings ()
	{
	}

	function display_fields ()
	{
	}

	function process_payment ()
	{
		App::import('Component', 'CustomerBase');		
		$this->CustomerBase =& new CustomerBaseComponent();
		
		$this->CustomerBase->save_customer_details($this->data['CreditCard']);
		
		$this->redirect('/orders/place_order/');
	}

	function before_process () 
	{
	
		$content = '<form action="' . BASE . '/payment/credit_card/process_payment/" method="post">';

			$content .= $this->credit_card_fields();
		
		$content .= '
		
		</form>';
		return $content;	
	}
}

?>