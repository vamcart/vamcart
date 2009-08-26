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

class AuthorizeController extends PaymentAppController {
	var $components = array('OrderBase');
	var $uses = null;

	function settings ()
	{
	}
	
	function process_payment ()
	{
		App::import('Model', 'PaymentMethod');
		$this->PaymentMethod =& new PaymentMethod();
		
		$authorize_login = $this->PaymentMethod->PaymentMethodValue->find(array('key' => 'authorize_login'));
		$login = $authorize_login['PaymentMethodValue']['value'];
		
		$this->redirect('/orders/place_order/');
	}
	
	function before_process ()
	{
		$order = $this->OrderBase->get_order();
	   	
		$authorize_login = $this->PaymentMethod->PaymentMethodValue->find(array('key' => 'authorize_login'));
		$login = $authorize_login['PaymentMethodValue']['value'];
	
		$content = '<form action="' . BASE . '/payment/authorize/process_payment/" method="post">';

			$content .= $this->credit_card_fields();
		
		$content .= '
		</form>';
		return $content;		
		
	}
	
}
?>