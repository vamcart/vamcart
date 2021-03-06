<?php 
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
App::uses('PaymentAppController', 'Payment.Controller');

class InvoiceController extends PaymentAppController {
	public $uses = array('PaymentMethod', 'Order');
	public $helpers = array('Time', 'Summa');
	public $module_name = 'Invoice';
	public $icon = 'invoice.png';

	public function settings ()
	{
		$this->set('data', $this->PaymentMethod->findByAlias($this->module_name));
	}

	public function install()
	{
		$new_module = array();
		$new_module['PaymentMethod']['active'] = '1';
		$new_module['PaymentMethod']['default'] = '0';
		$new_module['PaymentMethod']['name'] = Inflector::humanize($this->module_name);
		$new_module['PaymentMethod']['icon'] = $this->icon;
		$new_module['PaymentMethod']['alias'] = $this->module_name;

		$new_module['PaymentMethodValue'][0]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][0]['key'] = 'bank_name';
		$new_module['PaymentMethodValue'][0]['value'] = '';

		$new_module['PaymentMethodValue'][1]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][1]['key'] = 'bank_account1';
		$new_module['PaymentMethodValue'][1]['value'] = '';

		$new_module['PaymentMethodValue'][2]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][2]['key'] = 'bik';
		$new_module['PaymentMethodValue'][2]['value'] = '';

		$new_module['PaymentMethodValue'][3]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][3]['key'] = 'bank_account2';
		$new_module['PaymentMethodValue'][3]['value'] = '';

		$new_module['PaymentMethodValue'][4]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][4]['key'] = 'inn';
		$new_module['PaymentMethodValue'][4]['value'] = '';

		$new_module['PaymentMethodValue'][5]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][5]['key'] = 'recipient';
		$new_module['PaymentMethodValue'][5]['value'] = '';

		$new_module['PaymentMethodValue'][6]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][6]['key'] = 'kpp';
		$new_module['PaymentMethodValue'][6]['value'] = '';

		$new_module['PaymentMethodValue'][7]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][7]['key'] = 'payment_text';
		$new_module['PaymentMethodValue'][7]['value'] = '';

		$new_module['PaymentMethodValue'][8]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][8]['key'] = 'address';
		$new_module['PaymentMethodValue'][8]['value'] = '';

		$new_module['PaymentMethodValue'][9]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][9]['key'] = 'phone';
		$new_module['PaymentMethodValue'][9]['value'] = '';

		$new_module['PaymentMethodValue'][10]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][10]['key'] = 'ogrn';
		$new_module['PaymentMethodValue'][10]['value'] = '';

		$new_module['PaymentMethodValue'][11]['payment_method_id'] = $this->PaymentMethod->id;
		$new_module['PaymentMethodValue'][11]['key'] = 'okpo';
		$new_module['PaymentMethodValue'][11]['value'] = '';

		$this->PaymentMethod->saveAll($new_module);

		$this->Session->setFlash(__('Module Installed'));
		$this->redirect('/payment_methods/admin/');
	}

	public function uninstall()
	{

		$module_id = $this->PaymentMethod->findByAlias($this->module_name);

		$this->PaymentMethod->delete($module_id['PaymentMethod']['id'], true);
			
		$this->Session->setFlash(__('Module Uninstalled'));
		$this->redirect('/payment_methods/admin/');
	}

	public function before_process () 
	{
		$content = '
		<a class="btn btn-default" href="' . FULL_BASE_URL . BASE . '/payment/invoice/print_invoice/' . $_SESSION['Customer']['order_id'] . '" target="_blank"><i class="fa fa-print"></i> {lang}Print Invoice{/lang}</a>
		<a class="btn btn-default" href="' . FULL_BASE_URL . BASE . '/payment/invoice/print_packing_slip/' . $_SESSION['Customer']['order_id'] . '" target="_blank"><i class="fa fa-print"></i> {lang}Print Packing Slip{/lang}</a><br /><br />
		<form action="' . BASE . '/orders/place_order/" method="post">
		<button class="btn btn-default" type="submit" value="{lang}Confirm Order{/lang}"><i class="fa fa-check"></i> {lang}Confirm Order{/lang}</button>
		</form>';
		return $content;	
	}

	public function payment_after($order_id = 0)
	{
	}

	public function after_process()
	{
	}
	
	
	public function print_invoice($id)
	{
		$this->layout = 'print';		
		$this->set('title_for_layout', __('Order Number') . ': ' . $_SESSION['Customer']['order_id']);		
		
		$this->set('data', $this->Order->find('first', array('conditions' => array('Order.id' => $_SESSION['Customer']['order_id']))));
		$this->set('payment_data', $this->PaymentMethod->findByAlias($this->module_name));
		$this->set('counter', 0);
		
	}

	public function print_packing_slip($id)
	{
		$this->layout = 'print';		
		$this->set('title_for_layout', __('Order Number') . ': ' . $_SESSION['Customer']['order_id']);		
		
		$this->set('data', $this->Order->find('first', array('conditions' => array('Order.id' => $_SESSION['Customer']['order_id']))));
		$this->set('payment_data', $this->PaymentMethod->findByAlias($this->module_name));
		$this->set('counter', 0);
		
	}
	
}

?>