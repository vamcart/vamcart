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
	var $uses = array('PaymentMethod');

	function settings ()
	{
		$this->set('data', $this->PaymentMethod->find(array('alias' => 'authorize')));
	}

	function install()
	{

		$new_module = array();
		$new_module['PaymentMethod']['active'] = '1';
		$new_module['PaymentMethod']['name'] = 'Authorize.Net';
		$new_module['PaymentMethod']['alias'] = 'authorize';
		$this->PaymentMethod->save($new_module);

		$new_module_values = array();
		$new_module_values['PaymentMethodValue']['payment_method_id'] = $this->PaymentMethod->id;
		$new_module_values['PaymentMethodValue']['key'] = 'authorize_login';
		$new_module_values['PaymentMethodValue']['value'] = 'your-authorize-id';

		$this->PaymentMethod->PaymentMethodValue->save($new_module_values);
			
		$this->Session->setFlash(__('Module Installed', true));
		$this->redirect('/payment_methods/admin/');
	}

	function uninstall()
	{

		$module_id = $this->PaymentMethod->findByAlias('authorize');

		$this->PaymentMethod->del($module_id['PaymentMethod']['id'], true);
			
		$this->Session->setFlash(__('Module Uninstalled', true));
		$this->redirect('/payment_methods/admin/');
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