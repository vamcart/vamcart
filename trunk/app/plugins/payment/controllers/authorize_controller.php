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
	var $module_name = 'authorize';

	function settings ()
	{
		$this->set('data', $this->PaymentMethod->findByAlias($this->module_name));
	}

	function install()
	{

		$new_module = array();
		$new_module['PaymentMethod']['active'] = '1';
		$new_module['PaymentMethod']['name'] = Inflector::humanize($this->module_name);
		$new_module['PaymentMethod']['alias'] = $this->module_name;

		$new_module['PaymentMethodValue'][0]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][0]['key'] = 'authorize_login';
		$new_module['PaymentMethodValue'][0]['value'] = 'your-authorize-id';

		$this->PaymentMethod->saveAll($new_module);
			
		$this->Session->setFlash(__('Module Installed', true));
		$this->redirect('/payment_methods/admin/');
	}

	function uninstall()
	{

		$module_id = $this->PaymentMethod->findByAlias($this->module_name);

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