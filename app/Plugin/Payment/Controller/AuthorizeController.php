<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class AuthorizeController extends PaymentAppController {
	var $components = array('OrderBase');
	var $uses = array('PaymentMethod', 'Order');
	var $module_name = 'Authorize';

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
			
		$this->Session->setFlash(__('Module Installed'));
		$this->redirect('/payment_methods/admin/');
	}

	function uninstall()
	{

		$module_id = $this->PaymentMethod->findByAlias($this->module_name);

		$this->PaymentMethod->delete($module_id['PaymentMethod']['id'], true);
			
		$this->Session->setFlash(__('Module Uninstalled'));
		$this->redirect('/payment_methods/admin/');
	}
	
	function process_payment ()
	{
		App::import('Model', 'PaymentMethod');
		$this->PaymentMethod =& new PaymentMethod();
		
		$authorize_login = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'authorize_login')));
		$login = $authorize_login['PaymentMethodValue']['value'];
		
		$this->redirect('/orders/place_order/');
	}
	
	function before_process ()
	{
		$order = $this->OrderBase->get_order();
	   	
		$authorize_login = $this->PaymentMethod->PaymentMethodValue->find('first', array('conditions' => array('key' => 'authorize_login')));
		$login = $authorize_login['PaymentMethodValue']['value'];
	
		$content = '
		<form action="' . BASE . '/orders/place_order/" method="post">
		<button class="btn btn-inverse" type="submit" value="{lang}Confirm Order{/lang}"><i class="icon-ok"></i> {lang}Confirm Order{/lang}</button>
		</form>';
		return $content;	
		
	}

	function after_process()
	{
		$payment_method = $this->PaymentMethod->find('first', array('conditions' => array('alias' => $this->module_name)));
		$order_data = $this->Order->find('first', array('conditions' => array('Order.id' => $_SESSION['Customer']['order_id'])));
		if ($payment_method['PaymentMethod']['order_status_id'] > 0) {
		$order_data['Order']['order_status_id'] = $payment_method['PaymentMethod']['order_status_id'];
		
		$this->Order->save($order_data);
		}
	}
	
}
?>