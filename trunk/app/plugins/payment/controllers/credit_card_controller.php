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

	function install()
	{

		$new_module = array();
		$new_module['PaymentMethod']['active'] = '1';
		$new_module['PaymentMethod']['default'] = '0';
		$new_module['PaymentMethod']['name'] = 'Credit Card';
		$new_module['PaymentMethod']['alias'] = 'credit_card';
		$this->PaymentMethod->save($new_module);

		$this->Session->setFlash(__('Module Installed', true));
		$this->redirect('/payment_methods/admin/');
	}

	function uninstall()
	{

		$module_id = $this->PaymentMethod->findByAlias('credit_card');

		$this->PaymentMethod->del($module_id['PaymentMethod']['id'], true);
			
		$this->Session->setFlash(__('Module Uninstalled', true));
		$this->redirect('/payment_methods/admin/');
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